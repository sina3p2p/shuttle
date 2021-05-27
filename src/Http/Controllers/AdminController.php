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

    public function update(Request $request, ScaffoldInterface $scaffold_interface, $id)
    {
        $view = parent::update($request, $scaffold_interface, $id);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return $view;
    }

}
