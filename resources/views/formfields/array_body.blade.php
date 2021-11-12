@php $time = time() @endphp
<div class="card-body cc">
    <button type="button" class="btn btn-primary mb-3 mt-3 remove-array-item">წაშლა</button>
@foreach ($row->children as $child)
    @isset(${$child->field})
        {{ ${$child->field} }}
    @else
        @php
            $display_options = $child->details->display ?? NULL;
            $child->field = $row->field.'['.$time.']['.$child->field.']'
        @endphp
        @if (isset($child->details->legend) && isset($child->details->legend->text))
            <legend class="text-{{ $child->details->legend->align ?? 'center' }}" style="background-color: {{ $child->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $child->details->legend->text }}</legend>
        @endif

        <div class="form-group @if($child->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($child->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
            {{ $row->slugify }}
            <label class="control-label" for="name">{{ $row->display_name }}</label>
            {{--                                    @include('voyager::multilingual.input-hidden-bread-edit-add')--}}
            @if (isset($child->details->view))
                {{--                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])--}}
            @elseif ($child->type == 'array')
                @include('shuttle::formfields.array')
            @else
                {!! app('shuttle')->formField($child, $scaffoldInterface, $value) !!}
            @endif
        </div>
    @endisset
@endforeach

    <style>
        .cc {
            padding:30px;
            border-radius:20px;
            box-shadow:0px 0px 30px rgba(1,0,0,.1);
            width:100%;
            float:left;
            background:#fff;
            margin-top:30px;
        }

        .remove-array-item {
            float:right;
            z-index:300;
            position: relative;
            margin-right:15px;
        }
    </style>