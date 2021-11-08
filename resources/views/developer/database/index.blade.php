@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'ბაზები' => route('shuttle.developer.database.index')], 'btn' => route('shuttle.developer.database.create')])
@stop

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped  text-center">
                        <thead>
                            <tr>
                                <th>Table name</th>
                                <th>Scaffold Actions</th>
                                <th>Table Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tables as $table)
{{--                            @continue(in_array($table->name, config('voyager.database.tables.hidden', [])))--}}
                            <tr>
                                <td>{{ $table->name }}</td>
                                <td>
                                @if($table->dataTypeId)
                                    <a href="{{route('shuttle.scaffold_interface.index', $table->name)}}"
                                       class="btn-sm btn-warning">Browse</a>
                                    <a href="{{route('shuttle.developer.bread.edit',$table->name)}}"
                                       class="btn-sm btn-primary">Edit</a>
                                @else
                                    <a href="{{route('shuttle.developer.bread.create',['table' => $table->name])}}"
                                       class="btn-sm btn-secondary">
                                       Create Bread</a>
                                @endif
                                </td>
                                <td>
                                    <a href="{{ route('shuttle.developer.database.edit', $table->prefix.$table->name) }}" class="btn-sm btn-primary">
                                       Edit</a>
                                    <a href="#" class="btn-sm btn-danger delete_table @if($table->dataTypeId) remove-bread-warning @endif">
                                        Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
