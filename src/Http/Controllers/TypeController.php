<?php

namespace Sina\Shuttle\Http\Controllers;

use Sina\Shuttle\Models\Component;
use App\Http\Controllers\Controller;
use Sina\Shuttle\Models\ScaffoldInterface;
use Sina\Shuttle\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{

    public function index()
    {
        return view('shuttle::developer.type.index',['types' => Type::all()]);
    }

    public function create(Request $request)
    {
        $type = new Type();
        $add = true;
        $components = Component::all();
        $query_builder = collect([]);
        return view('shuttle::developer.type.edit_add', compact('type','components','add','query_builder'));
    }

    public function store(Request $request)
    {
        $type = Type::create($request->all());
        $type->sections()->create([]);
        return redirect()->route('shuttle.developer.type.index');
    }

    public function edit(Type $type)
    {
        $type = $type->load('sections');
        $add = false;
        $components = Component::all();
        $rows = [];
        if($type->model){
            $rows = optional(ScaffoldInterface::where('model',$type->model)->first())->rows ?? [];
        }
        $query_builder = [];
        $query_builder_types = [
            'text' => 'string',
            'timestamp' => 'datetime'
        ];
//        dd($rows->toArray());
        foreach ($rows as $r){
            $query_builder[] = [
                'id'    => $r->field,
                'label' => $r->field,
                'type' => data_get($query_builder_types, $r->type,'string')
            ];
        }

        $query_builder = collect($query_builder);
//        dd($query_builder);
        return view('shuttle::developer.type.edit_add', compact('type','components','add','query_builder'));
    }
}
