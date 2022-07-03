<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Database\Schema\SchemaManager;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Sina\Shuttle\Models\ScaffoldinterfaceRow;

abstract class ShuttleController extends BaseController
{

    public function index(ScaffoldInterface $scaffold_interface, Request $request)
    {
        $view = 'shuttle::scaffold.index';
        $show = false;
        if (view()->exists("shuttle.{$scaffold_interface->slug}.index")) {
            $view = "shuttle.{$scaffold_interface->slug}.index";
        } elseif (view()->exists("shuttle.{$scaffold_interface->slug}.show")) {
            $show = true;
        }

        $data = $this->prepareData($scaffold_interface, $request);

        if ($this->is_api) {
            return $data['dataTypeContent'];
        }

        $data['show'] = $show;

        return view($view, $data);
    }

    public function create(ScaffoldInterface $scaffold_interface, Request $request)
    {

        $dataTypeContent = (strlen($scaffold_interface->model) != 0)
            ? new $scaffold_interface->model()
            : false;

        $lang = $request->get('lang', config('translatable.locales')[0]);

        foreach ($scaffold_interface->addRows as $key => $row) {
            $scaffold_interface->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        //        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        //        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        //        $this->eagerLoadRelations($dataTypeContent, $dataType, 'add', $isModelTranslatable);

        $view = "shuttle::scaffold.edit_add";
        if (view()->exists("shuttle.{$scaffold_interface->slug}.create")) {
            $view = "shuttle.{$scaffold_interface->slug}.create";
        } else if (view()->exists("shuttle.{$scaffold_interface->slug}.edit_add")) {
            $view = "shuttle.{$scaffold_interface->slug}.edit_add";
        }


        $data = $this->prepareData($scaffold_interface, $request, 1);
        $data['view'] = $view;
        if ($this->is_api) {
            return $data;
        }

        return view('shuttle::scaffold.edit_add_base', $data);
    }

    public function store(ScaffoldInterface $scaffold_interface, Request $request)
    {
        $data = $this->save($scaffold_interface, $request);

        if ($this->is_api) {
            return $data;
        }

        return redirect()->route("shuttle.scaffold_interface.index", $scaffold_interface);
        //        dd($values);
        //        $slug = $this->getSlug($request);


        // Validate fields with ajax
        //        $val = $this->validateBread($request->all(), $scaffoldinterface->addRows)->validate();
        //        $data = $this->insertUpdateData($request, $slug, $scaffoldinterface->addRows, new $scaffoldinterface->model_name());

        //        if (!$request->has('_tagging')) {
        //            if (auth()->user()->can('browse', $data)) {
        //                $redirect = redirect()->route("admin.{scaffold_interface:slug}.index", $scaffoldinterface);
        //            } else {
        //                $redirect = redirect()->back();
        //            }
        //
        //            return $redirect->with([
        //                'message'    => __('voyager::generic.successfully_added_new')." {$scaffoldinterface->display_name_singular}",
        //                'alert-type' => 'success',
        //            ]);
        //        } else {
        //            return response()->json(['success' => true, 'data' => $data]);
        //        }
    }

    public function edit(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {


        // If a column has a relationship associated with it, we do not want to show that field
        //        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        //        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        //        $isModelTranslatable = false;//is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        //        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);

        $view = 'shuttle::scaffold.edit_add';

        if (view()->exists("shuttle.{$scaffold_interface->slug}.create")) {
            $view = "shuttle.{$scaffold_interface->slug}.create";
        } else if (view()->exists("shuttle.{$scaffold_interface->slug}.edit_add")) {
            $view = "shuttle.{$scaffold_interface->slug}.edit_add";
        }

        $data =  $this->prepareData($scaffold_interface, $request, 2, $id);
        $data['view'] = $view;

        if ($this->is_api) {
            return $data;
        }

        //        return view($view, compact('scaffold_interface', 'dataTypeContent', 'isModelTranslatable', 'lang'));
        return view('shuttle::scaffold.edit_add_base', $data);
    }

    public function update(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {

        $dataType = $scaffold_interface;

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = $model->findOrFail($id);
        }

        $lang = $request->get('lang', config('translatable.locales')[0]);
        //        dd($lang);
        $translated_attr = [];
        $values = array();
        //        $values = array_fill_keys($model->getFillable(), null);
        //        $values = array_fill_keys($scaffold_interface->editRows()->pluck('field')->toArray(), null);

        $this->validateBread($request->all(), $scaffold_interface->rows, $scaffold_interface->name, $id)->validate();

        $url_row = $scaffold_interface->rows()->whereNotNull('details->slugify')->first(); //->whereJsonContains('details->slugify->origin','*')->get());

        if ($url_row && !$request->has($url_row->field)) {
            $url_detail = $url_row->details;
            $request->merge([$url_row->field => Str::slug($request->{data_get($url_detail, 'slugify.origin')})]);
        }

        if ($scaffold_interface->translation_model) {
            $translated_attr = app($scaffold_interface->model)->translatedAttributes;
            $values[$lang] = $request->only($translated_attr);
        }
        $translated_attr[] = '_token';
        $translated_attr[] = '_method';

        $values = array_merge($values, $request->except(app($scaffold_interface->model)->translatedAttributes));

        foreach ($request->allFiles() as $key => $file) {
            $values[$key] = $file->store('public/upload');
        }

        $data->update($values);

        $relations = $scaffold_interface->rows()->where('type', 'relationship')->where('details->type', 'belongsToMany')->get();

        foreach ($relations as $relation) {
            $details = (object) $relation->details;
            $content = [];
            if ($details->pivot && $request->has($relation->field)) {
                foreach ($request->{$relation->field} as $value) {
                    $content[$value] = (array) $details->pivot;
                }
            } else {
                $content = $request->{$relation->field};
            }
            $data->belongsToMany($details->model, $details->pivot_table, $details->foreign_pivot_key ?? null, $details->related_pivot_key ?? null, $details->parent_key ?? null, $details->key)->sync($content);
        }

        // Validate fields with ajax
        //        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        //        $this->insertUpdateData($request, $scaffold_interface->slug, $dataType->editRows, $data);

        //        event(new BreadDataUpdated($dataType, $data));

        //        if (auth()->user()->can('browse', app($dataType->model_name))) {
        //            $redirect = redirect()->route("admin.scaffold_interface.index", $scaffold_interface);
        //        } else {
        //            $redirect = redirect()->back();
        //        }

        if ($this->is_api) {
            return $data;
        }

        return redirect()->route("shuttle.scaffold_interface.index", $scaffold_interface)->with([
            'message' => __('voyager::generic.successfully_updated'),
            'alert-type' => 'success',
        ]);
    }

    public function show(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {
        $dataType = $scaffold_interface;

        if (strlen($dataType->model) != 0) {

            $model = app($dataType->model);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        return view("shuttle.{$scaffold_interface->slug}.show", compact('scaffold_interface', 'dataTypeContent'));
    }

    public function destroy(ScaffoldInterface $scaffold_interface, $id)
    {
        //        $model = app($scaffold_interface->model)->find($id)->delete();
        optional(app($scaffold_interface->model)->find($id))->delete();
        if ($this->is_api) {
            return ['success' => true];
        }
        return redirect()->route('shuttle.scaffold_interface.index', $scaffold_interface);
    }

    public function validateBread($data, $rows, $name = null, $id = null)
    {
        $rules = [];
        $messages = [];
        $customAttributes = [];
        $is_update = $name && $id;

        $fieldsWithValidationRules = $this->getFieldsWithValidationRules($rows);

        foreach ($fieldsWithValidationRules as $field) {
            $detail = $field->details;
            $fieldRules = $detail->validation->rule;
            $fieldName = $field->field;

            // Show the field's display name on the error message
            if (!empty($field->display_name)) {
                if (!empty($data[$fieldName]) && is_array($data[$fieldName])) {
                    foreach ($data[$fieldName] as $index => $element) {
                        $name = $element->getClientOriginalName() ?? $index + 1;

                        $customAttributes[$fieldName . '.' . $index] = $field->display_name . ' ' . $name;
                    }
                } else {
                    $customAttributes[$fieldName] = $field->display_name;
                }
            }

            // If field is an array apply rules to all array elements
            $fieldName = !empty($data[$fieldName]) && is_array($data[$fieldName]) ? $fieldName . '.*' : $fieldName;

            // Get the rules for the current field whatever the format it is in
            $rules[$fieldName] = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            if ($id && property_exists($detail->validation, 'edit')) {
                $action_rules = $detail->validation->edit->rule;
                $rules[$fieldName] = array_merge($rules[$fieldName], (is_array($action_rules) ? $action_rules : explode('|', $action_rules)));
            } elseif (!$id && property_exists($detail->validation, 'add')) {
                $action_rules = $detail->validation->add->rule;
                $rules[$fieldName] = array_merge($rules[$fieldName], (is_array($action_rules) ? $action_rules : explode('|', $action_rules)));
            }
            // Fix Unique validation rule on Edit Mode
            if ($is_update) {
                foreach ($rules[$fieldName] as &$fieldRule) {
                    if (strpos(strtoupper($fieldRule), 'UNIQUE') !== false) {
                        $fieldRule = \Illuminate\Validation\Rule::unique($name)->ignore($id);
                    }
                }
            }

            // Set custom validation messages if any
            if (!empty($detail->validation->messages)) {
                foreach ($detail->validation->messages as $key => $msg) {
                    $messages["{$field->field}.{$key}"] = $msg;
                }
            }
        }

        return Validator::make($data, $rules, $messages, $customAttributes);
    }

    protected function getFieldsWithValidationRules($fieldsConfig)
    {
        return $fieldsConfig->filter(function ($value) {
            if (empty($value->details)) {
                return false;
            }
            return !empty(optional($value->details)->validation->rule);
        });
    }

    public function jsData(Request $request, $model)
    {

        $modelKey = $model;
        $model = app('App\\' . ucfirst($model));
        //        $model = app(data_get($config,'model'));
        //        $data = new SearchModel($model);
        $js = 'window.model = "' . $modelKey . '"; window.' . $modelKey . ' =' . json_encode($model->all()->toArray());
        return response($js)->header('Content-Type', 'application/javascript');
    }

    public function relationship(ScaffoldinterfaceRow $scaffold_interface_row, Request $request)
    {

        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);

        $method = $request->input('method', 'add');

        // $model = app($scaffold_interface->model);

        // if ($method != 'add') {
        //     $model = $model->find($request->input('id'));
        // }

        // $rows = $scaffold_interface->{$method.'Rows'};
        // foreach ($rows as $key => $row) {
        // if ($row->field === $request->input('type')) {
        $row = $scaffold_interface_row;
        $options = $row->details;
        $model = app($options->model);
        $skip = $on_page * ($page - 1);

        if (isset($options->scope) && $options->scope != '' && method_exists($model, 'scope' . ucfirst($options->scope))) {
            $model = $model->{$options->scope}();
        }

        if ($search) {
            if (in_array($options->label, $model->additional_attributes ?? [])) {
                $relationshipOptions = $model->all();
                $relationshipOptions = $relationshipOptions->filter(function ($model) use ($search, $options) {
                    return stripos($model->{$options->label}, $search) !== false;
                });
                $total_count = $relationshipOptions->count();
                $relationshipOptions = $relationshipOptions->forPage($page, $on_page);
            } else {
                $total_count = $model->where($options->label, 'LIKE', '%' . $search . '%')->count();
                $relationshipOptions = $model->take($on_page)->skip($skip)
                    ->where($options->label, 'LIKE', '%' . $search . '%')
                    ->get();
            }
        } else {
            $total_count = $model->count();
            $relationshipOptions = $model->take($on_page)->skip($skip)->get();
        }

        $results = [];

        if (!$row->required && !$search && $page == 1) {
            $results[] = [
                'id'   => '',
                'text' => 'None',
            ];
        }

        if (!empty($options->sort->field)) {
            if (!empty($options->sort->direction) && strtolower($options->sort->direction) == 'desc') {
                $relationshipOptions = $relationshipOptions->sortByDesc($options->sort->field);
            } else {
                $relationshipOptions = $relationshipOptions->sortBy($options->sort->field);
            }
        }

        foreach ($relationshipOptions as $relationshipOption) {
            $results[] = [
                'id'   => $relationshipOption->{$options->key},
                'text' => $relationshipOption->{$options->label},
            ];
        }

        return response()->json([
            'results'    => $results,
            'pagination' => [
                'more' => ($total_count > ($skip + $on_page)),
            ],
        ]);
        // }
        // }

        return response()->json([], 404);
    }

    public function rows(ScaffoldInterface $scaffold_interface, Request $request)
    {
        $modes = ['browse', 'add', 'edit'];
        $type = in_array($request->mode, $modes) ? $modes[$request->mode] : $modes[0];

        return $scaffold_interface->load(['rows' => function ($q) use ($type) {
            $q->selectRaw('
                shuttle_scaffold_interface_rows.* , 
                shuttle_scaffold_interface_rows.field as name,
                shuttle_scaffold_interface_rows.display_name as title
                ')->where($type, 1);
        }]);
    }

    public function sort(ScaffoldInterface $scaffold_interface, Request $request)
    {
        $data = json_decode($request->sort, true);
        $model = app($scaffold_interface->model);
        $model->rebuildTree($data);
        return redirect()->route("shuttle.scaffold_interface.index", $scaffold_interface);
    }

    public function save(ScaffoldInterface $scaffold_interface, Request $request, $model = null)
    {
        $id = 0;
        $scaffoldModel = app($scaffold_interface->model);
        $primaryKey = $scaffoldModel->getKeyName();
        if ($model && $model instanceof Model) {
            $id = $model->{$primaryKey};
        } else if ($model) {
            $id = $model;
        }

        $lang = $request->get('lang', config('translatable.locales')[0]);
        $translated_attr = [];
        $values = array();

        $url_row = $scaffold_interface->rows()->whereNotNull('details->slugify')->first(); //->whereJsonContains('details->slugify->origin','*')->get());

        if ($url_row && !$request->has($url_row->field)) {
            $url_detail = $url_row->details;
            $request->merge([$url_row->field => Str::slug($request->{data_get($url_detail, 'slugify.origin')})]);
        }

        $this->validateBread($request->all(), $scaffold_interface->rows)->validate();

        if ($scaffold_interface->translation_model) {
            $translated_attr = app($scaffold_interface->model)->translatedAttributes;
            $values[$lang] = $request->only($translated_attr);
        }

        $translated_attr[] = '_token';
        $translated_attr[] = '_method';
        $values = array_merge($values, $request->except($translated_attr));

        foreach ($request->allFiles() as $key => $file) {
            $values[$key] = $file->store('public/upload');
        }

        $data = app($scaffold_interface->model)->updateOrCreate([$primaryKey => $id], array_filter($values));

        $relations = $scaffold_interface->rows()->where('type', 'relationship')->where('details->type', 'belongsToMany')->get();

        foreach ($relations as $relation) {
            $details = (object) $relation->details;
            $content = [];
            if ($details->pivot && $request->has($relation->field)) {
                foreach ($request->{$relation->field} as $value) {
                    $content[$value] = (array) $details->pivot;
                }
            } else {
                $content = $request->{$relation->field};
            }
            $data->belongsToMany($details->model, $details->pivot_table, $details->foreign_pivot_key ?? null, $details->related_pivot_key ?? null, $details->parent_key ?? null, $details->key)->sync($content);
        }


        return $data;
    }

    public function prepareData(ScaffoldInterface $scaffold_interface, Request $request, $type = 0, $id = 0)
    {
        $data = [];
        switch ($type) {
            case 0:

                $user = auth('admin')->user();

                $getter = $scaffold_interface->server_side ? 'paginate' : 'get';
                $getter = 'paginate';

                $search = (object)['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

                $searchNames = [];
                if ($scaffold_interface->server_side) {
                    $searchable = SchemaManager::describeTable(app($scaffold_interface->model)->getTable())->pluck('name')->toArray();
                    $dataRow = $scaffold_interface->rows()->get();
                    foreach ($searchable as $key => $value) {
                        $field = $dataRow->where('field', $value)->first();
                        $displayName = ucwords(str_replace('_', ' ', $value));
                        if ($field !== null) {
                            $displayName = $field->getTranslatedAttribute('display_name');
                        }
                        $searchNames[$value] = $displayName;
                    }
                }

                $orderBy = $request->get('order_by', $scaffold_interface->order_column);
                $sortOrder = $request->get('sort_order', $scaffold_interface->order_direction);
                $usesSoftDeletes = false;
                $showSoftDeleted = false;

                // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
                if (strlen($scaffold_interface->model) != 0) {
                    $model = app($scaffold_interface->model);

                    $query = $model;

                    if ($scaffold_interface->scope && $scaffold_interface->scope != '' && method_exists($model, 'scope' . ucfirst($scaffold_interface->scope))) {
                        $query = $query->{$scaffold_interface->scope}();
                    }

                    // Use withTrashed() if model uses SoftDeletes and if toggle is selected
                    if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                        $usesSoftDeletes = true;

                        if ($request->get('showSoftDeleted')) {
                            $showSoftDeleted = true;
                            $query = $query->withTrashed();
                        }
                    }

                    // If a column has a relationship associated with it, we do not want to show that field
                    //            $this->removeRelationshipField($scaffold_interface, 'browse');


                    // if(method_exists($model, 'addDynamicRelation'))
                    // {
                    foreach ($scaffold_interface->browseRows()->where('type', 'relationship')->get() as $r) {
                        $model->resolveRelationUsing($r->field, function ($orderModel) use ($r) {
                            // dd($r->toArray());
                            if ($r->details->type == 'belongsToMany') {
                                return $orderModel->belongsToMany($r->details->model, $r->details->pivot_table, $r->details->foreign_pivot_key ?? null, $r->details->related_pivot_key ?? null, $r->details->parent_key ?? null, $r->details->key);
                            }
                            return $orderModel->{$r->details->type}($r->details->model, $r->details->column, $r->details->key);
                        });
                        // Builder::macro($r->field, function (Builder $builder) use ($r) {
                        //     // return $builder->getModel()->hasMany(Order::class, 'user_id', 'user_id');
                        //     if($r->details->type == 'belongsToMany')
                        //     {
                        //         return $builder->getModel()->belongsToMany($r->details->model, $r->details->pivot_table, $r->details->foreign_pivot_key ?? null, $r->details->related_pivot_key ?? null, $r->details->parent_key ?? null, $r->details->key);
                        //     }
                        //     return $builder->getModel()->{$r->details->type}($r->details->model, $r->details->column, $r->details->id );

                        // });
                        // $query = $query->addDynamicRelation($r->field, function ($orderModel) use ($r) {
                        //     dd($r);
                        //     if($r->details->type == 'belongsToMany')
                        //     {
                        //         return $orderModel->belongsToMany($r->details->model, $r->details->pivot_table, $r->details->foreign_pivot_key ?? null, $r->details->related_pivot_key ?? null, $r->details->parent_key ?? null, $r->details->key);
                        //     }
                        //     return $orderModel->{$r->details->type}($r->details->model, $r->details->column, $r->details->id );
                        // });
                        $query = $query->with($r->field);
                    }


                    // }


                    if ($search->value != '' && $search->key && $search->filter) {
                        $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                        $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';
                        $query->where($search->key, $search_filter, $search_value);
                    }

                    if ($orderBy && in_array($orderBy, $scaffold_interface->fields())) {
                        $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                        $dataTypeContent = call_user_func([
                            $query->orderBy($orderBy, $querySortOrder),
                            $getter,
                        ]);
                    } elseif ($model->timestamps) {
                        $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter], 100);
                    } else {
                        $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter], 100);
                    }

                    // Replace relationships' keys for labels and create READ links if a slug is provided.
                    //            $dataTypeContent = $this->resolveRelations($dataTypeContent, $scaffold_interface);
                } else {
                    // If Model doesn't exist, get data from table name
                    $dataTypeContent = call_user_func([DB::table($scaffold_interface->name), $getter]);
                    $model = false;
                }

                // Check if server side pagination is enabled
                $isServerSide = isset($dataType->server_side) && $scaffold_interface->server_side;

                // Check if a default search key is set
                $defaultSearchKey = $dataType->default_search_key ?? null;

                // Actions
                $actions = [];
                //        if (!empty($dataTypeContent->first())) {
                //            foreach (Voyager::actions() as $action) {
                //                $action = new $action($dataType, $dataTypeContent->first());
                //
                //                if ($action->shouldActionDisplayOnDataType()) {
                //                    $actions[] = $action;
                //                }
                //            }
                //        }

                // Define showCheckboxColumn

                $showCheckboxColumn = true;


                // Define orderColumn
                $orderColumn = [];
                if ($orderBy) {
                    $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
                    $orderColumn = [[$index, $sortOrder ?? 'desc']];
                }

                // $add = $user->can($scaffold_interface->name.'_add');
                // $edit = $user->can($scaffold_interface->name.'_edit');
                // $delete = $user->can($scaffold_interface->name.'_delete');

                $add = true;
                $edit = true;
                $delete = true;

                $data = [
                    'actions' => $actions,
                    'dataTypeContent' => $dataTypeContent,
                    'search' => $search,
                    'orderBy' => $orderBy,
                    'orderColumn' => $orderColumn,
                    'sortOrder' => $sortOrder,
                    'searchNames' => $searchNames,
                    'isServerSide' => $isServerSide,
                    'defaultSearchKey' => $defaultSearchKey,
                    'usesSoftDeletes' => $usesSoftDeletes,
                    'showSoftDeleted' => $showSoftDeleted,
                    'showCheckboxColumn' => $showCheckboxColumn,
                    'add' => $add,
                    'edit' => $edit,
                    'delete' => $delete,
                ];
                break;
            case 1:
                // dd(new $scaffold_interface->model());
                $dataTypeContent = (strlen($scaffold_interface->model) != 0)
                    ? new $scaffold_interface->model()
                    : false;

                $lang = $request->get('lang', config('translatable.locales')[0]);

                $scaffold_interface->load([
                    'rows' => function ($q) {
                        $q->where('add', true);
                    }
                ]);
                foreach ($scaffold_interface->addRows as $key => $row) {
                    $scaffold_interface->addRows[$key]['col_width'] = $row->details->width ?? 100;
                }

                $data = [
                    'dataTypeContent' => $dataTypeContent,
                    'lang' => $lang
                ];
                break;
            case 2:
                $dataType = $scaffold_interface;

                $lang = $request->get('lang', config('translatable.locales')[0]);

                if (strlen($dataType->model) != 0) {
                    $model = app($dataType->model);
                    $query = $model;

                    foreach ($scaffold_interface->editRows()->where('type', 'relationship')->get() as $r) {
                        $model->resolveRelationUsing($r->field, function ($orderModel) use ($r) {
                            if ($r->details->type == 'belongsToMany') {
                                return $orderModel->belongsToMany($r->details->model, $r->details->pivot_table, $r->details->foreign_pivot_key ?? null, $r->details->related_pivot_key ?? null, $r->details->parent_key ?? null, $r->details->key);
                            }
                            return $orderModel->{$r->details->type}($r->details->model, $r->details->column, $r->details->key);
                        });

                        $query = $query->with($r->field);
                    }

                    // Use withTrashed() if model uses SoftDeletes and if toggle is selected
                    if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                        $query = $query->withTrashed();
                    }
                    if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                        $query = $query->{$dataType->scope}();
                    }


                    $dataTypeContent = call_user_func([$query, 'findOrFail'], $id);
                } else {
                    // If Model doest exist, get data from table name
                    $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
                }

                foreach ($dataType->editRows as $key => $row) {
                    $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
                }

                if ($scaffold_interface->translation_model) {
                    $dataTypeContent->setDefaultLocale($lang);
                }

                $scaffold_interface->load([
                    'rows' => function ($q) {
                        $q->where('edit', true);
                    }
                ]);

                $data = [
                    'dataTypeContent' => $dataTypeContent,
                    'lang' => $lang
                ];

                break;
        }

        $data['scaffold_interface'] = $scaffold_interface;

        return $data;
    }

    public function array(ScaffoldinterfaceRow $scaffold_interface_row, Request $request)
    {
        $loop = new \StdClass();
        $loop->index = $request->get('loop', 0);
        return view('shuttle::formfields.array_body', ['scaffoldInterface' => new ScaffoldInterface(), 'row' => $scaffold_interface_row, 'value' => new \StdClass(), 'loop' => $loop]);
    }
}
