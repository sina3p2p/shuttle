<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{

    public $table = "shuttle_components";

    protected $fillable = ['name', 'settings', 'content', 'model_settings', 'model', 'icon', 'display_name'];

    protected $casts = ['settings' => 'array', 'model_settings' => 'array'];

    public function rows()
    {
        return $this->morphMany(ScaffoldinterfaceRow::class, 'rowable')->where('parent_id', 0);
    }
    
    public function allRows()
    {
        return $this->morphMany(ScaffoldinterfaceRow::class, 'rowable');
    }

    public function getComponentData($routes = [],$setting = [])
    {
        $setting = optional($this->pivot)->setting ?? [];
        // $setting['url'] = end($routes);
        $relations = $this->rows()->where('type', 'c_relationship')->get();
        foreach($relations as $rel)
        {
            $model = app($rel->details->model);
            $val = data_get($setting, $rel->details->column, []);
            if($val)
            {
                $m = app($rel->details->model)->whereIn($model->getTable().".".$rel->details->key, is_array($val) ? $val : [$val]);
                if(isset($rel->details->scope) && !empty($rel->details->scope))
                {
                    $m = $m->{$rel->details->scope}();
                }
                $setting[$rel->details->column] = $m->orderBy($model->getTable().".created_at")->get();
            }else{
                $setting[$rel->details->column] = [];
            }
        }
        if($this->model){
            $model = app($this->model);
            $data = $model;
            foreach (data_get($this->model_settings,'model.conditions',[]) as $con){
                $data = $data->{$con['type']}($con['field'], data_get($setting,$con['value'],$con['type'] == 'whereIn' ? [] : $con['value']));
            }
            $data = $data->with(data_get($this->model_settings,'model.relations',[]));
            $pag = data_get($this->model_settings,'model.limit',-1);
            if(data_get($this->model_settings,'model.scope',false))
            {
                // dd(data_get($this->component->model_settings,'model.scope'));
                $data = $data->{data_get($this->model_settings,'model.scope')}();
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
}
