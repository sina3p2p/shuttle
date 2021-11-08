<div class="modal fade bd-example-modal-lg" id="new_relationship_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new relation to {{ \Illuminate\Support\Str::singular(ucfirst($table)) }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @if(isset($dataType->id))
            <form action="{{ route('shuttle.developer.bread.relationship',$dataType) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="input-model-name">Model</label>
                            <input class="form-control" id="input-model-name" placeholder="Email" value="{{ \Illuminate\Support\Str::singular(ucfirst($table)) }}" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="input-related-type">Relation Type</label>
                            <select id="input-related-type" class="form-control" name="relationship_type">
                                <option value="hasOne">Has One</option>
                                <option value="hasMany">Has Many</option>
                                <option value="belongsTo">Belong To</option>
                                <option value="belongsToMany">Belong To Many</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="input-related-model">Related Model</label>
                            <select id="input-related-model" class="form-control" name="relationship_table">
                                <option>---</option>
                                @foreach($tables as $tbl)
                                <option value="{{ $tbl }}" @if(isset($relationshipDetails->table) && $relationshipDetails->table == $tbl) selected="selected" @endif>{{ \Illuminate\Support\Str::singular(ucfirst($tbl)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 relationshipField">
                            <label for="col-ref">Which column from {{ \Illuminate\Support\Str::singular(ucfirst($table)) }} is used to reference <span class="label_table_name">---</span>?</label>
                            <select id="col-ref" name="relationship_column_belongs_to" class="new_relationship_field form-control">
                                @foreach($fieldOptions as $data)
                                    <option value="{{ $data['field'] }}">{{ $data['field'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 relationshipField">
                            <div class="hasOneMany flexed">
                                <label for="rel-ref">Which column from <span class="label_table_name">---</span> is used to reference {{ \Illuminate\Support\Str::singular(ucfirst($table)) }}?</label>
                                <select name="relationship_column" class="form-control" data-table="{{ $tables[0] }}" id="rel-ref" data-selected="">
                                    <option>---</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input-label">Label Column</label>
                            <select id="input-label" class="form-control" name="relationship_label">
                                <option>---</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input-key">Store Key</label>
                            <select id="input-key" class="form-control" name="relationship_key">
                                <option>---</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 relationshipPivot">
                            <label for="input-pivot-table">Pivot Table:</label>
                            <select id="input-pivot-table" name="relationship_pivot" class="form-control">
                                @foreach($tables as $tbl)
                                    <option value="{{ $tbl }}">{{ \Illuminate\Support\Str::singular(ucfirst($tbl)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Relation</button>
                </div>
            </form>
            @else
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            Please Save bread after add relationships
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
	</div>
</div>

@push('js')
    <script>

        let relation_type_input = $('select[name="relationship_type"]');
        let relation_table_input = $('select[name="relationship_table"]');
        let relationship_column_input = $('select[name="relationship_column"]');
        let relationship_label_input = $('select[name="relationship_label"]');
        let relationship_key_input = $('select[name="relationship_key"]');

        relation_type_input.change(function(){
            let val = $(this).val();
            let form = $(this).parents('form');
            if(val === 'belongsTo'){
                form.find('.relationshipField').show();
                form.find('.relationshipPivot').hide();
            } else if(val === 'hasOne' || val === 'hasMany'){
                form.find('.relationshipField').show();
                form.find('.relationshipPivot').hide();
            } else {
                form.find('.relationshipField').hide();
                form.find('.relationshipPivot').show();
            }
        });

        relation_table_input.on('change', function(){
            let tbl_selected_text = $(this).find('option:selected').text();
            $('span.label_table_name').text(tbl_selected_text);
            populateRowsFromTable($(this));
        });

        relation_type_input.trigger('change');

        function populateRowsFromTable(dropdown){
            $.ajax({
                url:  '{{ route('shuttle.database.bymodel') }}',
                data: {
                    model: $(dropdown).val(),
                },
                success(data){
                    relationship_column_input.empty();
                    relationship_label_input.empty();
                    relationship_key_input.empty();
                    for (const [key, value] of Object.entries(data)) {
                        let newOption = '<option value="' + key + '">' + key + '</option>';
                        relationship_column_input.append(newOption);
                        relationship_label_input.append(newOption);
                        relationship_key_input.append(newOption)
                    }
                    relationship_column_input.trigger('change');
                    relationship_label_input.trigger('change');
                    relationship_key_input.trigger('change');
                }
            });
        }
    </script>
@endpush
