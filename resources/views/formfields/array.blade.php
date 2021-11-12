<a href="{{route('shuttle.scaffold_interface.array', $row)}}" class="btn btn-secondary add_item" id="item_body_{{$row->id}}">ახლის დამატება</a>
<div id="item_body_{{$row->id}}_items">
    @foreach($dataTypeContent ?? [] as $key => $value)
        @include('shuttle::formfields.array_body', ['row' => $row, 'value' => (object) $value])
    @endforeach
</div>