<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\Component;
use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\Page;
use Sina\Shuttle\Models\PageComponent;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\Section;
use Sina\Shuttle\Models\ShortCode;
use Sina\Shuttle\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SectionController extends BaseController
{
    public function store(Type $type, Request $request)
    {
        $type->sections()->create([]);
        return redirect()->back()->withErrors([
            'success' => ['Section added']
        ]);
    }

    public function update(Section $section,Request $request)
    {

        $scaffold = ScaffoldInterface::where('model',$section->type->model)->with('rows')->first();
        $pages = $section->type->pages;
        $position = $request->position ?? 0;

        $sourceFile = resource_path("views/sections/");
        if(!File::isDirectory($sourceFile)){
            File::makeDirectory($sourceFile);
        }

        if($position == 0){
            foreach ($pages as $page) {
                foreach (config('laravellocalization.supportedLocales') as $lang => $val){
                    $contents = (new ShortCode)->parserCode($request->body, $scaffold, $request->model, [], $page->components()->wherePivot('locale',$lang)->get());
                    File::put($sourceFile.$lang.'/'.$page->id.".blade.php",$contents);
                }
            }
        }else{
            $contents = (new ShortCode)->parserCode($request->body, $scaffold, $request->model, [], []);
            File::put($sourceFile.$section->id.".blade.php",$contents);
        }

        $section->update($request->all());

        return redirect()->back()->withErrors([
            'success' => ['Section updated']
        ]);
    }

    public function userUpdate(Section $section,Request $request)
    {
        $lang =config('translatable.locales')[0];
        if($request->has('lang')){
            $lang = $request->lang;
        }

        $data = $request->except('translate');
        $data[$lang] = $request->translate;

        $section->update($data);

        return redirect()->back();
    }



    public function componentAdd(Request $request)
    {
        $lang = $request->get('lang',config('translatable.locales')[0]);
        $page = Page::where('id',$request->page_id)->with('type')->first();
        $component = Component::find($request->component_id);
        $scaffold = ScaffoldInterface::where('model',optional($page->type)->model)->with('rows')->first();
        $page->components()->attach([$component->id => ['setting' => [], 'locale' => $lang]]);
        $sourceFile = resource_path("views/sections/".$lang.'/');

        if(!File::isDirectory($sourceFile)){
            File::makeDirectory($sourceFile);
        }

        $contents = (new ShortCode)->parserCode(optional(optional(optional($page->type)->sections)->first())->body, $scaffold, $request->model, [], $page->components()->where('locale',$lang)->get());
        File::put($sourceFile.$page->id.".blade.php",$contents);

        if($this->is_api)
        {
            return ['components' => $page->components];
        }

        return redirect()->back()->withErrors([
            'success' => ['Section updated']
        ]);
    }

    public function sort(Request $request)
    {
//        $data = json_decode($request->data,true);

        $i = 1;
        foreach ($request->data ?? [] as $item) {
            $menuItem = PageComponent::find($item);
            if (!empty($menuItem)) {
                $menuItem->position = $i++;
                $menuItem->save();
            }
        }

        return $request->data;
    }

    public function componentRemove(PageComponent $pageComponent)
    {
        $lang = $pageComponent->locale;
        $page = Page::where('id',$pageComponent->page->id)->with('type')->first();
        $scaffold = ScaffoldInterface::where('model',optional($page->type)->model)->with('rows')->first();
        $pageComponent->delete();
        $sourceFile = resource_path("views/sections/".$lang.'/');
        if(!File::isDirectory($sourceFile)){
            File::makeDirectory($sourceFile);
        }

        $contents = (new ShortCode)->parserCode(optional(optional(optional($page->type)->sections)->first())->body, $scaffold, optional($page->type)->model, [], $page->components()->where('locale',$lang)->get());
        File::put($sourceFile.$page->id.".blade.php",$contents);

        if($this->is_api)
        {
            return $page->components()->orderBy('position')->wherePivot('locale',$lang)->get();
        }

        return redirect()->back()->withErrors([
            'success' => ['Section updated']
        ]);
    }

}
