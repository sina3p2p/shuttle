<form action="{{ $action }}" method="POST" class="scaffold-form" enctype="multipart/form-data">
    @csrf
    @if($edit)
    @method('PUT')
    @endif
    {{-- @php
    $dataTypeRows = $scaffoldInterface->{($edit ? 'editRows' : 'addRows' )};
    @endphp --}}
    @isset($slot)
    {{ $slot }}
    @endisset
    <div class="form-row">
        @foreach($scaffoldInterfaceRows as $row)
        @isset(${$row->field})
        {{ ${$row->field} }}
        @else
        @php
        $display_options = $row->details->display ?? NULL;
        // if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
        // $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
        // }
        @endphp
        @if (isset($row->details->legend) && isset($row->details->legend->text))
        <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{
            $row->details->legend->text }}</legend>
        @endif

        <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
            {{ $row->slugify }}
            @if ($row->type !== 'array')
            <label class="control-label" for="name">{{ $row->display_name }}</label>
            @endif
            {{-- @include('voyager::multilingual.input-hidden-bread-edit-add')--}}
            @if (isset($row->details->view))
            {{-- @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' =>
            $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view'
            => ($edit ? 'edit' : 'add'), 'options' => $row->details])--}}
            @elseif ($row->type == 'relationship')
            @include('shuttle::formfields.relationship', ['options' => $row->details])
            @elseif ($row->type == 'c_relationship')
            @include('shuttle::formfields.c_relationship', ['options' => $row->details])
            @elseif ($row->type == 'array')
            @include('shuttle::formfields.array')
            @else
            {!! app('shuttle')->formField($row, $scaffoldInterface, $dataTypeContent) !!}
            @endif
            @foreach (app('shuttle')->afterFormFields($row, $scaffoldInterface, $dataTypeContent) as $after)
            {!! $after->handle($row, $scaffoldInterface, $dataTypeContent) !!}
            @endforeach
        </div>
        @endisset
        @endforeach
        @isset($footer)
        {{ $footer }}
        @endisset
    </div>
    <button type="submit" class="btn btn-primary save">შენახვა</button>
</form>

<media-library-modal upload-url="{{route('shuttle.media.upload')}}"></media-library-modal>

@push('css-vendors')
<!-- <link rel="stylesheet" href="{{route('shuttle.assets', 'css/vendor/dropzone.min.css')}}" /> -->
<link rel="stylesheet" href="{{route('shuttle.assets', 'css/vendor/select2.min.css')}}" />
<link rel="stylesheet" href="{{route('shuttle.assets', 'css/vendor/select2-bootstrap.min.css')}}" />
@endpush

@push('js')
<!-- <script src="{{route('shuttle.assets','js/vendor/dropzone.min.js')}}"></script> -->
<script src="{{route('shuttle.assets','js/vendor/select2.full.js')}}"></script>
<!-- <script src="{{route('shuttle.assets','js/plugins/select.from.library.js')}}"></script> -->
<script src="{{route('shuttle.assets','js/vendor/slugify.js')}}"></script>
<script src="{{route('shuttle.assets','js/vendor/jquery-ui.min.js')}}"></script>
<script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script>
    var params = {};
    var $file;

    $('document').ready(function() {

        $('.form-group input[type=date]').each(function(idx, elt) {
            if (elt.hasAttribute('data-datepicker')) {
                elt.type = 'text';
                $(elt).datetimepicker($(elt).data('datepicker'));
            } else if (elt.type != 'date') {
                elt.type = 'text';
                $(elt).datetimepicker({
                    format: 'L',
                    extraFormats: ['YYYY-MM-DD']
                }).datetimepicker($(elt).data('datepicker'));
            }
        });

        $('input[data-slug-origin]').each(function(i, el) {
            $(el).slugify();
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('select.select2').select2({
            width: '100%'
        });
        $('select.select2-ajax').each(function() {
            $(this).select2({
                theme: "bootstrap",
                width: '100%',
                ajax: {
                    url: $(this).data('get-items-route'),
                    data: function(params) {
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

            $(this).on('select2:select', function(e) {
                var data = e.params.data;
                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            $(this).on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
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
        }).on('select2:select', function(e) {
            if (e.params.data.id == '') {
                // "None" was selected. Clear all selected options
                $(this).val([]).trigger('change');
            }
        });

        $(document).on('click', ".add_item", function(e) {
            e.preventDefault();
            let $this = $(this);
            $.get($this.attr('href')).then(res => {
                // let html = $(res)
                // console.log(html);
                // $('#other-chance-ticket-table').append('<tr id="test-id"></tr>')
                const num = $('.cc').length + 1;
                const id = `#${$this.attr('id')}_items${num}`
                $(`<div id="${id}"></div>`).appendTo("#" + $this.attr('id') + "_items")
                var res = Vue.compile(res)
                new Vue({
                    render: res.render,
                    staticRenderFns: res.staticRenderFns
                }).$mount(id)
                // $("#" + $this.attr('id') + "_items").append(res);
                // html.find(".sfl-single").selectFromLibrary();
                // $(".sfl-single").selectFromLibrary()
                // html.find(".richTextBox").each(function() {
                //     CKEDITOR.replace($(this).attr("id"), {
                //         height: 300,
                //         extraPlugins: 'justify,font',
                //         filebrowserUploadUrl: "{{route('shuttle.media.upload',['_token' => csrf_token()])}}",
                //         filebrowserUploadMethod: 'form',
                //     });
                // });
            });
        });

        $(document).on('click', ".remove-array-item", function(e) {
            $(this).parents(".card-body").remove();
        })

        $('.scaffold-form').on('submit', function() {
            $(this).find('button[type=submit]').prop('disabled', true);
        })
    });
</script>
@endpush