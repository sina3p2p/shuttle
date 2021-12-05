@php
    $edit = !is_null($dataTypeContent->getKey());
@endphp

@extends('shuttle::admin')

{{-- @push('css-vendors')
    <link rel="stylesheet" href="{{asset('shuttle/css/vendor/dropzone.min.css')}}" />
    <link rel="stylesheet" href="{{asset('shuttle/css/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('shuttle/css/vendor/select2-bootstrap.min.css')}}" />
@endpush --}}

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), $scaffold_interface->display_name_plural => route('shuttle.scaffold_interface.index',$scaffold_interface)]])
@stop

@section('main')
<div class="row">
    <div class="@if($scaffold_interface->translation_model) col-md-9 col-12  @else col-12 @endif">
        @includeIf($view)
    </div>
    @if($scaffold_interface->translation_model)
    <div class="col-md-3 col-12">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <ul class="langs">
                            @foreach(config('translatable.locales') as $translate)
                            <li @if($lang == $translate) class="active" @endif><a href="?lang={{$translate}}"><img src="{{asset('assets/img/'.$translate.'.png')}}" alt="{{$translate}}">{{$translate}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop
