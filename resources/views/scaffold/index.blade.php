@extends('shuttle::admin')
@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), $scaffold_interface->display_name_plural => route('shuttle.scaffold_interface.index',$scaffold_interface)], 'btn' => ($add) ? route('shuttle.scaffold_interface.create',$scaffold_interface) : null])
@stop

@section('main')

@switch($scaffold_interface->views)
    @case('nested')
        @include('shuttle::scaffold.index_nested')
        @break
    @default
        @include('shuttle::scaffold.index_default')
@endswitch

@stop


