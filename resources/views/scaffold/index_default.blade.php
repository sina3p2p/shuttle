@push('css-vendors2')
<link rel="stylesheet" href="{{route('shuttle.assets', 'css/vendor/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{route('shuttle.assets', 'css/vendor/datatables.responsive.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.0.2/css/searchPanes.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />

@endpush

<scaffold-interface-filter-modal></scaffold-interface-filter-modal>


            <scaffold-interface-table 
                url="{{ route('shuttle.scaffold_interface.datatable', $scaffoldInterface) }}"
                delete-route="{{route('shuttle.scaffold_interface.destroy',['scaffold_interface' => $scaffoldInterface, 'id' => '__id'])}}"
                :columns="{{ json_encode($columns) }}"></scaffold-interface-table>
 

{{-- @push('js')
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/searchpanes/2.0.2/js/dataTables.searchPanes.min.js"></script>
<script src="//cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
@endpush --}}