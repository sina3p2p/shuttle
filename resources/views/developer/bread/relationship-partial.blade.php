@php
    $relationshipDetails = json_decode($relationship['details']);//$relationship['details'];
    $relationshipKeyArray = array_fill_keys(["model", "table", "type", "column", "key", "label", "pivot_table", "pivot", "taggable"], '');

    $adv_details = array_diff_key(json_decode($relationship['details'], true), $relationshipKeyArray);
@endphp
{{--<div class="row row-dd row-dd-relationship">--}}
{{--    <div class="form">--}}

{{--        <input type="text" name="field_display_name_{{ $relationship['field'] }}" class="form-control relationship_display_name" value="{{ $relationship['display_name'] }}">--}}
{{--    </div>--}}
{{--    <div class="col-md-12">--}}
        <label class="form-group has-float-label">
            <input name="field_display_name_{{ $relationship['field'] }}" class="form-control relationship_display_name relation-input" value="{{ $relationship['display_name'] }}">
            <span>E-mail</span>
        </label>
{{--        <a href="" class="delete_relationship"><i class="voyager-trash"></i> {{ __('voyager::database.relationship.delete') }}</a>--}}
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</label>
            <div class="col-5">
                <select id="inputState" class="form-control" name="type">
                    <option value="hasOne" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'hasOne') selected @endif>Has One</option>
                    <option value="hasMany" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'hasMany') selected @endif>Has Many</option>
                    <option value="belongsTo" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'belongsTo') selected @endif>Belongs To</option>
                    <option value="belongsToMany" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'belongsToMany') selected @endif>Belongs To Many</option>
                </select>
            </div>
            <div class="col-5">
                <select id="inputState" class="form-control">
                    @foreach(getModels() as $tablename)
                        <option value="{{ $tablename }}" @if(isset($relationshipDetails->model) && $relationshipDetails->model == $tablename) selected @endif>{{ $tablename }}</option>
                    @endforeach
                </select>
            </div>
        </div>

{{--        <div class="row">--}}
{{--            <p class="col-2">{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</p>--}}
{{--            <select class="relationship_type form-control col-5" name="relationship_type_{{ $relationship['field'] }}">--}}
{{--                <option value="hasOne" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'hasOne') selected @endif>Has One</option>--}}
{{--                <option value="hasMany" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'hasMany') selected @endif>Has Many</option>--}}
{{--                <option value="belongsTo" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'belongsTo') selected @endif>Belongs To</option>--}}
{{--                <option value="belongsToMany" @if(isset($relationshipDetails->type) && $relationshipDetails->type == 'belongsToMany') selected @endif>Belongs To Many</option>--}}
{{--            </select>--}}
{{--            <select class="relationship_table col-5 form-control" name="relationship_model_{{ $relationship['field'] }}">--}}
{{--                @foreach(getModels() as $tablename)--}}
{{--                    <option value="{{ $tablename }}" @if(isset($relationshipDetails->model) && $relationshipDetails->model == $tablename) selected @endif>{{ $tablename }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

            <div class="relationshipField">
                <div class="relationship_details_content margin_top belongsTo @if($relationshipDetails->type == 'belongsTo') flexed @endif">
                    <label>Witch column use from <span>{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</span> to make reference on <span class="label_table_name"></span>?</label>
                    <select name="relationship_column_belongs_to_{{ $relationship['field'] }}" class="new_relationship_field form-control">
                        @foreach($fieldOptions as $data)
                            <option value="{{ $data['field'] }}" @if($relationshipDetails->column == $data['field']) selected="selected" @endif>{{ $data['field'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="relationship_details_content margin_top hasOneMany @if($relationshipDetails->type == 'hasOne' || $relationshipDetails->type == 'hasMany') flexed @endif">
                    <label>Witch column use from <span class="label_table_name"></span>  to make reference on <span>{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</span>?</label>
                    <select name="relationship_column_{{ $relationship['field'] }}" class="new_relationship_field select2 rowDrop form-control" data-table="{{ $relationshipDetails->table ?? '' }}" data-selected="{{ $relationshipDetails->column }}">
                        <option value="{{ $relationshipDetails->key ?? '' }}">{{ $relationshipDetails->key ?? '' }}</option>
                    </select>
                </div>
            </div>
            <div class="relationshipPivot" @if($relationshipDetails->type != 'belongsToMany') style="display: none;" @endif>
                <label>{{ __('voyager::database.relationship.pivot_table') }}:</label>
                <select name="relationship_pivot_table_{{ $relationship['field'] }}" class="form-control">
                    @foreach($tables as $tbl)
                        <option value="{{ $tbl }}" @if(isset($relationshipDetails->pivot_table) && $relationshipDetails->pivot_table == $tbl) selected="selected" @endif>{{ \Illuminate\Support\Str::singular(ucfirst($tbl)) }}</option>
                    @endforeach
                </select>
            </div>

            <label> Use witch column for display in relation? <span class="label_table_name"></span></label>
            <select name="relationship_label_{{ $relationship['field'] }}" class="rowDrop select2 form-control" data-table="{{ $relationshipDetails->table ?? '' }}" data-selected="{{ $relationshipDetails->label ?? ''}}">
                <option value="{{ $relationshipDetails->label ?? '' }}">{{ $relationshipDetails->label ?? '' }}</option>
            </select>
            <label class="relationship_key" style="@if($relationshipDetails->type == 'belongsTo' || $relationshipDetails->type == 'belongsToMany') display:block @endif">Store <span class="label_table_name"></span></label>
            <select name="relationship_key_{{ $relationship['field'] }}" class="rowDrop select2 relationship_key form-control" style="@if($relationshipDetails->type == 'belongsTo' || $relationshipDetails->type == 'belongsToMany') display:block @endif" data-table="@if(isset($relationshipDetails->table)){{ $relationshipDetails->table }}@endif" data-selected="@if(isset($relationshipDetails->key)){{ $relationshipDetails->key }}@endif">
                <option value="{{ $relationshipDetails->key ?? '' }}">{{ $relationshipDetails->key ?? '' }}</option>
            </select>
            <br>
{{--            @isset($relationshipDetails->taggable)--}}
{{--                <label class="relationship_taggable" style="@if($relationshipDetails->type == 'belongsToMany') display:block @endif">--}}
{{--                    {{__('voyager::database.relationship.allow_tagging')}}--}}
{{--                </label>--}}
{{--                <span class="relationship_taggable" style="@if($relationshipDetails->type == 'belongsToMany') display:block @endif">--}}
{{--                    <input type="checkbox" name="relationship_taggable_{{ $relationship['field'] }}" class="toggleswitch" data-on="{{ __('voyager::generic.yes') }}" data-off="{{ __('voyager::generic.no') }}" {{$relationshipDetails->taggable == 'on' ? 'checked' : ''}}>--}}
{{--                </span>--}}
{{--            @endisset--}}

{{--    </div>--}}
    <input type="hidden" value="0" name="field_required_{{ $relationship['field'] }}" checked="checked">
    <input type="hidden" name="field_input_type_{{ $relationship['field'] }}" value="relationship">
    <input type="hidden" name="field_{{ $relationship['field'] }}" value="{{ $relationship['field'] }}">
    <input type="hidden" name="relationships[]" value="{{ $relationship['field'] }}">
{{--</div>--}}
