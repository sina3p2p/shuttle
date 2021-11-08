<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Http\Request;
use Sina\Shuttle\Http\Controllers\ShuttleController;

class AdminController extends ShuttleController
{

    public function store(ScaffoldInterface $scaffold_interface, Request $request)
    {
        $request->merge([
            'password' => bcrypt($request->password),
        ]);
        return parent::store($scaffold_interface, $request);
    }

    public function update(ScaffoldInterface $scaffold_interface, Request $request, $id)
    {
        $view = parent::update($scaffold_interface, $request, $id);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return $view;
    }

    public function user(Request $request)
    {
        return $request->user();
    }

}
