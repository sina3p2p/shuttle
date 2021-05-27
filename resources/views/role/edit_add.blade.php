@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" href="{{asset('css/admin/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/admin/vendor/select2-bootstrap.min.css')}}" />
@endpush

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>@if(isset($dataType->id)){{$dataType->display_name_singular}}@else ახლის როლი @endif</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.roles.index')}}">გვერდები</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">@if(isset($dataType->id)){{$dataType->display_name_singular}}@else ახლის როლი @endif</a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="separator mb-5"></div>
        </div>
    </div>
@stop

@section('main')
    <div class="content-body">
        <form action="@if(isset($role->id)){{ route('shuttle.roles.update', $role->id) }}@else{{ route('shuttle.roles.store') }}@endif" method="POST">
            @if(isset($role->id))
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary panel-bordered">
                        <div class="panel-heading">
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="name">Role Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{$role->name}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4"><i class="voyager-window-list"></i>მომხმარებლის უფლებამოსილებები:</h5>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Browse</th>
                                    <th scope="col">Add</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scaffolds as $sf => $name)
                                    <tr>
                                        <td class="align-middle">
                                           {{$loop->iteration}}
                                        </td>
                                        <td class="align-middle">
                                            <h3><strong>{{ $name }}</strong></h3>
                                        </td>
                                        <td class="align-middle">
                                            <input type="checkbox"
                                                   id="field_browse_{{ $sf }}"
                                                   name="permissions[{{ $sf }}_browse]" value="1" @if(in_array($sf.'_browse',$permissions)) checked @endif>
                                            <label for="field_browse_{{ $sf }}">Browse</label><br/>
                                        </td>
                                        <td class="align-middle">
                                            <input type="checkbox"
                                                   id="field_add_{{ $sf }}"
                                                   name="permissions[{{ $sf }}_add]" value="1" @if(in_array($sf.'_add',$permissions)) checked @endif>
                                            <label for="field_add_{{ $sf }}">Add</label><br/>
                                        </td>
                                        <td class="align-middle">
                                            <input type="checkbox"
                                                   id="field_edit_{{ $sf }}"
                                                   name="permissions[{{ $sf }}_edit]" value="1" @if(in_array($sf.'_edit',$permissions)) checked @endif>
                                            <label for="field_edit_{{ $sf }}">Edit</label><br/>
                                        </td>
                                        <td class="align-middle">
                                            <input type="checkbox"
                                                   id="field_delete_{{ $sf }}"
                                                   name="permissions[{{ $sf }}_delete]" value="1" @if(in_array($sf.'_delete',$permissions)) checked @endif>
                                            <label for="field_delete_{{ $sf }}">Delete</label><br/>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn pull-right btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@stop
