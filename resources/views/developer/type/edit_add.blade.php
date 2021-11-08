@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" type="text/css" href="{{route('shuttle.assets','css/vendor/query-builder.default.css')}}">
@endpush

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>@if($add) New Type @else {{$type->display_name}} @endif</h1>
                @if(!$add)
                <form action="{{route('shuttle.section.store',$type)}}" method="post" class="float-sm-right text-zero">
                    @csrf
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-backdrop="static"
                            data-target="#componentModal">კომპონენტის დამატება</button>
                    <button type="submit" class="btn btn-primary ml-1"><i class="simple-icon-plus"></i></button>
                </form>
                @endif

                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.developer.type.index')}}">ტიპები</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">@if($add) New Type @else {{$type->display_name}} @endif</a>
                        </li>
                    </ol>
                </nav>
                <div class="separator mb-5"></div>
            </div>
        </div>
    </div>
@stop

@section('main')
    <div id="app2">
{{--        <modal v-if="showModal" @close="showModal = false" :component="component" :mydata="editingComponent"></modal>--}}
        <div class="content-body">
            <section id="nav-filled">
                <div class="row">
                    <div class="col-md-9 col-12">
                        @if($add)
                            <div class="alert alert-warning">
                                Please Save this type to add Section and codes
                            </div>
                        @else
                            @foreach($type->sections ?? [] as $key=>$section)
                                <form action="{{route('shuttle.section.update',$section->id)}}" method="post" class="update-section">
                                    @method('put') @csrf
                                    @include('shuttle::page.includes.dev-editor', ['index' => $loop->index])
                                </form>
                            @endforeach
                                <form action="{{route('shuttle.section.store',$type)}}" method="post" class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm mb-2"><i class="simple-icon-plus btn-group-icon"></i>Add Section</button>
                                </form>
                        @endif
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <form action="{{ ($add) ? route('shuttle.developer.type.store') : route('shuttle.developer.type.update',$type->id)}}" class="form form-vertical" method="post">
                                            @csrf @if(!$add) @method('put') @endif
                                            <div class="form-group">
                                                <label for="type-name">გვერდის მისამართი</label>
                                                <input type="text" id="first-name-icon" class="form-control" name="name" value="{{$type->name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="type-display-name">გვერდის მისამართი</label>
                                                <input type="text" id="type-display-name" class="form-control" name="display_name" value="{{$type->display_name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="type-model">Model</label>
                                                <select id="type-model" class="form-control" name="model">
                                                    <option label=""></option>
                                                    @foreach(getModels() as $m)
                                                        <option value="{{$m}}" @if($m == $type->model) selected @endif>{{$m}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mb-0">დასტური</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade modal-right" id="componentModal" tabindex="-1" role="dialog"
         aria-labelledby="componentModal" aria-hidden="true">
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
                                        <a href="{{route('shuttle.user_component_store', ['component_id'=> $com->id,'section_id' => optional(optional($type->sections)->first())->id])}}" class="btn btn-sm btn-outline-primary ">დამატება</a>
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

@push('js')
    <script src="{{route('shuttle.assets','js/vendor/query-builder.standalone.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/interact.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/ace/ace.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/ace/ext-language_tools.js')}}"></script>
    <style type="text/css" media="screen">
        .editor {
            margin: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 500px;
        }
    </style>
    <script>
        @if($query_builder->count())
        var filters = @json($query_builder ?? []);
        @foreach($type->sections as $section)
        $('#builder{{$loop->index}}').queryBuilder({
            filters: filters,
            plugins: [
                'sortable',
            ],
            @if(isset($section->model['rules'])) rules: {!! $section->model['rules'] !!}, @endif
        });
        @endforeach
        @endif
        $('pre.editor').each(function(){
            var id = $(this).attr('id');
            var editor = ace.edit(id);
            editor.setTheme("ace/theme/twilight");
            editor.setFontSize(13);
            editor.session.setMode("ace/mode/php_laravel_blade");
            editor.setOptions({
                enableBasicAutocompletion: true
            });
            var textarea = $('textarea#'+id).hide();
            editor.getSession().setValue(textarea.val());
            editor.getSession().on('change', function(){
                textarea.val(editor.getSession().getValue());
            });
        });
        $('form.update-section').on('submit',function () {
            $(this).append('<textarea name="model[rules]">'+JSON.stringify($('#builder'+$(this).index()).queryBuilder('getRules'))+'</textarea>');
        })
    </script>
@endpush
