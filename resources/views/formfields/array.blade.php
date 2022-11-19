{{-- <a href="{{route('shuttle.scaffold_interface.array', $row)}}" class="btn btn-secondary add_item"
    id="item_body_{{$row->id}}">ახლის დამატება</a>
<div id="item_body_{{$row->id}}_items">
    @foreach($dataTypeContent->{$row->field} ?? [] as $key => $value)
    @include('shuttle::formfields.array_body', ['row' => $row, 'value' => (object) $value])
    @endforeach
</div> --}}
<array-input :row="{{ json_encode($row) }}" :inputs="{{ json_encode($row->children) }}" name="{{  $row->field }}"
    :value="{{ json_encode(data_get($dataTypeContent, $row->field)) }}"
    add-item-url="{{route('shuttle.scaffold_interface.array', $row)}}">
</array-input>
{{-- <style>
    .cc {
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0px 0px 30px rgba(1, 0, 0, .1);
        width: 100%;
        float: left;
        background: #fff;
        margin-top: 30px;
    }

    .remove-array-item {
        float: right;
        z-index: 300;
        position: relative;
        margin-right: 15px;
    }
</style> --}}