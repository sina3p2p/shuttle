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

    public function __construct($name, $data = null, $modelAutoLoad = true)
    {
        $this->view = "components.".$name;
        $data = $data ?? [];
        if($modelAutoLoad)
        {
            $m = (ModelsComponent::where('name', $name)->first());
            if($m)
            {
                $m->rows()
                ->where('type', 'c_relationship')
                ->get()
                ->each(function($row) use (&$data){
                    $model = app($row->details->model);
                    $val = data_get($data, $row->details->column, []);
                    if($val)
                    {
                        $m = app($row->details->model)->whereIn($model->getTable().".".$row->details->key, is_array($val) ? $val : [$val]);
                        if(isset($row->details->scope) && !empty($row->details->scope))
                        {
                            $m = $m->{$row->details->scope}();
                        }
                        $data[$row->details->column] = $m->orderBy($model->getTable().".created_at")->get();
                    }else{
                        $data[$row->details->column] = [];
                    }
                });
            }
        }

        $componentClass = "App\\View\\Shuttle\\".Str::of($name)->studly();
        if(class_exists($componentClass))
        {
            $this->componentClass = new $componentClass($this->view);
            $data = array_merge($this->componentClass->additional());
        }

        $this->data = $data;
        
    }

    public function render()
    {
        if($this->componentClass)
        {
            return $this->componentClass->render();
        }
        return view($this->view);
    }

    public function data()
    {
        return array_merge($this->data, parent::data(), ['data' => $this->data]);
    }
}
