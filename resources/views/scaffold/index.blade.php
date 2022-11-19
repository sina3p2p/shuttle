@extends('shuttle::admin')
@section('breadcrumbs')
@include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'),
$scaffoldInterface->display_name_plural => route('shuttle.scaffold_interface.index',$scaffoldInterface)], 'btn' =>
($add) ? route('shuttle.scaffold_interface.create',$scaffoldInterface) : null])
@stop

@section('main')

@switch($scaffoldInterface->views)
@case('nested')
@include('shuttle::scaffold.index_nested')
@break
@default
@include('shuttle::scaffold.index_default')
@endswitch

@stop