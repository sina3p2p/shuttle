<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\Property;
use Sina\Shuttle\Models\Nestable\Nestable;
use Sina\Shuttle\Models\Nestable\NodeTrait;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\ScaffoldinterfaceRow;
use Sina\Shuttle\Database\Schema\SchemaManager;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;

class BreadController extends Controller
{
    public function index()
    {
        $dataTypes = ScaffoldInterface::select('id', 'name', 'slug')->get()->keyBy('name')->toArray();

        $tables = array_map(function ($table) use ($dataTypes) {
            $table = Str::replaceFirst(DB::getTablePrefix(), '', $table);

            $table = [
                'prefix'     => DB::getTablePrefix(),
                'name'       => $table,
                'slug'       => $dataTypes[$table]['slug'] ?? null,
                'dataTypeId' => $dataTypes[$table]['id'] ?? null,
            ];

            return (object) $table;
        }, SchemaManager::listProtectedTableNames());

        return view('shuttle::bread.index')->with(compact('dataTypes', 'tables'));
    }

    public function create($table)
    {

//        $dataType = Scaffoldinterface::whereName($table)->with('rows')->first();

        $data = $this->prepopulateBreadInfo($table);

        $data['fieldOptions'] = SchemaManager::describeTable((isset($dataType) && strlen($dataType->model_name) != 0)
            ? DB::getTablePrefix().app($dataType->model_name)->getTable()
            : DB::getTablePrefix().$table
        );

        $data['dataType'] = new ScaffoldInterface();
//        dd($data['fieldOptions']);

        return view('shuttle::bread.edit_add', $data);
    }

    private function prepopulateBreadInfo($table)
    {
        $displayName = Str::singular(implode(' ', explode('_', Str::title($table))));
        $modelNamespace = config('voyager.models.namespace', app()->getNamespace().'Models\\');
        if (empty($modelNamespace)) {
            $modelNamespace = app()->getNamespace();
        }

        return [
            'isModelTranslatable'  => true,
            'table'                => $table,
            'slug'                 => Str::slug($table),
            'display_name'         => $displayName,
            'display_name_plural'  => Str::plural($displayName),
            'model_name'           => $modelNamespace.Str::studly(Str::singular($table)),
            'generate_permissions' => true,
            'server_side'          => false,
        ];
    }

    public function store(Request $request)
    {

        $rows = $request->rows;

        if ($request->translation_model)
        {
            $my_translate_table = $this->addTranslate($request->model,$request->translation_model);
            foreach ($my_translate_table as $tr_row){
                $rows[$tr_row] = [
                    'field' => $tr_row,
                    'type' => 'text'
                ];
            }
        }

        DB::transaction(function () use ($request, $rows) {
            $scaffold = ScaffoldInterface::updateOrCreate(['name' => $request->name], $request->all());
            $scaffold->rows()->delete();
            $scaffold->rows()->createMany($rows);
        });
        return redirect()->route('shuttle.bread.index');
    }

    public function edit(ScaffoldInterface $scaffold_interface)
    {

//        $dataType = Voyager::model('DataType')->whereName($table)->first();

//        $fieldOptions = SchemaManager::describeTable((strlen($scaffold_interface->model_name) != 0)
//            ? DB::getTablePrefix().app($scaffold_interface->model_name)->getTable()
//            : DB::getTablePrefix().$scaffold_interface->name
//        );

//        $isModelTranslatable = false;//is_bread_translatable($scaffold_interface);
//        $tables = SchemaManager::listTableNames();
//        $dataTypeRelationships = $scaffold_interface->rows()->where('type', '=', 'relationship')->get();
        $scopes = [];
//        if ($scaffold_interface->model_name != '') {
//            $scopes = $this->getModelScopes($scaffold_interface->model_name);
//        }

        $data = $this->prepopulateBreadInfo($scaffold_interface->name);
//        $data['fieldOptions'] = SchemaManager::describeTable((strlen($scaffold_interface->model_name) != 0)
//            ? DB::getTablePrefix().app($scaffold_interface->model_name)->getTable()
//            : DB::getTablePrefix().$scaffold_interface->name
//        );

        $data['fieldOptions'] = $scaffold_interface->rows;
//        $data['fieldOptions'] =
//            SchemaManager::describeTable((isset($dataType) && strlen($dataType->model_name) != 0)
//            ? DB::getTablePrefix().app($dataType->model_name)->getTable()
//            : DB::getTablePrefix().$scaffold_interface->name);


//        dd($data['fieldOptions']->toArray());

        $data['tables'] = SchemaManager::listTableNames();
        $data['isModelTranslatable'] = false;//is_bread_translatable($scaffold_interface);// false;
        $data['dataTypeRelationships'] = $scaffold_interface->rows()->where('type', '=', 'relationship')->get();
        $data['scopes'] = [];
        $data['dataType'] = $scaffold_interface;

        return view('shuttle::bread.edit_add', $data);// compact('scaffold_interface', 'fieldOptions', 'isModelTranslatable', 'tables', 'dataTypeRelationships', 'scopes','table'));
    }

