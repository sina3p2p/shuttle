@php $time = time() + $loop->index @endphp
<div class="card-body cc">
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-primary mb-3 mt-3 remove-array-item">წაშლა</button>
        </div>
    </div>
@foreach ($row->children as $child)
    @isset(${$child->field})
        {{ ${$child->field} }}
    @else
        @php
            $display_options = $child->details->display ?? NULL;
            $child1 = $child->replicate();
            $value->{$row->field.'['.$time.']['.$child->field.']'} = $value->{$child->field} ?? '';
            $child1->field = $row->field.'['.$time.']['.$child->field.']';
        @endphp
        @if (isset($child->details->legend) && isset($child->details->legend->text))
            <legend class="text-{{ $child->details->legend->align ?? 'center' }}" style="background-color: {{ $child->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $child->details->legend->text }}</legend>
        @endif
        <div class="form-group @if($child->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($child->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
            {{ $row->slugify }}
            <label class="control-label" for="name">{{ $child->display_name }}</label>
            {{--                                    @include('voyager::multilingual.input-hidden-bread-edit-add')--}}
            @if (isset($child->details->view))
                {{--                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])--}}
            @elseif ($child->type == 'array')
                @include('shuttle::formfields.array')
            @else
                {!! app('shuttle')->formField($child1, $scaffoldInterface, $value) !!}
            @endif
        </div>
    @endisset
@endforeach
</div>