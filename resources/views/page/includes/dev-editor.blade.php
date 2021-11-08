<div class="card mb-4">
    <div class="d-flex flex-grow-1 min-width-zero">
        <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
            <div class="list-item-heading mb-0 truncate w-80 mb-1 mt-1">
                <span class="heading-number d-inline-block">
                    {{$key}}
                </span>
                Section
            </div>
        </div>
        <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
            <button class="btn btn-outline-theme-3 icon-button rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#q{{$key}}" aria-expanded="true" aria-controls="q1">
                <i class="simple-icon-arrow-down with-rotate-icon"></i>
            </button>
        </div>
    </div>
    <div class="question-collapse collapse" id="q{{$key}}" style="">
        <div class="card-header pl-0 pr-0">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 nav-fill" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="content-tab-{{$key}}" data-toggle="tab" href="#content-tab-content-{{$key}}" role="tab" aria-controls="content-tab-{{$key}}" aria-selected="false">Content</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="data-tab-{{$key}}" data-toggle="tab" href="#data-tab-content-{{$key}}" role="tab" aria-controls="data-tab-{{$key}}" aria-selected="false">Data</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content pt-1">
                <div class="tab-pane active" id="content-tab-content-{{$key}}" role="tabpanel" aria-labelledby="content-tab-{{$key}}">
                    <div class="row">
                        <div class="col-12">
                            <pre class="editor" id="editor{{$key}}"></pre>
                            <textarea id="editor{{$key}}" name="body" hidden>{{$section->body}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="data-tab-content-{{$key}}" role="tabpanel" aria-labelledby="data-tab-{{$key}}">
                    <div class="row">
                        <div class="col-12">
                            <div id="builder{{$loop->index}}"></div>
                        </div>
                    </div>
                    @php
                        $selected_ord = data_get($section->model ?? [],'order');
                        $selected_dir = data_get($section->model ?? [],'dir');
                        $lim = data_get($section->model ?? [],'limit', -1);
                    @endphp
                    <div class="row mt-3">
                        <div class="form-group col-md-4">
                            <label for="inputOrder{{$key}}">Order By</label>
                            <select class="form-control" id="inputOrder{{$key}}" name="model[order]">
                                @foreach($query_builder->pluck('id') as $col)
                                <option value="{{$col}}" @if($col == $selected_ord) selected @endif>{{$col}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputDirection{{$key}}">Direction</label>
                            <select id="inputDirection{{$key}}" class="form-control" name="model[dir]">
                                <option value="asc" @if($selected_dir == 'asc') selected @endif>ASC</option>
                                <option value="desc" @if($selected_dir == 'desc') selected @endif>DESC</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputLimit{{$key}}">Limit</label>
                            <input type="number" class="form-control" id="inputLimit{{$key}}" name="model[limit]" value="{{$lim}}">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="card-link btn btn-primary mt-2" name="position" value="{{$key}}">Save</button>
        </div>
    </div>
</div>
