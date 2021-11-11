<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\Component;
use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\MenuItem;
use Sina\Shuttle\Models\Page;
use Sina\Shuttle\Models\PageComponent;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\Section;
use Sina\Shuttle\Models\ShortCode;
use Sina\Shuttle\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PageController extends BaseController
{

    public function index()
    {
        $pages = Page::paginate(100);
        if($this->is_api)
        {
            return $pages;
        }
        return view('shuttle::page.index',compact('pages'));
    }

    public function create(Request $request)
    {
        $lang = $request->get('lang',config('translatable.locales')[0]);
        $page = new Page();
        $add = true;
        $components = Component::all();
        $types = Type::all();
        return view('shuttle::page.edit_add',compact('lang','page', 'add', 'components', 'types'));
    }

    public function store(Request $request)
    {
        $lang = $request->get('lang',config('translatable.locales')[0]);
        $data = $request->all();
        $data['url'] = Str::slug(localizeGeorgianToEnglish(data_get($request->{$lang},'title')));
        $page = Page::create($data);
        if($page->type){
            $scaffold = ScaffoldInterface::where('model',optional($page->type)->model)->with('rows')->first();
            $sourceFile = resource_path("views/sections/");
            if(!File::isDirectory($sourceFile)){
                File::makeDirectory($sourceFile);
            }
            foreach ($page->type->sections as $key => $section){
                $contents = (new ShortCode)->parserCode($section->body, $scaffold,[], [], []);
                if($key == 0){
                    foreach (config('laravellocalization.supportedLocales') as $lang2 => $lang3){
                        File::put($sourceFile.$lang2.'/'.$page->id.".blade.php",$contents);
                    }
                }else{
                    File::put($sourceFile.$section->id.".blade.php",$contents);
                }
            }
        }
        return redirect()
            ->route('shuttle.page.edit',$page->id)
            ->withErrors([
                'success' => ['Page Saved Successfully']
            ]);
    }


    public function edit(Page $page,Request $request)
    {
        $lang = $request->get('lang',config('translatable.locales')[0]);
        $page->setDefaultLocale($lang);
        $page = $page->load(['components' => function($q) use ($lang){
            return $q->orderBy('position')->wherePivot('locale',$lang);
        }]);
        $add = false;
        if($this->is_api)
        {
            return $page;
        }
        $components = Component::all();
        $types = Type::all();
        return view('shuttle::page.edit_add',compact('page','lang','add', 'components', 'types'));
    }

    public function update(Page $page,Request $request)
    {
        $page->update($request->all());
        return redirect()->back()->withErrors([
            'success' => ['Page Saved Successfully']
        ]);
    }

    public function destroy(Page $page)
    {
        MenuItem::where('menuable_type', Page::class)->where('menuable_id', $page->id)->delete();
        $page->components()->detach();
        $page->delete();
        return redirect()->route('shuttle.page.index');
    }

    public function componentEditor(PageComponent $page_component)
    {
        $page_component = $page_component->load('component.rows.children');
        if($this->is_api)
        {
            $page_component->data = $page_component->data;
            return $page_component;
        }
        return view('shuttle::page.component',compact('page_component'));
    }

    public function componentSave(PageComponent $page_component,Request $request)
    {

//        try {
//            return app()->make('App\Http\Controllers\ComponentController')->componentSave($request);
//        } catch(\Exception $e) {
//            $page_component->update([
//                'setting' => json_decode($request->json)
//            ]);
//        }

        $page_component->update([
            'setting' => $request->all()
        ]);

        return redirect()->route('shuttle.user_component',$page_component)->withErrors([
            'success' => ['Component Saved Successfully']
        ]);
    }

    public function componentSave2(PageComponent $page_component,Request $request)
    {

        $values = $request->except('_method', '_token');
        $files = Arr::dot($request->allFiles());
        foreach($files as $key => $file) Arr::set($values, $key, $file->store('public/upload'));

        $page_component->update([
            'setting' => $values
        ]);

        if($this->is_api)
        {
            return ['success' => true];
        }

        return redirect()->route('shuttle.user_component',$page_component)->withErrors([
            'success' => ['Component Saved Successfully']
        ]);
    }
}
