<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\ScaffoldInterface;
use Illuminate\Http\Request;

class ScaffoldController extends ShuttleController
{

    public function index(ScaffoldInterface $scaffold_interface, Request $request)
    {
        if($scaffold_interface->controller){
            $c = new $scaffold_interface->controller();
            if(method_exists($c, 'index')) {
                return $c->index($scaffold_interface, $request);
            }
        }
        return parent::index($scaffold_interface, $request);
    }

    public function create(ScaffoldInterface $scaffold_interface, Request $request)
    {
        if($scaffold_interface->controller){
            $c = new $scaffold_interface->controller();
            if(method_exists($c, 'create')) {
                return $c->create($scaffold_interface, $request);
            }
        }
        return parent::create($scaffold_interface, $request);
    }

    public function store(ScaffoldInterface $scaffold_interface, Request $request)
    {
        if($scaffold_interface->controller){
            $c = new $scaffold_interface->controller();
            if(method_exists($c, 'store')) {
                return $c->store($scaffold_interface, $request);
            }
        }

        return parent::store($scaffold_interface, $request);
    }

    public function edit(ScaffoldInterface $scaffold_interface, $id, Request $request)
    {
        if($scaffold_interface->controller){
            $c = new $scaffold_interface->controller();
            if(method_exists($c, 'edit')) {
                return $c->edit($scaffold_interface, $id, $request);
            }
        }
        return parent::edit($scaffold_interface, $id, $request);
    }

    public function update(Request $request, ScaffoldInterface $scaffold_interface, $id)
    {
        if($scaffold_interface->controller){
            $c = new $scaffold_interface->controller();
            if(method_exists($c, 'update')) {
                return $c->update($request, $scaffold_interface, $id);
            }
        }
        return parent::update($request, $scaffold_interface, $id);
    }

    public function show(Request $request, ScaffoldInterface $scaffold_interface, $id)
    {
        if($scaffold_interface->controller){
            $c = new $scaffold_interface->controller();
            if(method_exists($c, 'show')) {
                return $c->show($request, $scaffold_interface, $id);
            }
        }
        return parent::show($request,$scaffold_interface, $id);
    }
}
