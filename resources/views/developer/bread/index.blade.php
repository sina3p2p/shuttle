@extends('shuttle::admin')


@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'მოდელები' => route('shuttle.developer.bread.index')]])
@stop

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped  text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Table name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($tables as $table)
{{--                        @continue(in_array($table->name, config('voyager.database.tables.hidden', [])))--}}
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $table->name }}
                            </td>
                            <td>
                                @if($table->dataTypeId)
                                    <a href="{{ route('shuttle.scaffold_interface.index',$table->slug) }}" class="btn btn-warning">Browse</a>
                                    <a href="{{ route('shuttle.developer.bread.edit', $table->name) }}" class="btn btn-primary">Edit</a>
                                    <a href="#delete-bread" data-id="{{ $table->dataTypeId }}" data-name="{{ $table->name }}" class="btn btn-danger delete">Delete</a>
                                @else
                                    <a href="{{ route('shuttle.developer.bread.create', $table->name) }}" class="btn btn-secondary">Create Bread</a>
                                @endif
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
