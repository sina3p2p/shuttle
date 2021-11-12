<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Storage;

class PageComponent extends Pivot
{
    protected $fillable = ['setting', 'locale', 'position'];

    protected $casts = ['setting' => 'json'];

    protected $table = 'shuttle_page_component';

    // protected $appends = ['data'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->position = static::where('page_id',$model->page_id)->where('locale', $model->locale)->max('position') + 1;
        });
    }

    public function component()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Component');
    }

    public function page()
    {
        return $this->belongsTo('Sina\Shuttle\Models\Page');
    }

    public function getDataAttribute()
    {
        $setting = $this->setting ?? [];
        // $setting['url'] = end($routes);
        $relations = $this->component->rows()->where('type', 'c_relationship')->get();
        foreach($relations as $rel)
        {
            $model = app($rel->details['model']);
            $m = app($rel->details['model'])->whereIn($model->getTable().".".$rel->details['key'], data_get($setting, $rel->details['column'], []));
            if(isset($rel->details['scope']) && !empty($rel->details['scope']))
            {
                $m = $m->{$rel->details['scope']}();
            }
            $setting[$rel->details['column']] = $m->orderBy($model->getTable().".created_at")->get();
        }
        if($this->component->model){
            $model = app($this->component->model);
            $data = $model;
            foreach (data_get($this->component->model_settings,'model.conditions',[]) as $con){
                $data = $data->{$con['type']}($con['field'], data_get($setting,$con['value'],$con['type'] == 'whereIn' ? [] : $con['value']));
            }
            $data = $data->with(data_get($this->model_settings,'model.relations',[]));
            $pag = data_get($this->component->model_settings,'model.limit',-1);
            if(data_get($this->component->model_settings,'model.scope',false))
            {
                // dd(data_get($this->component->model_settings,'model.scope'));
                $data = $data->{data_get($this->component->model_settings,'model.scope')}();
            }
            switch($pag){
                case -1:
                    $data = $data->orderBy($model->getTable().".created_at")->get();
                    break;
                case 0:
                    $data = $data->first();
                    if($data && method_exists($data,'views')){
                        views($data)->record();
                    }
                    break;
                default:
                    $data = $data->orderBy($model->getTable().".created_at")->paginate($pag);
                    break;
            }
            $setting['model'] = $data;
        }

        return $setting;
    }

    public function getComponentData($routes = [],$setting = [])
    {
        $setting = $this->setting ?? [];
        $setting['url'] = end($routes);
        $relations = $this->component->rows()->get();
        foreach($relations as $rel)
        {
            if($rel->type == "relationship")
            {
                $setting[$rel->details['column']] = app($rel->details['model'])->whereIn($rel->details['key'], data_get($setting, $rel->details['column'], []))->latest()->get();
            }else if ($rel->type == "image")
            {
                $setting[$rel->field] = url(Storage::url(data_get($setting, $rel->field)));
            }
        }
        if($this->component->model){
            $data = app($this->component->model);
            foreach (data_get($this->component->model_settings,'model.conditions',[]) as $con){
                $data = $data->{$con['type']}($con['field'], data_get($setting,$con['value'],$con['type'] == 'whereIn' ? [] : $con['value']));
            }
            $data = $data->with(data_get($this->model_settings,'model.relations',[]));
            $pag = data_get($this->component->model_settings,'model.limit',-1);
            switch($pag){
                case -1:
                    $data = $data->latest()->get();
                    break;
                case 0:
                    $data = $data->first();
                    if($data && method_exists($data,'views')){
                        views($data)->record();
                    }
                    break;
                default:
                    $data = $data->latest()->paginate($pag);
                    break;
            }
            $setting['model'] = $data;
        }

        return $setting;
    }
}
