@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/select2-bootstrap.min.css')}}" />
@endpush

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-3">

                <div class="pageTitle">
                    <div class="pageTitle-title"><h1>{{$page_component->component->display_name}}</h1></div>
                    <div class="pageTitle-down">
                        <ul>
                            <li class="breadcrumb-item">
                                <a href="#">მთავარი</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('shuttle.page.edit',['page' => $page_component->page, 'lang' => $page_component->locale])}}">კომპონენტები</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$page_component->component->display_name}}</li>
                          </ul>
                        
                    </div>
                </div>

                

              
               

            </div>

            <div class="separator mb-5"></div>
        </div>
    </div>

@stop

@section('main')
    @php $c_setting = (object) $page_component->setting ?? []; @endphp
    <x-shuttle-form 
        :scaffold-interface-rows="$page_component->component->rows" 
        :data-type-content="$c_setting"
    />
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

        // $('textarea.richTextBox').each(function() {
        //     CKEDITOR.replace($(this).attr("id"), {
        //         height: 500,
        //         extraPlugins: 'justify,font',
        //         filebrowserUploadUrl: "{{route('shuttle.media.upload',['_token' => csrf_token()])}}",
        //         filebrowserUploadMethod: 'form',
        //         htmlEncodeOutput: true,
        //     });
        // });

        $(document).ready(function() {
            const moveElementToEndOfParent = function(element) {
                var parent = element.parent();
                element.detach();
                parent.append(element);
            };

            $("ul.select2-selection__rendered").sortable({
                containment: 'parent',
                stop: function(event, ui) {
                    var $select = $(event.target).parents('span.select2-container').prev('select');
                    $(event.target).children("li[title]").each(function(i, obj){
                        var element = $select.children('option').filter(function () { return $(this).html() == obj.title });
                        console.log(element)
                        moveElementToEndOfParent(element)
                    });
                }
            });
        });
    </script>
@endpush
