@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'კომპონენტები' => route('shuttle.component.index')], 'btn' => route('shuttle.component.create')])
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
                                    <th>კომპონენტის სახელი</th>
                                    <th>შექმნა</th>
                                    <th>განალება</th>
                                    <th>აქტივობები</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($components as $com)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$com->name}}</td>
                                        <td>{{$com->created_at}}</td>
                                        <td>{{$com->updated_at}}</td>
                                        <td>
                                            <a href="{{route('shuttle.component.edit',$com)}}" class="btn btn-primary default">რედაქტირება</a>
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
