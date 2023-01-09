<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Http\Request;
use Sina\Shuttle\Http\Resources\DataTableResource;

class ScaffoldController extends ShuttleController
{

    public function index(ScaffoldInterface $scaffold_interface, Request $request)
    {
        if ($scaffold_interface->controller) {
            $c = app($scaffold_interface->controller);
            if (method_exists($c, 'index')) {
                return $c->index($scaffold_interface, $request);
            }
        }
        return parent::index($scaffold_interface, $request);
    }

    public function create(ScaffoldInterface $scaffold_interface, Request $request)
    {
        if ($scaffold_interface->controller) {
            $c = app($scaffold_interface->controller);
            if (method_exists($c, 'create')) {
                return $c->create($scaffold_interface, $request);
            }
        }
        return parent::create($scaffold_interface, $request);
    }

    public function store(ScaffoldInterface $scaffold_interface, Request $request)
    {
        if ($scaffold_interface->controller) {
            $c = app($scaffold_interface->controller);
            if (method_exists($c, 'store')) {
                return $c->store($scaffold_interface, $request);
            }
        }

        return parent::store($scaffold_interface, $request);
    }

    public function edit(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {
        if ($scaffold_interface->controller) {
            $c = app($scaffold_interface->controller);
            if (method_exists($c, 'edit')) {
                return $c->edit($scaffold_interface, $request, $id);
            }
        }
        return parent::edit($scaffold_interface, $request, $id);
    }

    public function update(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {
        if ($scaffold_interface->controller) {
            $c = app($scaffold_interface->controller);
            if (method_exists($c, 'update')) {
                return $c->update($scaffold_interface, $request, $id);
            }
        }
        return parent::update($scaffold_interface, $request, $id);
    }

    public function show(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {
        if ($scaffold_interface->controller) {
            $c = app($scaffold_interface->controller);
            if (method_exists($c, 'show')) {
                return $c->show($request, $scaffold_interface, $id);
            }
        }
        return parent::show($scaffold_interface, $request, $id);
    }

    public function loadRelationship(Request $request)
    {
        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);
        $model = app($request->model);
        $m = $model;

        if ($model) {
            $skip = $on_page * ($page - 1);

            if (isset($request->scope) && $request->scope != '' && method_exists($model, 'scope' . ucfirst($request->scope))) {
                $model = $model->{$request->scope}();
            }

            if ($search) {
                // if (in_array($request->label, $model->additional_attributes ?? [])) {
                //     $relationshipOptions = $model->all();
                //     $relationshipOptions = $relationshipOptions->filter(function ($model) use ($search, $request) {
                //         return stripos($model->{$request->label}, $search) !== false;
                //     });
                //     $total_count = $relationshipOptions->count();
                //     $relationshipOptions = $relationshipOptions->forPage($page, $on_page);
                // } else 
                // {
                if (in_array($request->label, $m->translatedAttributes ?? [])) {
                    $total_count = $model->whereTranslationLike($request->label, '%' . $search . '%')->count();
                    $relationshipOptions = $model->take($on_page)->skip($skip)
                        ->whereTranslationLike($request->label, '%' . $search . '%')
                        ->get();
                } else {
                    $total_count = $model->where($request->label, 'Like', '%' . $search . '%')->count();
                    $relationshipOptions = $model->take($on_page)->skip($skip)
                        ->where($request->label, 'Like', '%' . $search . '%')
                        ->get();
                }
                // }
            } else {
                $total_count = $model->count();
                $relationshipOptions = $model->take($on_page)->skip($skip)->get();
            }

            $results = [];

            if ($request->sort && isset($request->sort['field']) && !empty($request->sort['field'])) {
                if (!empty($request->sort['direction']) && strtolower($request->sort['direction']) == 'desc') {
                    $relationshipOptions = $relationshipOptions->sortByDesc($request->sort['field']);
                } else {
                    $relationshipOptions = $relationshipOptions->sortBy($request->sort['field']);
                }
            }

            foreach ($relationshipOptions as $relationshipOption) {
                $results[] = [
                    'id'   => $relationshipOption->{$request->key},
                    'text' => $relationshipOption->{$request->label},
                ];
            }

            return response()->json([
                'results'    => $results,
                'pagination' => [
                    'more' => ($total_count > ($skip + $on_page)),
                ],
            ]);
        }

        return response()->json([], 404);
    }

    public function datatable(Request $request, ScaffoldInterface $scaffoldInterface)
    {
        return $this->getDataTableResource(
            DataTableResource::newInstance()
                ->setScaffoldInterface($scaffoldInterface)
                ->addAction(fn ($data) => '<a href="' . route('shuttle.scaffold_interface.edit', [$scaffoldInterface, $data->id]) . '" class="btn btn-bootstrap-padding btn-primary"><i class="glyph-icon simple-icon-pencil"></i></a>')
                ->addAction(fn ($data) => '<button type="button" class="btn btn-bootstrap-padding btn-danger remove-item"><i class="glyph-icon simple-icon-trash"></i></button>')
        )->json();
    }

    public function filters()
    {
        return '';
    }
}
