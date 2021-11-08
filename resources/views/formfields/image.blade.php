{{--@if(isset($dataTypeContent->{$row->field}))--}}
{{--    <div data-field-name="{{ $row->field }}">--}}
{{--        <a href="#" class="voyager-x remove-single-image" style="position:absolute;"></a>--}}
{{--        <img src="@if( !filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL)){{ Storage::url( $dataTypeContent->{$row->field} ) }}@else{{ $dataTypeContent->{$row->field} }}@endif"--}}
{{--          data-file-name="{{ $dataTypeContent->{$row->field} }}" data-id="{{ $dataTypeContent->getKey() }}"--}}
{{--          style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">--}}
{{--    </div>--}}
{{--@endif--}}
{{--<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file" name="{{ $row->field }}" accept="image/*">--}}

<div class="select-from-library-container">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="select-from-library-button sfl-single mb-5" data-library-id="#libraryModal"
                 data-count="1" data-name="{{ $row->field }}"
                 @if(isset($dataTypeContent->{$row->field}))
                 data-preview-path="{{ Storage::url( $dataTypeContent->{$row->field} ) }}"
                 data-path="{{ $dataTypeContent->{$row->field} }}"
                 @endif>
                <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                    Select an item from library
                </div>
            </div>
        </div>
    </div>
</div>
