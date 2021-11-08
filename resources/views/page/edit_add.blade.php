@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" type="text/css" href="{{route('shuttle.assets','css/vendor/bootstrap-tagsinput.css')}}">
@endpush

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>@if($add) ახლის დამატება @else {{$page->title}} @endif</h1>
                @if(!$add)
                <div class="float-sm-right text-zero">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-backdrop="static"
                            data-target="#componentModal">კომპონენტის დამატება</button>
                </div>
                @endif
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.page.index')}}">გვერდები</a>
                        </li>
                        <li class="breadcrumb-item active">
                           @if($add) ახლის დამატება @else {{$page->title}} @endif
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="separator mb-5"></div>
        </div>
    </div>
@stop

@section('main')
    <div id="app">
        <div class="content-body">
            <section id="nav-filled">
                <div class="row">
                    <div class="col-md-9 col-12">
                        @include('shuttle::page.includes.user-editor')
                    </div>
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
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade modal-right" id="componentModal" tabindex="-1" role="dialog" aria-labelledby="componentModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">კომპონენტის დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 1.8rem">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($components as $com)
                            <div class="card mb-2">
                                <div class="card-body text-center">
                                    <i class="{{$com->icon}}"></i>
                                    <p class="card-text font-weight-semibold mb-0 cname">{{$com->display_name}}</p>
                                    <a href="{{route('shuttle.user_component_store', ['component_id'=> $com->id,'page_id' => $page->id,'lang' => $lang])}}" class="btn btn-sm btn-outline-primary ">დამატება</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js-vendor')
    <script src="{{route('shuttle.assets','js/vendor/dropzone.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/dore-plugins/select.from.library.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/bootstrap-tagsinput.min.js')}}"></script>
@endpush
@push('js')
    <script src="{{route('shuttle.model.js.data',['model' => 'component'])}}"></script>
@endpush
