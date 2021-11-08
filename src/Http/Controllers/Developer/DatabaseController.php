<?php

namespace Sina\Shuttle\Http\Controllers\Developer;

use Sina\Shuttle\Database\Schema\SchemaManager;
use Exception;
use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Sina\Shuttle\Database\Schema\Identifier;
use Sina\Shuttle\Database\Schema\Table;
use Sina\Shuttle\Database\Types\Type;
use Sina\Shuttle\Database\DatabaseUpdater;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;

class DatabaseController extends Controller
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

        return view('shuttle::developer.database.index', compact('tables'));
    }

    public function create()
    {
        $db = $this->prepareDbManager('create');
        return view('shuttle::developer.database.edit_add', compact('db'));
    }

    public function store(Request $request)
    {

//        try {

            $conn = 'database.connections.'.config('database.default');
            Type::registerCustomPlatformTypes();

            $r_table = $request->table;
            if (!is_array($request->table)) {
                $r_table = json_decode($request->table, true);
            }

//            dd($table);
            $r_table['options']['collate'] = config($conn.'.collation', 'utf8mb4_unicode_ci');
            $r_table['options']['charset'] = config($conn.'.charset', 'utf8mb4');

            $table = Table::make($r_table);
            SchemaManager::createTable($table);


            if (isset($request->create_model) && $request->create_model == 'on') {
                $model_name = Str::studly(Str::singular($table->name));
                $model_file = new ClassType($model_name);
                $model_file->setExtends(Model::class);
                $columns = collect($r_table['columns']);
                $model_file
                    ->addProperty('fillable', $columns->where('fillable',true)->pluck('name')->toArray())
                    ->setProtected();
                if(!$columns->contains('name','created_at')){
                    $model_file->addProperty('timestamps', false)->setPublic();
                }
                $file = new PhpFile();
                $namespace = $file->addNamespace('App\\Models');
                $namespace->add($model_file);
                $printer = new Printer();
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    File::put(app_path().'\\Models\\'.$model_name.'.php',$printer->printFile($file));
                } else {
                    File::put(app_path().'/Models/'.$model_name.'.php',$printer->printFile($file));
                }
            }

//            elseif (isset($request->create_migration) && $request->create_migration == 'on') {
//                Artisan::call('make:migration', [
//                    'name'    => 'create_'.$table->name.'_table',
//                    '--table' => $table->name,
//                ]);
//            }

            return redirect()->route('shuttle.developer.database.index');
//        } catch (Exception $e) {
//            dd($e);
//            return back()->with($this->alertException($e))->withInput();
//        }
    }

    public function edit($table)
    {

        if (!SchemaManager::tableExists($table)) {
            return redirect()
                ->route('shuttle.developer.database.index')
                ->with($this->alertError(__('voyager::database.edit_table_not_exist')));
        }

        $db = $this->prepareDbManager('update', $table);

        return view('shuttle::developer.database.edit_add', compact('db'));
    }

    public function update(Request $request)
    {

        $table = json_decode($request->table, true);

        try {
            $database_updater = new DatabaseUpdater($table);
//            dd($database_updater->originalTable->diff($database_updater->table));
            $database_updater->updateTable();

            if($request->scaffold_update){
                $columns = collect($table['columns']);
                $model = $this->getModelFromTable($table['oldName']);
                $my_class = new \ReflectionClass($model);
                $class = ClassType::withBodiesFrom($model);
                foreach ($my_class->getTraits() as $trait){
                    foreach ($trait->getMethods() as $method){
                        $class->removeMethod($method->getName());
                    }
                    foreach ($trait->getProperties() as $property){
                        $class->removeProperty($property->getName());
                    }
                }
                $class
                    ->addProperty('fillable', $columns->where('fillable',true)->pluck('name')->toArray())
                    ->setProtected();
                $file = new PhpFile();
                $namespace = $file->addNamespace($my_class->getNamespaceName());
                $namespace->add($class);
                $printer = new Printer();
                File::put($my_class->getFileName(),$printer->printFile($file));

                $scaffoldInterface = ScaffoldInterface::where('model', get_class($model))->orWhere('translation_model', get_class($model))->first();
                if($scaffoldInterface)
                {
                    foreach($columns as $c)
                    {
                        $scaffoldInterface->rows()->firstOrCreate(
                            ['field' => $c['name']], 
                            ['display_name' => $c['name']]
                        );
                    }
                }
            
            }
//            DatabaseUpdater::update($table);
            // $this->cleanOldAndCreateNew($request->original_name, $request->name);
        } catch (Exception $e) {
            return back()->with($this->alertException($e))->withInput();
        }

        return redirect()->route('shuttle.developer.database.index');
    }

    public function show($table)
    {

        $additional_attributes = [];
        $model_name = ScaffoldInterface::where('name', $table)->first();
        if (isset($model_name)) {
            $model = app($model_name->model);
            if (isset($model->additional_attributes)) {
                foreach ($model->additional_attributes as $attribute) {
                    $additional_attributes[$attribute] = [];
                }
            }
            foreach($model_name->rows as $r)
            {
                $additional_attributes[$r->field] = [];
            }
        }

        return response()->json(collect(SchemaManager::describeTable($table))->merge($additional_attributes));
    }

    private function getModelFromTable($table)
    {
        foreach( getModels() as $class ) {
            if( is_subclass_of( $class, 'Illuminate\Database\Eloquent\Model' ) ) {
                $model = new $class;
                if ($model->getTable() === $table)
                    return $model;
            }
        }

        return false;
    }

    public function myShow(Request $request)
    {
//        return response()->json(collect(SchemaManager::describeTable(app($request->model)->getTable())));
        $additional_attributes = [];
        $model_name = ScaffoldInterface::where('name', $request->model)->first();
        if (isset($model_name)) {
            // $model = app($model_name);
//            dd($model->getFillable());
//            if (isset($model->additional_attributes)) {
                foreach ($model_name->rows as $attribute) {
                    $additional_attributes[$attribute->field] = [];
                }
//            }
        }

        return response()->json(collect(SchemaManager::describeTable($request->model))->merge($additional_attributes));
    }

    protected function prepareDbManager($action, $table = '')
    {
        $db = new \stdClass();
        // Need to get the types first to register custom types
        $db->types = Type::getPlatformTypes();

        if ($action == 'update') {
            $db->table = SchemaManager::listTableDetails($table);
            $db->formAction = route('shuttle.developer.database.update', $table);
        } else {
            $db->table = new Table('New Table');

            // Add prefilled columns
            $db->table->addColumn('id', 'integer', [
                'unsigned'      => true,
                'notnull'       => true,
                'autoincrement' => true,
            ]);

            $db->table->setPrimaryKey(['id'], 'primary');

            $db->formAction = route('shuttle.developer.database.store');
        }

        $oldTable = old('table');
        $db->oldTable = $oldTable ? $oldTable : json_encode(null);
        $db->action = $action;
        $db->identifierRegex = Identifier::REGEX;
        $db->platform = SchemaManager::getDatabasePlatform()->getName();

        return $db;
    }
}
