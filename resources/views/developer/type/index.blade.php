@extends('shuttle::admin')
@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'ტიპები' => route('shuttle.developer.type.index')], 'btn' => route('shuttle.developer.type.create')])
@stop
@section('main')
    <div class="content-body">
        <div class="row" id="table-responsive">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ტიპი სახელი</th>
                                        <th>ტიპი მოდელი</th>
                                        <th>შექმნა</th>
                                        <th>განალება</th>
                                        <th>აქტივობები</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($types as $type)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$type->name}}</td>
                                            <td>{{$type->model}}</td>
                                            <td>{{$type->created_at}}</td>
                                            <td>{{$type->updated_at}}</td>
                                            <td>
                                                <a href="{{route('shuttle.developer.type.edit',$type)}}" class="btn btn-primary default">რედაქტირება</a>
                                                <button type="button" class="btn btn-danger default">წაშლა</button>
                                            </td>
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
