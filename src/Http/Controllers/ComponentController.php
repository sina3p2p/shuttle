<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\Component;
use App\Http\Controllers\Controller;
use Illuminate\Database\Console\Migrations\BaseCommand;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\Section;
use Sina\Shuttle\Models\SectionComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Models\PageComponent;
use Sina\Shuttle\Models\ShortCode;

class ComponentController extends BaseController
{

//    use ShortCodeTrait;

    public function index()
    {
        $components = Component::all();

        if($this->is_api)
        {
            return $components;
        }

        return view('shuttle::developer.component.index',compact('components'));
    }

    public function create()
    {
        $component = new Component();
        return view('shuttle::developer.component.edit_add',compact('component'));
    }

    public function store(Request $request)
    {

        $array = json_decode($request->myData,true);
        $data = collect($array);
        $modeData = json_decode($request->myModelData,true);
        $scaffold = ScaffoldInterface::whereModel(data_get($modeData,'model.name'))->with('rows')->first();

        $name =  Str::slug($request->name, '_');

        $content = (new ShortCode)->parserCode($request->html,$scaffold, data_get($modeData, 'model', []),$array,[],true);

        // if(!File::isDirectory(resource_path('views/components/'))){
        //     File::makeDirectory(resource_path('views/components/'));
        // }

        // File::put(resource_path('views/components/'.$name.'.blade.php'),$content);

        $component = Component::create([
            'name' => $name,
            'display_name' => $request->display_name,
            'settings' => $data->toArray(),
            'model' => ($scaffold) ? $scaffold->model : null,
            'model_settings' => $modeData ?? null,
            'content' => $request->html,
            'icon' => $request->icon ?? 'iconsmind-Puzzle',
        ]);

        // foreach($data as $d)
        // {
        //     $row = $component->rows()->create($d);
            
        // }

        $this->saveRows($component, $data);

        // dd($data);

        return redirect()->back();

    }

    protected function saveRows(Component $component, $rows, $pid = 0)
    {
        foreach($rows as $r)
        {
            $r['parent_id'] = $pid;
            $row = $component->rows()->updateOrCreate(['field' => $r['field']], $r);
            if(isset($r['children']));
            {
                try{
                    if(is_array($r['children']) && count($r['children']))
                    {
                        $this->saveRows($component, $r['children'], $row->id);
                    }
                }
                catch(\Exception $e)
                {
                    
                }
            }
        }
    }

    public function edit(Component $component)
    {
        $component->load('rows.children');
        return view('shuttle::developer.component.edit_add',compact('component'));
    }

    public function update(Component $component,Request $request)
    {

        $array = json_decode($request->myData,true);
        $data = collect($array);
        $modeData = json_decode($request->myModelData,true);
        $scaffold = ScaffoldInterface::whereModel(data_get($modeData,'model.name'))->with('rows')->first();

        $component->update([
            'settings' => $data->toArray(),
            'content' => $request->html,
            'model' => ($scaffold) ? $scaffold->model : null,
            'model_settings' => $modeData ?? null,
            'display_name' => $request->display_name,
            'icon' => $request->icon,
        ]);


        // foreach($data as $d)
        // {
        //     $component->rows()->updateOrCreate([
        //         'field' => $d['field']
        //     ], $d);
        // }


        $content = ShortCode::parserCode($request->html,$scaffold, data_get($modeData, 'model', []),$component->rows,[],true);

        if(!File::isDirectory(resource_path('views/components/'))){
            File::makeDirectory(resource_path('views/components/'));
        }

        File::put(resource_path('views/components/'.$component->name.'.blade.php'),$content);

        // dd($data);

        $this->saveRows($component, $data);

        return redirect()->back();
    }

    public function destroy(Component $component)
    {
        SectionComponent::where('component_id',$component->id)->delete();
        $component->delete();
        return redirect()->back();
    }

    public function show(PageComponent $pageComponent, Request $request)
    {
        $pageComponent->load('component');
        if($request->mode == "json")
        {
            $pageComponent->append('data');
            return $pageComponent;
        }
        return view("components.".$pageComponent->component->name, ["data" => $pageComponent->getComponentData($request->route())])->render();
    }

    public function jsData(Section $section)
    {
//        dd($section->components()->get()->toArray());
        $components = $section->components()->wherePivot('locale', LaravelLocalization::getCurrentLocale())->get();
        $js = 'window.this_section_components ='.$components->pluck('settings','name')->toJson().'; window.this_section_components_setting ='.$components->pluck('pivot.setting','name')->toJson()
            .'; window.component_ids ='.$components->pluck('id','name')->toJson();
        return response($js)->header('Content-Type', 'application/javascript');
//        $js = 'window.model = "'.$modelKey.'"; window.'.$modelKey.' ='.json_encode($model->all()->toArray());
//        return response($js)->header('Content-Type', 'application/javascript');
//        dd($section->components()->get()->pluck('settings','name')->toJson());
    }

}
