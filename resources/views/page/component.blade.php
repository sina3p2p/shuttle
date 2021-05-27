@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/select2-bootstrap.min.css')}}" />
@endpush

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <h1>კომპონენტები</h1>
                <div class="float-sm-right text-zero">
                    <form id="saveComponent" action="" method="post">
                        @csrf
                        <button id="saveComponentButton" type="button" class="btn btn-primary btn-lg mr-1">შენახვა</button>
                    </form>
                </div>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="#">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.page.edit',['page' => $page_component->page, 'lang' => $page_component->locale])}}">კომპონენტები</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{$page_component->component->display_name}}</li>
                    </ol>
                </nav>

            </div>

            <div class="separator mb-5"></div>
        </div>
    </div>

@stop

@section('main')
    @php $c_setting = $page_component->setting ?? [] @endphp
    <form id="data" data-component="{{$page_component->component->name}}">
        @foreach($page_component->component->settings as $setting)
            @switch($setting['type'])
                @case('array')
                <div class="form-group" id="{{$setting['key']}}">
                    <button class="btn btn-primary add-to-array" style="margin-bottom:30px" data-json='@json($setting)'>დამატება</button>
                    @include('shuttle::page.includes.array-component', ['mySetting' => $setting, 'settings' => data_get($setting,'objects'),'items' => data_get($c_setting,$setting['key'],[])])
                </div>
                @break
                @case('image')
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">{{data_get($setting,'value')}}</label>
                    <div class="col-sm-10">
                        <div class="select-from-library-container">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-4">
                                    <div class="select-from-library-button sfl-single mb-5" data-library-id="#libraryModal"
                                         data-count="1" data-name="{{$setting['key']}}"
                                         @if(data_get($c_setting,$setting['key']))
                                         data-preview-path="{{ Storage::url(data_get($c_setting,$setting['key'])) }}"
                                         data-path="{{data_get($c_setting,$setting['key'])}}"
                                        @endif>
                                        <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                                            Select an item from library
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @break
                @case('html')
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>{{data_get($setting,'value')}}</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="richTextBox" id="{{$setting['key']}}" name="{{$setting['key']}}">{{data_get($c_setting,$setting['key'])}}</textarea>
                    </div>
                </div>
                @break
                @case('map')
                @include('shuttle::page.includes.map-component', ['mySetting' => $setting,'items' => $c_setting])
                @break
                @case('model')
                @case('arrayModel')
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>{{data_get($setting,'value')}}</label>
                    </div>
                    <div class="col-md-10">
                        <select
                            @if($setting['type'] == 'arrayModel')
                            multiple name="{{$setting['key']}}[]" class="form-control select2-single"
                            @else
                            name="{{$setting['key']}}" class="form-control select2-multiple"
                            @endif
                            {{--                        data-get-items-route="{{route('admin.scaffold_interface.relationship',$scaffold_interface)}}"--}}
                            data-get-items-field="{{$setting['options']['label']}}"
                            {{--                        @if(!is_null(data_get($c_setting,$setting['key']))) data-id="{{data_get($c_setting,$setting['key'])}}" @endif--}}
                            data-method="add">
                            @php
                                $model = app($page_component->component->model);
                                //$query = $model::where($setting['options']['key'], old($setting['key'], data_get($c_setting,$setting['key'])))->get();
                                $query = $model::all();
                            @endphp

                            <option value="">-- None --</option>

                            @foreach($query as $relationshipData)
                                <option value="{{ $relationshipData->{$setting['options']['key']} }}" @if(old($setting['key'], data_get($c_setting,$setting['key'])) == $relationshipData->{$setting['options']['key']} || in_array($relationshipData->{$setting['options']['key']}, is_array(data_get($c_setting,$setting['key'])) ? data_get($c_setting,$setting['key']) : [])) selected="selected" @endif>{{ $relationshipData->{$setting['options']['label']} }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @break
                @default
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="{{$setting['key']}}__{{$loop->index}}">{{data_get($setting,'value')}}</label>
                    <div class="col-sm-10">
                        <input id="{{$setting['key']}}__{{$loop->index}}" class="form-control" name="{{$setting['key']}}" value="{{data_get($c_setting,$setting['key'])}}">
                    </div>
                </div>
            @endswitch
        @endforeach
    </form>
@stop

@push('js-vendor')
    <script src="{{route('shuttle.assets','js/vendor/dropzone.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/jquery.serializejson.js')}}"></script>
    <script src="{{route('shuttle.assets','js/plugins/select.from.library.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/select2.full.js')}}"></script>
@endpush

@push('js')
    <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
    <script>
        $('.add-to-array').on('click',function (e) {
            e.preventDefault();
            var data = $(this).data('json');
            var index = $("."+data.key).length;
            var html = '<div class="card mb-4 ' + data.key + '">\n' +
                '<div class="card-body">\n' +
                ' <div class="w-100 d-flex justify-content-between align-items-center mb-4">\n' +
                '<h5 class="mb-4">სიახლე - '+ index +'</h5>\n' +
                '<button class="btn btn-primary remove-item">წაშლა</button>\n' +
                '</div>';
            var hasImage = false;
            var hasHtml = false;
            for (let i in data.objects){
                switch (data.objects[i]['type']) {
                    case 'array':
                        break;
                    case 'image':
                        hasImage = true;
                        html += '<div class="form-group row mb-3">\n' +
                            '<label class="col-sm-2 col-form-label">'+data.objects[i]['value']+'</label>\n' +
                            '                    <div class="col-sm-10">\n' +
                            '                        <div class="select-from-library-container">\n' +
                            '                            <div class="row">\n' +
                            '                                <div class="col-sm-12 col-md-6 col-xl-4">\n' +
                            '                                    <div class="select-from-library-button sfl-single mb-5" data-library-id="#libraryModal"\n' +
                            '                                         data-count="1" data-name="'+data.key+'['+index+']['+data.objects[i]['key']+']"\n' +
                            '                                        <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">\n' +
                            '                                            Select an item from library\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>\n';
                        break;
                    case 'html':
                        hasHtml = true;
                        html += '<div class="form-group row">\n' +
                            '<div class="col-md-2">\n' +
                            '<span>'+data.objects[i]['value']+'</span>\n' +
                            '</div>\n' +
                            '<div class="col-md-10">\n' +
                            '<textarea class="richTextBox" id="richTextBox'+index+'" name="'+data.key+'['+index+']['+data.objects[i]['key']+'"></textarea>\n' +
                            '</div></div>';
                        break;
                    default:
                        html += '<div class="form-group row">\n' +
                            '                    <label class="col-sm-2 col-form-label">'+data.objects[i]['value']+'</label>\n' +
                            '                    <div class="col-sm-10">\n' +
                            '                        <input class="form-control" name="'+data.key+'['+index+']['+data.objects[i]['key']+']">\n' +
                            '                    </div>\n' +
                            '                </div>';
                }
            }

            html += '</div>\n' +
                '</div>';
            html = $(html);
            $(this).parent().append(html);

            if(hasImage){
                html.find(".sfl-single").selectFromLibrary();
            }

            if(hasHtml){
                html.find(".richTextBox").each(function() {
                    CKEDITOR.replace($(this).attr("id"), {
                        height: 500,
                        extraPlugins: 'justify,font',
                        filebrowserUploadUrl: "{{route('shuttle.media.upload',['_token' => csrf_token()])}}",
                        filebrowserUploadMethod: 'form',
                    });
                });
            }

        });

        $("#saveComponentButton").on('click',function (e) {
            e.preventDefault();
            for(var instanceName in CKEDITOR.instances)
                CKEDITOR.instances[instanceName].updateElement();
            var form = $('form#data');
            var data = form.serializeJSON();
            $(this).append('<textarea name="json" hidden>'+JSON.stringify(data)+'</textarea>');
            $("#saveComponent").submit();
        });

        $(document).on('click', '.remove-item',function (e) {
            e.preventDefault();
            $(this).parents('.card').remove();
        });

        $('textarea.richTextBox').each(function() {
            CKEDITOR.replace($(this).attr("id"), {
                height: 500,
                extraPlugins: 'justify,font',
                filebrowserUploadUrl: "{{route('shuttle.media.upload',['_token' => csrf_token()])}}",
                filebrowserUploadMethod: 'form',
                htmlEncodeOutput: true,
            });
        });

    </script>
@endpush
