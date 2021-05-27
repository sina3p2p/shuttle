<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\Component;
use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\Section;
use Sina\Shuttle\Models\SectionComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Sina\Shuttle\Models\ShortCode;

class ComponentController extends Controller
{

//    use ShortCodeTrait;

    public function index()
    {
        $components = Component::all();
        return view('shuttle::component.index',compact('components'));
    }

    public function create()
    {
        $component = new Component();
        return view('shuttle::component.edit_add',compact('component'));
    }

    public function store(Request $request)
    {

        $array = json_decode($request->myData,true);
        $data = collect($array);
        $modeData = json_decode($request->myModelData,true);
        $scaffold = ScaffoldInterface::whereModel(data_get($modeData,'model.name'))->with('rows')->first();

        $name =  Str::slug($request->name, '_');

        $content = (new ShortCode)->parserCode($request->html,$scaffold, data_get($modeData, 'model', []),$array,[],true);

        if(!File::isDirectory(resource_path('views/components/'))){
            File::makeDirectory(resource_path('views/components/'));
        }

        File::put(resource_path('views/components/'.$name.'.blade.php'),$content);

        Component::create([
            'name' => $name,
            'display_name' => $request->display_name,
            'settings' => $data->toArray(),
            'model' => ($scaffold) ? $scaffold->model : null,
            'model_settings' => $modeData ?? null,
            'content' => $request->html,
            'icon' => $request->icon ?? 'iconsmind-Puzzle',
        ]);

        return redirect()->back();

    }

    public function edit(Component $component)
    {
        return view('shuttle::component.edit_add',compact('component'));
    }

    public function update(Component $component,Request $request)
    {

        $array = json_decode($request->myData,true);
        $data = collect($array);
        $modeData = json_decode($request->myModelData,true);
        $scaffold = ScaffoldInterface::whereModel(data_get($modeData,'model.name'))->with('rows')->first();

        $content = ShortCode::parserCode($request->html,$scaffold, data_get($modeData, 'model', []),$array,[],true);

        if(!File::isDirectory(resource_path('views/components/'))){
            File::makeDirectory(resource_path('views/components/'));
        }

        File::put(resource_path('views/components/'.$component->name.'.blade.php'),$content);

        $component->update([
            'settings' => $data->toArray(),
            'content' => $request->html,
            'model' => ($scaffold) ? $scaffold->model : null,
            'model_settings' => $modeData ?? null,
            'display_name' => $request->display_name,
            'icon' => $request->icon,
        ]);

        return redirect()->back();
    }

    public function destroy(Component $component)
    {
        SectionComponent::where('component_id',$component->id)->delete();
        $component->delete();
        return redirect()->back();
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
