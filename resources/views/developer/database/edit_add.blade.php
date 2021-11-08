@extends('shuttle::admin')

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>@if($db->action == 'update'){{$db->table->name}}@else ახალი ბაზები @endif</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.page.index')}}">გვერდები</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">@if($db->action == 'update'){{$db->table->name}} @else ახალი ბაზები @endif</a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="separator mb-5"></div>
        </div>
    </div>
@stop

@section('main')
    <div id="dbManager">
        <form ref="form" @submit.prevent="stringifyTable" @keydown.enter.prevent action="{{ $db->formAction }}" method="POST">
            @if($db->action == 'update')@method('PUT')@endif

            <database-table-editor :table="table"></database-table-editor>

            <input type="hidden" :value="tableJson" name="table">

            @csrf
        </form>
    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    @include('shuttle::developer.database.vue-components.database-table-editor')
    <script>
        new Vue({
            el: '#dbManager',
            data: {
                table: {},
                originalTable: {!! $db->table->toJson() !!}, // to do comparison later?
                oldTable: {!! $db->oldTable !!},
                tableJson: ''
            },
            created() {
                // If old table is set, use it to repopulate the form
                if (this.oldTable) {
                    this.table = this.oldTable;
                } else {
                    this.table = JSON.parse(JSON.stringify(this.originalTable));
                }
            },
            methods: {
                stringifyTable() {
                    this.tableJson = JSON.stringify(this.table);

                    this.$nextTick(() => this.$refs.form.submit());
                }
            }
        });
    </script>
@endpush
