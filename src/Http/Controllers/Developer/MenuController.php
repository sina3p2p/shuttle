<?php

namespace Sina\Shuttle\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\Menu;
use Sina\Shuttle\Models\MenuItem;
use Sina\Shuttle\Models\Page;
use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Http\Request;
use Sina\Shuttle\Http\Controllers\BaseController;

class MenuController extends BaseController
{
    public function index()
    {
        $menu = Menu::firstOrCreate(
            ['name' => 'shuttle_menu']
        );
        $menuable = array([
            'display_name_plural' => 'Models',
            'model' => 'Sina\Shuttle\Models\ScaffoldInterface',
            'data' => ScaffoldInterface::all(),
            'key'  => 'name',
        ]);
        $menu_items = MenuItem::where('menu_id',$menu->id)->with('menuable')->orderBy('lft')->get()->toTree();
        return view('shuttle::developer.menu.index',compact('menu','menuable','menu_items'));
    }
}
