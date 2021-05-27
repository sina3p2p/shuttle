<textarea class="form-control richTextBox" name="{{ $row->field }}" id="richtext{{ $row->field }}">
    {{ old($row->field, $dataTypeContent->{$row->field} ?? '') }}
</textarea>

@push('js')
    <script>
        $(document).ready(function() {
            $('textarea.richTextBox[name="{{ $row->field }}"]').each(function() {
                CKEDITOR.replace($(this).attr("id"), {
                    height: 500,
                    extraPlugins: 'justify,font',
                    basicEntities: false,
                    filebrowserUploadUrl: "{{route('shuttle.media.upload',['_token' => csrf_token()])}}",
                    filebrowserUploadMethod: 'form',
                });
            });
        });
    </script>
@endpush
