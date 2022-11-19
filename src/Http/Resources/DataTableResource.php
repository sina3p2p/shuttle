<?php

namespace Sina\Shuttle\Http\Resources;

use Illuminate\Support\Collection;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\ScaffoldinterfaceRow;

class DataTableResource
{
    public ScaffoldInterface $scaffoldInterface;

    public $columns;

    public $query;

    public $page = 0;

    public $start = 0;

    public $length = 25;

    public $search;

    public $order;

    public $sorts;

    protected $searchCallback;

    protected $additionalColumns;

    protected $renderColumn;

    protected $actions = [];

    public function __construct()
    {
        $request = request();
        $this->start = $request->start ?? 0;
        $this->length = $request->length ?? 25;
        $this->page = $this->start / $this->length;
        $this->search = collect($request->search)->get('value', '');
        $this->order = $request->order;
        $this->additionalColumns = collect();
    }

    public function data()
    {
        return $this->search()
            // ->order()
            ->limit()
            ->get();
    }

    public function limit()
    {
        $this->query = $this->query->limit($this->length)->offset($this->page * $this->length);
        return $this;
    }

    public function search()
    {
        $this->query = $this->query->when($this->search, function ($q) {
            $callback = $this->searchCallback;
            if ($callback) {
                $callback($q, $this->search);
            }
        });
        return $this;
    }

    public function get()
    {
        return $this->query->get();
    }

    public function columns()
    {
        return $this->columns;
    }

    public function setColumns(array $columns)
    {
        $this->columns = collect($columns);
        return $this;
    }

    public function addColumn($key, $title, $value, int $index = 0)
    {
        $this->columns->splice($index, 0, [[
            'data' => $key,
            'title' => $title,
        ]]);
        $this->renderColumn->put($key, $value);
        return $this;
    }

    public function setScaffoldInterface(ScaffoldInterface $scaffoldInterface)
    {
        $this->scaffoldInterface = $scaffoldInterface;
        $model = app($this->scaffoldInterface->model);
        $this->query = $model->query();
        foreach ($scaffoldInterface->browseRows()->where('type', 'relationship')->get() as $r) {
            $model->resolveRelationUsing($r->field, function ($orderModel) use ($r) {
                // dd($r->toArray());
                if ($r->details->type == 'belongsToMany') {
                    return $orderModel->belongsToMany($r->details->model, $r->details->pivot_table, $r->details->foreign_pivot_key ?? null, $r->details->related_pivot_key ?? null, $r->details->parent_key ?? null, $r->details->key);
                }
                return $orderModel->{$r->details->type}($r->details->model, $r->details->column, $r->details->key);
            });
            $this->query = $this->query->with($r->field);
        }

        $columns = $this->scaffoldInterface->browseRows->map(function ($row) {
            return [
                'title' => $row->display_name,
                'data' => $row->field,
            ];
        });
        $this->columns = $columns;
        $this->renderColumn = $this->scaffoldInterface->browseRows; //$columns->pluck('data');
        return $this;
    }

    public function onSearch($callback)
    {
        $this->searchCallback = $callback;
        return $this;
    }

    public function formatData($data)
    {
        if (!$this->columns) {
            return $data;
        }
        if ($this->columns instanceof Collection) {
            return $data->map(function ($item) {
                $c = $this->renderColumn->mapWithKeys(function ($row, $key) use ($item) {
                    if ($row instanceof ScaffoldinterfaceRow) {
                        return [$row->field => $row->render($item->{$row->field})];
                    } else if ($row instanceof \Closure) {
                        return [$key => $row($item)];
                    } elseif (is_string($key)) {
                        return [$key => $row];
                    }
                    return [$row => data_get($item, $row)];
                });
                $c['action'] = collect($this->actions)->map(function ($act) use ($item) {
                    return $act($item);
                })->implode("\n");
                return $c;
            });
        }

        return $this->columns::collection($data);
    }

    public function addAction($html)
    {
        $this->actions[] = $html;

        return $this;
    }

    public static function newInstance()
    {
        return new static();
    }

    public function json()
    {
        $count = $this->query->count();

        return response()->json([
            'draw' => time(),
            'data' => $this->formatData($this->data()),
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ]);
    }
}
