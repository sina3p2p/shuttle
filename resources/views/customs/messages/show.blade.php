@extends('layouts.admin')

@section('breadcrumbs')
    @include('admin.includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('admin.index'), $scaffold_interface->display_name_plural => route('admin.scaffold_interface.index',$scaffold_interface)], 'btn' => route('admin.scaffold_interface.create',$scaffold_interface)])
@stop

@section('main')
    <div class="content-body">
        <!-- Basic example section start -->
        <div class="row" id="table-responsive">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">სათაური</th>
                                        <th scope="col">სათაური</th>
                                        <th scope="col">სათაური</th>
                                        <th scope="col">სათაური</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataTypeContent->users as $user)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td><img src="{{$user->image}}"></td>
                                            <td>{{$user->fullName}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->tel}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
