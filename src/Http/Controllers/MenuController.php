<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\Menu;
use Sina\Shuttle\Models\MenuItem;
use Sina\Shuttle\Models\Page;
use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    public function index()
    {
//        $pages = Page::all();
//        $menus = Menu::where('pid',0)->where('type',0)->with(['children','page'])->orderby('position')->get();
        $menus = Menu::paginate(100);
//        $table = new Table($menus,[['name' => 'name'],['name' => 'created_at'],['name' => 'updated_at']],'menu');
//        $table->setUrl("/mygo/");
        if($this->is_api)
        {
            return $menus;
        }
        return view('shuttle::menu.index',compact('menus'));
    }

    public function create()
    {
        $menuable = array([
            'display_name_plural' => 'გვერდები',
            'model' => 'Sina\Shuttle\Models\Page',
            'data' => Page::all()
        ]);
        $scaffolds = ScaffoldInterface::select('model', 'display_name_plural', 'menuable')->where('menuable', true)->get();
        foreach ($scaffolds as $s){
            $menuable[] =  array_merge(['data' => app($s->model)->all()], $s->toArray());
        }
        $menu = new Menu();
        $menu_items = [];
//        $menus = Menu::where('pid',0)->where('type',0)->with(['children','page'])->orderby('position')->get();
        return view('shuttle::menu.edit_add',compact('menuable','menu','menu_items'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $menu = Menu::firstOrCreate(['name' => $request->name],['name' => $request->name]);
//        $menu = Menu::create($request->all());
        $item = $menu->items()->create($request->all());
        return response()->json($item->load('menuable'));
    }

    public function edit(Menu $menu)
    {
        $menuable = array([
            'display_name_plural' => 'გვერდები',
            'model' => 'Sina\Shuttle\Models\Page',
            'data' => Page::all()
        ]);
        $scaffolds = ScaffoldInterface::select('model', 'display_name_plural', 'menuable')->where('menuable', true)->get();
        foreach ($scaffolds as $s){
            $menuable[] =  array_merge(['data' => app($s->model)->all()], $s->toArray());
        }
//        $menu = $menu->load('items.recursiveChildren.menuable');
//        $menu = $menu->items()->with('menuable')->toTree();
        $menu_items = MenuItem::where('menu_id',$menu->id)->with('menuable')->orderBy('lft')->get()->toTree();
        return view('shuttle::menu.edit_add',compact('menu','menuable','menu_items'));
    }

    public function destroy(Menu $menu)
    {
        $menu->items()->delete();
        $menu->delete();
        return redirect()->route('shuttle.menu.index');
    }

    public function itemsUpdate(MenuItem $menu_item, Request $request)
    {
        $menu_item->update($request->all());
        return redirect()->back()->withErrors([
            'success' => ['Update successful']
        ]);
    }

    public function itemsDestroy(MenuItem $menu_item)
    {
        $menu_item->children()->delete();
        $menu_item->delete();
    }

    public function sort(Scaffoldinterface $scaffold_interface,Request $request)
    {
        $data = json_decode($request->data,true);
        MenuItem::scoped([ 'menu_id' => $request->menu_id ])->rebuildTree($data);
        return redirect()->route("shuttle.menu.index");
    }

//    public function sort(Request $request) {
//        $data = json_decode($request->data,true);
//
//        $recursiveFunc = function ($items, $parent_id) use(&$recursiveFunc) {
//            $i = 1;
//            foreach ($items as $item) {
//                $menuItem = MenuItem::find($item['id']);
//                if (!empty($menuItem)) {
//                    $menuItem->position = $i++;
//                    $menuItem->pid = $parent_id;
//                    $menuItem->save();
//                    if (!empty($item['children'])) {
//                        $recursiveFunc($item['children'], $item['id']);
//                    }
//                }
//            }
//        };
//
//        $recursiveFunc($data, 0);
//
//        return redirect()->route('admin.menu.index');
//    }
}
