{{--<br>--}}
{{--@if(isset($dataTypeContent->{$row->field}))--}}
{{--    <?php $images = json_decode($dataTypeContent->{$row->field}); ?>--}}
{{--    @if($images != null)--}}
{{--        @foreach($images as $image)--}}
{{--            <div class="img_settings_container" data-field-name="{{ $row->field }}" style="float:left;padding-right:15px;">--}}
{{--                <a href="#" class="voyager-x remove-multi-image" style="position: absolute;"></a>--}}
{{--                <img src="{{ Voyager::image( $image ) }}" data-file-name="{{ $image }}" data-id="{{ $dataTypeContent->getKey() }}" style="max-width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:5px;">--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}
{{--@endif--}}
{{--<div class="clearfix"></div>--}}
{{--<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif type="file" name="{{ $row->field }}[]" multiple="multiple" accept="image/*">--}}
@php $value = (is_array($dataTypeContent->{$row->field})) ? $dataTypeContent->{$row->field} : json_decode($dataTypeContent->{$row->field},true) ?? []; @endphp

<div class="select-from-library-container mb-1 sfl2-multiple">
    <div class="row sortable" id='thumb-image-upload'>
        @foreach ($value as $image)
            <div class="col-sm-12 col-md-6 col-xl-4 sfl2-multiple-item">
                <div class="selected-library-item sfl-selected-item mb-3 sfl-selected-item-active" style="display: block">
                    <div class="card d-flex flex-row media-thumb-container">
                        <a class="d-flex align-self-center">
                            <img src="{{Storage::url($image)}}" alt="uploaded image" class="list-media-thumbnail responsive border-0 sfl-selected-item-image" />
                            <input name="{{$row->field}}[]" class="sfl-input-item" value="{{$image}}" hidden></a>
                        <div class="d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column justify-content-between min-width-zero align-items-lg-center">
                                <a class="w-100"><p class="list-item-heading mb-1 truncate sfl-selected-item-label">{{$image}}</p></a>
                            </div>
                            <div class="pl-1 align-self-center">
                                <a href="#" class="btn-link delete-library-item sfl-delete-item-by-dropzone"><i class="simple-icon-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="dropzone mb-3" data-name='{{$row->field}}' data-url="{{route('shuttle.media.upload')}}" data-uploader=".sfl2-multiple"></div>
@push('js')
    <script>
        $(document).on('click','.sfl-delete-item-by-dropzone',function (e) {
            e.preventDefault();
            $(this).parents('.sfl2-multiple-item').remove();
        })
    </script>
@endpush
