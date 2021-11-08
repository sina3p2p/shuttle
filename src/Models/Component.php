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

    public function getComponentData($routes = [],$setting = [])
    {
        $setting = optional($this->pivot)->setting ?? [];
        $setting['url'] = end($routes);
    //    dd($setting);
//        error_log($this->name);
        if($this->model){
            $data = app($this->model);
            foreach (data_get($this->model_settings,'model.conditions',[]) as $con){
                $data = $data->{$con['type']}($con['key'], data_get($setting,$con['value'],$con['type'] == 'whereIn' ? [] : $con['value']));
            }
            $data = $data->with(data_get($this->model_settings,'model.relations',[]));
            $pag = data_get($this->model_settings,'model.limit',-1);
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
//            $data = $data->latest()->take(3)->get();
            $setting['model'] = $data;
        }

        return $setting;
    }
}
