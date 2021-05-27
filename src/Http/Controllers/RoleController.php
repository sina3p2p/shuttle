<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        return view('shuttle::role.index',compact('roles'));
    }

    public function create()
    {
        $scaffolds = ScaffoldInterface::select('name','display_name_plural')->get()->pluck('display_name_plural','name')->merge(['pages' => 'page','settings' => 'setting','roles' => 'role', 'translates' => 'translate', 'menus' => 'menu']);
        $role = new Role();
        $permissions = [];
        return view('shuttle::role.edit_add',compact('permissions','scaffolds', 'role'));
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        foreach ($request->permissions ?? [] as $per => $value){
            $permission = Permission::firstOrCreate(['name' => $per]);
            $role->givePermissionTo($permission);
        }

        return redirect()->route('shuttle.roles.index')->withErrors(['success' => ['Role Saved Successfully']]);

    }

    public function edit(Role $role)
    {
        $scaffolds = ScaffoldInterface::select('name','display_name_plural')->get()->pluck('display_name_plural','name')->merge(['pages' => 'page','settings' => 'setting','roles' => 'role', 'translates' => 'translate', 'menus' => 'menu']);
        $permissions = $role->getAllPermissions()->pluck('name')->toArray();
        return view('shuttle::role.edit_add',compact('permissions', 'scaffolds', 'role'));
    }

    public function update(Role $role,Request $request)
    {
        $my_permissions = array();
        foreach ($request->permissions ?? [] as $per => $value){
            $permission = Permission::firstOrCreate(['name' => $per]);
            $my_permissions[] = $permission;
        }

        $role->syncPermissions($my_permissions);

        return redirect()->route('shuttle.roles.index')->withErrors(['success' => ['Role Saved Successfully']]);

    }
}
