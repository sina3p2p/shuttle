@extends('shuttle::admin')

@section('breadcrumbs')
<div class="row">
    <div class="col-12">
        <div class="mb-2">
            <h1>@if($component->id){{$component->display_name}}@else New Component @endif</h1>
            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                <ol class="breadcrumb pt-0">
                    <li class="breadcrumb-item">
                        <a href="{{route('shuttle.index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('shuttle.component.index')}}">Components</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">@if($component->id){{$component->display_name}}@else New Component @endif</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="separator mb-5"></div>
    </div>
</div>
@stop

@section('main')
<div class="card">
    <div class="card-header pl-0 pr-0">
        <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#general-fill" role="tab"
                    aria-controls="home-fill" aria-selected="true">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="messages-tab-fill" data-toggle="tab" href="#messages-fill" role="tab"
                    aria-controls="messages-fill" aria-selected="false">Data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="settings-tab-fill" data-toggle="tab" href="#settings-fill" role="tab"
                    aria-controls="settings-fill" aria-selected="false">Code</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <form
            action="{{($component->id) ? route('shuttle.component.update',$component->id) : route('shuttle.component.store')}}"
            method="post">
            @csrf
            @if($component->id)
            @method('PUT')
            @endif
            <div class="tab-content pt-1">
                <div class="tab-pane active" id="general-fill" role="tabpanel" aria-labelledby="general-tab-fill">
                    <div class="form form-vertical">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="component-name">Component Name</label>
                                        <input type="text" id="component-name" class="form-control" name="name"
                                            placeholder="Name" value="{{$component->name}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="component-name">Component Display Name</label>
                                        <input type="text" id="component-name" class="form-control" name="display_name"
                                            placeholder="Name" value="{{$component->display_name}}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="component-name">Component Icon</label>
                                        <input type="text" id="component-name" class="form-control" name="icon"
                                            placeholder="Name" value="{{$component->icon}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="messages-fill" role="tabpanel" aria-labelledby="messages-tab-fill">
                    <component-tab-data :rows="{{ json_encode($component->rows) }}"></component-tab-data>
                </div>
                <div class="tab-pane" id="settings-fill" role="tabpanel" aria-labelledby="settings-tab-fill">
                    <component-tab-code>
                        <textarea id="html" v-pre>{{ $component->content }}</textarea>
                    </component-tab-code>
                </div>
            </div>
            <button type="submit" class="card-link btn btn-primary mt-2">Save</button>
        </form>
    </div>
</div>
@endsection