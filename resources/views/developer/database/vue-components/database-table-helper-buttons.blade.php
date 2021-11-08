@section('database-table-helper-buttons-template')
    <div>
        <div class="btn btn-success" @click="addNewColumn">+ New Column</div>
        <div class="btn btn-success" @click="addTimestamps">+ Add Timestamps</div>
        <div class="btn btn-success" @click="addSoftDeletes">+ Add Soft Deletes</div>
        <div class="btn btn-success" @click="addTranslations" v-if="isTranslatable && tableName.endsWith('_translations')">+ Add Translations</div>
    </div>
@endsection

<script>
    Vue.component('database-table-helper-buttons', {
        template: `@yield('database-table-helper-buttons-template')`,
        props: ['isTranslatable', 'tableName'],
        methods: {
            addColumn(column) {
                this.$emit('columnAdded', column);
            },
            makeColumn(options) {
                return $.extend({
                    name: '',
                    oldName: '',
                    type: getDbType('integer'),
                    length: null,
                    fixed: false,
                    unsigned: false,
                    autoincrement: false,
                    notnull: false,
                    default: null
                }, options);
            },
            addNewColumn() {
                this.addColumn(this.makeColumn());
            },
            addTimestamps() {
                this.addColumn(this.makeColumn({
                    name: 'created_at',
                    type: getDbType('timestamp')
                }));

                this.addColumn(this.makeColumn({
                    name: 'updated_at',
                    type: getDbType('timestamp')
                }));
            },
            addSoftDeletes() {
                this.addColumn(this.makeColumn({
                    name: 'deleted_at',
                    type: getDbType('timestamp')
                }));
            },
            addTranslations() {
                this.addColumn(this.makeColumn({
                    name: 'locale',
                    type: getDbType('varchar'),
                    length: 4
                }));
                
                this.addColumn(this.makeColumn({
                    name: this.tableName.replace("_translations", "_id"),
                    type: getDbType('integer')
                }));
            }
        }
    });
</script>
