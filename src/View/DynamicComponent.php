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

    public function __construct($name, $data = null, $c = null, $cName = null, $modelAutoLoad = true)
    {
        $this->props = $data ?? [];
        $this->view = "components." . $name;
        $data = $data ?? [];

        if ($cName) {
            $m = (ModelsComponent::where('name', $cName)->first());
        } else {
            $m = $c;
        }

        if ($modelAutoLoad) {
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
                        $m = $m->orderBy($model->getTable() . ".created_at");
                        $data[$row->details->column] = $row->details->type == 'belongsTo' ?  $m->first() : $m->get();
                    } else {
                        $data[$row->details->column] = [];
                    }
                });
        }

        if ($m->model && $m->model_settings) {
            $model = app($m->model);
            $model = $model->orderBy($model->getTable() . ".created_at");
            $pag = data_get($m->model_settings, 'limit', -1);
            $data['model'] = match ($pag) {
                -1, "-1" => $model->get(),
                0, "0" => $model->first(),
                default => $model->simplePaginate($pag),
            };
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