    public function update(ScaffoldInterface $scaffold_interface,Request $request)
    {

        $rows = $request->rows;

        if ($request->translation_model)
        {
            $my_translate_table = $this->addTranslate($request->model,$request->translation_model);
            foreach ($my_translate_table as $tr_row){
                if(!isset($rows[$tr_row])) {
                    $rows[$tr_row] = [
                        'field' => $tr_row,
                        'type' => 'text'
                    ];
                }
            }
        }

        if ($request->views == 'nested')
        {
            $this->addTraitToModel($request->model, NodeTrait::class);
        }

//        dd($request->all());
//        dd($rows);
//        dd($rows);

        DB::transaction(function () use ($request, $scaffold_interface, $rows){
            $scaffold_interface->update($request->all());
            $scaffold_interface->rows()->delete();
            $scaffold_interface->rows()->createMany($rows);
        });

        return redirect()->route('shuttle.bread.index');

    }

    protected function addTranslate($model,$trans_model)
    {
        $tr_attr = app($trans_model)->getFillable();
        $this->addTraitToModel($model, Translatable::class, [
            (new Property('translatedAttributes'))->setValue($tr_attr)->setPublic(),
            (new Property('translationModel'))->setValue($trans_model)->setPublic()
        ]);
        return $tr_attr;
    }

    protected function addTraitToModel($model, $trait = null, $members = null)
    {
        $my_class = new \ReflectionClass($model);
        $class = ClassType::withBodiesFrom($model);

        if($trait){
            $class->addTrait($trait);
        }

        foreach ($my_class->getTraits() as $key => $trait){
            foreach ($trait->getMethods() as $method){
                $class->removeMethod($method->getName());
            }
            foreach ($trait->getProperties() as $property){
                $class->removeProperty($property->getName());
            }
            $class->addTrait($key);
        }

        if($members){
            foreach ($members as $p){
                $class->addMember($p);
            }
        }

        $file = new PhpFile();
        $namespace = $file->addNamespace($my_class->getNamespaceName());
        $namespace->add($class);
        $printer = new Printer();
        File::put($my_class->getFileName(),$printer->printFile($file));
        return true;
    }

    public function addRelationship(ScaffoldInterface $scaffold_interface,Request $request)
    {
        $relationshipField = $this->getRelationshipField($scaffold_interface,$request);

//        if (!class_exists($request->relationship_model)) {
//            return back()->with([
//                'message'    => 'Model Class '.$request->relationship_model.' does not exist. Please create Model before creating relationship.',
//                'alert-type' => 'error',
//            ]);
//        }

        try {
            DB::beginTransaction();

            $relationship_column = $request->relationship_column_belongs_to;
            if ($request->relationship_type == 'hasOne' || $request->relationship_type == 'hasMany') {
                $relationship_column = $request->relationship_column;
            }

            // Build the relationship details

            $relation_model = null;
            foreach(getModels() as $class) {
                $model = new $class;
                if ($model->getTable() === $request->relationship_table)
                    $relation_model = $class;
            }

            $relationshipDetails = [
                'model'       => $relation_model,
                'table'       => $request->relationship_table,
                'type'        => $request->relationship_type,
                'column'      => $relationship_column,
                'key'         => $request->relationship_key,
                'label'       => $request->relationship_label,
                'pivot_table' => $request->relationship_pivot,
                'pivot'       => ($request->relationship_type == 'belongsToMany') ? '1' : null,
                'taggable'    => $request->relationship_taggable,
            ];

            $this->addTraitToModel($scaffold_interface->model, null, [
                (new Method($relationshipDetails['table']))->setPublic()->setBody('return $this->'.$relationshipDetails['type'].'("'.$relationshipDetails['model'].'");')
            ]);

            $newRow = new ScaffoldinterfaceRow();

            $newRow->scaffold_interface_id  = $scaffold_interface->id;
            $newRow->field = $relationshipField;
            $newRow->type = 'relationship';
            $newRow->display_name = $request->relationship_table;
            $newRow->required = 0;

            foreach (['browse', 'read', 'edit', 'add', 'delete'] as $check) {
                $newRow->{$check} = 1;
            }

            $newRow->details = json_encode($relationshipDetails);
            $newRow->ord = 100;

//            dd($newRow->toArray());



            if (!$newRow->save()) {
                return back()->with([
                    'message'    => 'Error saving new relationship row for '.$request->relationship_table,
                    'alert-type' => 'error',
                ]);
            }

            DB::commit();

            return back()->with([
                'message'    => 'Successfully created new relationship for '.$request->relationship_table,
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {

            dd($e);
            DB::rollBack();

            return back()->with([
                'message'    => 'Error creating new relationship: '.$e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    private function getRelationshipField($scaffoldinterface,$request)
    {
        // We need to make sure that we aren't creating an already existing field

//        $dataType = Scaffoldinterface::find($request->data_type_id);


        $field = Str::singular($scaffoldinterface->name).'_'.$request->relationship_type.'_'.Str::singular($request->relationship_table).'_relationship';

//        dd($field);
        $relationshipFieldOriginal = $relationshipField = strtolower($field);

        $existingRow = ScaffoldinterfaceRow::where('field', '=', $relationshipField)->first();
        $index = 1;

        while (isset($existingRow->id)) {
            $relationshipField = $relationshipFieldOriginal.'_'.$index;
            $existingRow = $scaffoldinterface->rows()->where('field', '=', $relationshipField)->first();
            $index += 1;
        }

        return $relationshipField;
    }

}
