<?php

namespace Sina\Shuttle\View;

use Illuminate\View\Component;
use Illuminate\Support\Str;
use Sina\Shuttle\Models\Component as ModelsComponent;

class DynamicComponent extends Component
{

    protected $componentClass;

    protected array $data;

    protected string $view;

    protected array $props;

    public function __construct($name, $data = null, $model = null, $modelSetting = null, $modelAutoLoad = true)
    {
        $this->props = $data ?? [];
        $this->view = "components." . $name;
        $data = $data ?? [];
        if ($modelAutoLoad) {
            $m = (ModelsComponent::where('name', $name)->first());
            if ($m) {
                $m->rows()
                    ->where('type', 'c_relationship')
                    ->get()
                    ->each(function ($row) use (&$data) {
                        $model = app($row->details->model);
                        $val = data_get($data, $row->details->column, []);
                        if ($val) {
                            $m = app($row->details->model)->whereIn($model->getTable() . "." . $row->details->key, is_array($val) ? $val : [$val]);
                            if (isset($row->details->scope) && !empty($row->details->scope)) {
                                $m = $m->{$row->details->scope}();
                            }
                            $data[$row->details->column] = $m->orderBy($model->getTable() . ".created_at")->get();
                        } else {
                            $data[$row->details->column] = [];
                        }
                    });
            }
        }

        if ($modelSetting && $model) {
            $model = app($model);
            //                foreach (data_get($modelSetting,'model.conditions',[]) as $con){
            //                    $data = $data->{$con['type']}($con['field'], data_get($setting,$con['value'],$con['type'] == 'whereIn' ? [] : $con['value']));
            //                }
            //                $data = $data->with(data_get($this->model_settings,'model.relations',[]));
            $pag = data_get($modelSetting, 'limit', -1);
            //                if(data_get($modelSetting,'model.scope',false))
            //                {
            //                    // dd(data_get($this->component->model_settings,'model.scope'));
            //                    $data = $data->{data_get($this->model_settings,'model.scope')}();
            //                }
            switch ($pag) {
                case -1:
                    $data['model'] = $model->orderBy($model->getTable() . ".created_at")->get();
                    break;
                case 0:
                    $data['model'] = $model->first();
                    //                        if($data && method_exists($model,'views')){
                    //                            views($data)->record();
                    //                        }
                    break;
                default:
                    $data['model'] = $model->orderBy($model->getTable() . ".created_at")->simplePaginate($pag);
                    break;
            }
        }

        $componentClass = "App\\View\\Shuttle\\" . Str::of($name)->studly();

        if (class_exists($componentClass)) {
            $this->componentClass = new $componentClass($this->view);
            $data = array_merge($data, $this->componentClass->additional());
        }

        $this->data = $data;
    }

    public function render()
    {
        if ($this->componentClass) {
            return $this->componentClass->render();
        }
        return view($this->view);
    }

    public function data()
    {
        return array_merge($this->data, parent::data(), ['data' => $this->data, 'props' => $this->props]);
    }
}
