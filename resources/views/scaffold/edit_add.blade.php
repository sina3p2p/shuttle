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
            <div class="card mb-4">
                <div class="card-body">
                    <x-shuttle-form 
                        :action="$dataTypeContent->id ? route('shuttle.scaffold_interface.update', ['scaffold_interface' => $scaffold_interface, 'id' => $dataTypeContent->id, 'lang' => $lang]) : route('shuttle.scaffold_interface.store',$scaffold_interface)"
                        :scaffold-interface-rows="$scaffold_interface->rows" 
                        :data-type-content="$dataTypeContent" 
                        :edit="$edit"
                        />
                </div>
            </div>
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

{{-- @push('js-vendor')
    <script src="{{route('shuttle.assets','js/vendor/dropzone.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/select2.full.js')}}"></script>
    <script src="{{route('shuttle.assets','js/plugins/select.from.library.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/slugify.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/jquery-ui.min.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
    <script>
        var params = {};
        var $file;

        $('document').ready(function () {

            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            $('input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('select.select2').select2({width: '100%'});
            $('select.select2-ajax').each(function() {
                $(this).select2({
                    theme: "bootstrap",
                    width: '100%',
                    ajax: {
                        url: $(this).data('get-items-route'),
                        data: function (params) {
                            var query = {
                                search: params.term,
                                type: $(this).data('get-items-field'),
                                method: $(this).data('method'),
                                id: $(this).data('id'),
                                page: params.page || 1
                            };
                            return query;
                        }
                    }
                });

                $(this).on('select2:select',function(e){
                    var data = e.params.data;
                    if (data.id == '') {
                        // "None" was selected. Clear all selected options
                        $(this).val([]).trigger('change');
                    } else {
                        $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected','selected');
                    }
                });

                $(this).on('select2:unselect',function(e){
                    var data = e.params.data;
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',false);
                });
            });
            $('select.select2-taggable').select2({
                width: '100%',
                tags: true,
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                }
            }).on('select2:selecting', function(e) {
                var $el = $(this);
                var route = $el.data('route');
                var label = $el.data('label');
                var errorMessage = $el.data('error-message');
                var newTag = e.params.args.data.newTag;

                if (!newTag) return;

                $el.select2('close');

                $.post(route, {
                    [label]: e.params.args.data.text,
                    _tagging: true,
                }).done(function(data) {
                    var newOption = new Option(e.params.args.data.text, data.data.id, false, true);
                    $el.append(newOption).trigger('change');
                }).fail(function(error) {
                    toastr.error(errorMessage);
                });

                return false;
            }).on('select2:select', function (e) {
                if (e.params.data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                }
            });
        });
    </script>
@endpush --}}
