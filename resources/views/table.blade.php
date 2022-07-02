<table id="myTable">

</table>
@php
$columns = [];
foreach($scaffoldInterfaceRows as $row)
{
$columns[] = [

];
}
@endphp
@push('js')
<script>
    $('#myTable').DataTable( {
        serverSide: true,
        ajax: {
            url: '{{ $action }}',
            dataSrc: 'data',
        },
        columns: []
    });
</script>
@endpush