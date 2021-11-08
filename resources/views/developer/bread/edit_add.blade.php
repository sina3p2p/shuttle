@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/select2.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/select2-bootstrap.min.css')}}" />
@endpush

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>@if(isset($dataType->id)){{$dataType->display_name_singular}}@else New Bread @endif</h1>
                <div class="float-sm-right text-zero">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#new_relationship_modal">Add Relationship</button>
                </div>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.page.index')}}">გვერდები</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">@if(isset($dataType->id)){{$dataType->display_name_singular}}@else New Bread @endif</a>
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

        <form action="@if(isset($dataType->id)){{ route('shuttle.developer.bread.update', $dataType->id) }}@else{{ route('shuttle.developer.bread.store') }}@endif" method="POST">
            @if(isset($dataType->id))
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
                                    <label for="name">Table Name</label>
                                    <input type="text" class="form-control" readonly name="name" value="{{ $dataType->name ?? $table }}">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="display_name_singular">Display Name (Singular)</label>
                                    <input type="text" class="form-control"
                                           name="display_name_singular"
                                           id="display_name_singular"
                                           placeholder="Display Name (Singular)"
                                           value="{{ $dataType->display_name_singular ?? $display_name }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="display_name_plural">Display Name (Plural)</label>
                                    <input type="text" class="form-control"
                                           name="display_name_plural"
                                           id="display_name_plural"
                                           placeholder="Display Name (Plural)"
                                           value="{{ $dataType->display_name_plural ?? $display_name_plural }}">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="slug">URL Slug (must be unique)</label>
                                    <input type="text" class="form-control" name="slug" placeholder="URL Slug" value="{{ $dataType->slug ?? $slug }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="icon">ICON Class</label>
                                    <input type="text" class="form-control" name="icon" placeholder="ICON Class" value="{{ $dataType->icon ?? 'iconsmind-Bread' }}">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6 form-group">
                                    <label for="model_name">Model Name</label>
                                    <input type="text" class="form-control" name="model" placeholder="Model Name" value="{{ $dataType->model ?? $model_name }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="controller">Controller Name</label>
                                    <input type="text" class="form-control" name="controller" placeholder="Controller Name" value="{{ $dataType->controller ?? '' }}">
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3 form-group">
                                    <label for="order_column">Order Column</label>
                                    <select id="order_column" name="order_column" class="form-control">
                                        <option value="">-- None --</option>
                                        @foreach($fieldOptions as $tbl)
                                            <option value="{{ $tbl['field'] }}"
                                                    @if(isset($dataType) && $dataType->order_column == $tbl['field']) selected @endif
                                            >{{ $tbl['field'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="order_direction">Order Direction</label>
                                    <select id="order_direction" name="order_direction" class="form-control">
                                        <option value="asc" @if(isset($dataType) && $dataType->order_direction == 'asc') selected @endif>
                                            Ascending
                                        </option>
                                        <option value="desc" @if(isset($dataType) && $dataType->order_direction == 'desc') selected @endif>
                                            Descending
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="default_search_key">Default Search key</label>
                                    <select id="default_search_key" name="default_search_key" class="select2 form-control">
                                        <option value="">-- None --</option>
                                        @foreach($fieldOptions as $tbl)
                                            <option value="{{ $tbl['field'] }}"
                                                    @if(isset($dataType) && $dataType->default_search_key == $tbl['field']) selected @endif
                                            >{{ $tbl['field'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="default_search_key">Default Search key</label>
                                    <select id="default_search_key" name="views" class="select2 form-control">
                                        <option value="">Default</option>
                                        <option value="nested" @if($dataType->views == 'nested') selected @endif>Nested</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row clearfix">
                                @if (isset($scopes) && isset($dataType))
                                    <div class="col-md-4 form-group">
                                        <label for="scope">Scope</label>
                                        <select id="scope" name="scope" class="select2 form-control">
                                            <option value="">-- None --</option>
                                            @foreach($scopes as $scope)
                                                <option value="{{ $scope }}" @if($dataType->scope == $scope) selected @endif>{{ $scope }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-4 form-group">
                                    <label for="translated_model">Translation Model</label>
                                    <select id="translated_model" name="translation_model" class="select2 form-control">
                                        <option value="">-- None --</option>
                                        @foreach(getModels() as $tbl)
                                            <option value="{{ $tbl }}" @if(isset($dataType) && $dataType->translation_model == $tbl) selected="selected" @endif>{{ $tbl }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($dataType->model)
                                <div class="col-md-12 form-group">
                                    <label for="translated_attribute">translated attribute</label>
                                    <textarea id="translated_attribute" class="form-control" name="translated_attribute" placeholder="translated attribute">{{ implode(',', app($dataType->model)->translatedAttributes ?? []) }}</textarea>
                                </div>
                                @endif
                                <div class="col-md-4 form-group">
                                    <label for="menuable">Menuable</label>
                                    <input id="menuable" name="menuable" type="checkbox" class="form-control" value="1" @if($dataType->menuable) checked @endif/>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" class="form-control" name="description" placeholder="Short description for your team">{{ $dataType->description }}</textarea>
                                </div>
                            </div>
                        </div><!-- .panel-body -->
                    </div><!-- .panel -->

            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4"><i class="voyager-window-list"></i>{{ $table }} Rows:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fields</th>
                                    <th scope="col">Visibility</th>
                                    <th scope="col">Input type</th>
                                    <th scope="col">Display Name</th>
                                    <th scope="col" width="30%">Optional Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fieldOptions as $data)
{{--                                        @if(isset($dataType->id))--}}
{{--                                            <?php $dataRow = $dataType->rows->where('field', '=', $data['field'])->first(); ?>--}}
{{--                                        @endif--}}
                                    <tr>
                                        <td class="align-middle">
                                            <input name="rows[{{ $data['field'] }}][ord]" value="{{$loop->iteration}}" readonly style="border: none;max-width: 20px">
                                        </td>
                                        <td class="align-middle">
                                            <h3><strong>{{ $data['field'] }}</strong></h3>
                                            <strong>Type in database:</strong> <span>{{ $data['type'] }}</span><br/>
                                            <strong>Required:</strong>
                                            @if($data['null'] == "NO")
                                                <span>YES</span>
                                                <input type="hidden" value="1" name="rows[{{ $data['field'] }}][required]" checked="checked">
                                            @else
                                                <span>NO</span>
                                                <input type="hidden" value="0" name="rows[{{ $data['field'] }}][required]">
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <input type='hidden' value='0' name="rows[{{ $data['field'] }}][browse]">
                                            <input type='hidden' value='0' name="rows[{{ $data['field'] }}][read]">
                                            <input type='hidden' value='0' name="rows[{{ $data['field'] }}][edit]">
                                            <input type='hidden' value='0' name="rows[{{ $data['field'] }}][add]">
                                            <input type='hidden' value='0' name="rows[{{ $data['field'] }}][delete]">
                                            <input type="checkbox"
                                                   id="field_browse_{{ $data['field'] }}"
                                                   name="rows[{{ $data['field'] }}][browse]"
                                                   @if(isset($data->browse) && $data->browse)
                                                   checked="checked"
                                                   @endif value="1">
                                            <label for="field_browse_{{ $data['field'] }}">Browse</label><br/>
                                            <input type="checkbox"
                                                   id="field_read_{{ $data['field'] }}"
                                                   name="rows[{{ $data['field'] }}][read]" @if(isset($data->read) && $data->read) checked="checked" @endif value="1">
                                            <label for="field_read_{{ $data['field'] }}">Read</label><br/>
                                            <input type="checkbox"
                                                   id="field_edit_{{ $data['field'] }}"
                                                   name="rows[{{ $data['field'] }}][edit]" @if(isset($data->edit) && $data->edit) checked="checked" @endif  value="1">
                                            <label for="field_edit_{{ $data['field'] }}">Edit</label><br/>
                                            <input type="checkbox"
                                                   id="field_add_{{ $data['field'] }}"
                                                   name="rows[{{ $data['field'] }}][add]" @if(isset($data->add) && $data->add) checked="checked" @endif  value="1">
                                            <label for="field_add_{{ $data['field'] }}">Add</label><br/>
                                        </td>
                                        <td class="align-middle">
                                            <input type="hidden" name="rows[{{ $data['field'] }}][field]" value="{{ $data['field'] }}">
                                            @if($data['type'] == 'timestamp')
                                                <p>Timestamp</p>
                                                <input type="hidden" value="timestamp"
                                                       name="rows[{{ $data['field'] }}][type]">
                                            @elseif($data['type'] == 'relationship')
                                                <p>Relationship</p>
                                                <input type="hidden" value="relationship"
                                                       name="rows[{{ $data['field'] }}][type]">
                                            @else
                                                <select class="form-control" name="rows[{{ $data['field'] }}][type]">
                                                    @foreach (\Sina\Shuttle\Facades\Shuttle::formFields() as $formField)
                                                        @php
                                                            $selected = (isset($data->type) && $formField->getCodename() == $data->type) || (!isset($data->type) && $formField->getCodename() == 'text');
                                                        @endphp
                                                        <option value="{{ $formField->getCodename() }}" {{ $selected ? 'selected' : '' }}>
                                                            {{ $formField->getName() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <input type="text" class="form-control"
                                                   value="{{ $data->display_name ?? ucwords(str_replace('_', ' ', $data['field'])) }}"
                                                   name="rows[{{ $data['field'] }}][display_name]">
                                        </td>
                                        <td class="align-middle">
                                            <div class="alert alert-danger validation-error">
                                                Invalid JSON
                                            </div>
                                            <textarea id="json-input-{{ json_encode($data['field']) }}"
                                                      class="resizable-editor"
                                                      data-editor="json"
                                                      name="rows[{{ $data['field'] }}][details]">
                                                {{isset($data['details']) ? json_encode($data['details']) : '{}'}}
                                            </textarea>
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
    @include('shuttle::developer.bread.relationship-new-modal')
@stop

@push('js-vendor')
    <script src="{{route('shuttle.assets','js/admin/vendor/select2.full.js')}}"></script>
@endpush

@push('js')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/jquery-ui.min.css')}}">
    <script type="text/javascript" src="{{route('shuttle.assets','js/vendor/jquery-ui.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/ace/ace.js')}}"></script>
    <script>
        ace.config.set('basePath', 'path');
        window.invalidEditors = [];
        var validationAlerts = $('.validation-error');
        validationAlerts.hide();

        $('textarea[data-editor]').each(function () {
            var textarea = $(this),
                mode = textarea.data('editor'),
                editDiv = $('<div>').insertBefore(textarea),
                editor = ace.edit(editDiv[0]),
                _session = editor.getSession(),
                valid = false;
            textarea.hide();

            // Validate JSON
            _session.on("changeAnnotation", function(){
                valid = _session.getAnnotations().length ? false : true;
                if (!valid) {
                    if (window.invalidEditors.indexOf(textarea.attr('id')) < 0) {
                        window.invalidEditors.push(textarea.attr('id'));
                    }
                } else {
                    for(var i = window.invalidEditors.length - 1; i >= 0; i--) {
                        if(window.invalidEditors[i] == textarea.attr('id')) {
                            window.invalidEditors.splice(i, 1);
                        }
                    }
                }
            });

            // Use workers only when needed
            editor.on('focus', function () {
                _session.setUseWorker(true);
            });
            editor.on('blur', function () {
                if (valid) {
                    textarea.siblings('.validation-error').hide();
                    _session.setUseWorker(false);
                } else {
                    textarea.siblings('.validation-error').show();
                }
            });

            _session.setUseWorker(false);

            editor.setAutoScrollEditorIntoView(true);
            editor.$blockScrolling = Infinity;
            editor.setOption("maxLines", 30);
            editor.setOption("minLines", 4);
            editor.setOption("showLineNumbers", false);
            editor.setTheme("ace/theme/github");
            _session.setMode("ace/mode/json");
            if (textarea.val()) {
                _session.setValue(JSON.stringify(JSON.parse(textarea.val()), null, 4));
            }

            _session.setMode("ace/mode/" + mode);

            // copy back to textarea on form submit...
            textarea.closest('form').on('submit', function (ev) {
                if (window.invalidEditors.length) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    validationAlerts.hide();
                    for (var i = window.invalidEditors.length - 1; i >= 0; i--) {
                        $('#'+window.invalidEditors[i]).siblings('.validation-error').show();
                    }
                    toastr.error('{{ __('voyager::json.invalid_message') }}', '{{ __('voyager::json.validation_errors') }}', {"preventDuplicates": true, "preventOpenDuplicates": true});
                } else {
                    if (_session.getValue()) {
                        // uglify JSON object and update textarea for submit purposes
                        textarea.val(JSON.stringify(JSON.parse(_session.getValue())));
                    }else{
                        textarea.val('');
                    }
                }
            });
        });



        $('table tbody').sortable({
            // handle: '.handler',
            update: function( event, ui ) {
                $(this).children().each(function(index) {
                    $(this).find('td:first input').val(index + 1)
                });
            }
        });


        $(":checkbox").change(function(){
            $(this).val($(this).is(":checked") ? 1 : 0);
        });
    </script>
@endpush
