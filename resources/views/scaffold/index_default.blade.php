<div class="panel panel-bordered">
    <div class="panel-body">
        @if ($isServerSide)
        <form method="get" class="form-search">
            <div id="search-input">
                <div class="col-2">
                    <select id="search_key" name="key">
                        @foreach($searchNames as $key => $name)
                        <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key ==
                            $defaultSearchKey)) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <select id="filter" name="filter">
                        <option value="contains" @if($search->filter == "contains") selected @endif>contains</option>
                        <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                    </select>
                </div>
                <div class="input-group col-md-12">
                    <input type="text" class="form-control" placeholder="{{ __('generic.search') }}" name="s"
                        value="{{ $search->value }}">
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="submit">
                            <i class="voyager-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            @if (Request::has('sort_order') && Request::has('order_by'))
            <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
            <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
            @endif
        </form>
        @endif
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th> # </th>
                        @foreach($scaffold_interface->browseRows as $row)
                        <th>{{ $row->display_name }}</th>
                        @endforeach
                        <th>აქტივობები</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataTypeContent as $data)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        @foreach($scaffold_interface->browseRows as $row)
                        <td>
                            @if (isset($row->details->view))
                            @include($row->details->view, ['row' => $row, 'dataType' => $scaffold_interface,
                            'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' =>
                            'browse', 'view' => 'browse', 'options' => $row->details])
                            @elseif($row->type == 'image')
                            @if($data->{$row->field})
                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Storage::url( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif"
                                style="width:100px">
                            @else
                            <img src="{{asset('shuttle/img/no_photo.png')}}" style="width:40px">
                            @endif
                            @elseif($row->type == 'relationship')
                            @include('shuttle::formfields.relationship', ['view' => 'browse','options' =>
                            $row->details])
                            @elseif($row->type == 'select_multiple')
                            @if(property_exists($row->details, 'relationship'))

                            @foreach($data->{$row->field} as $item)
                            {{ $item->{$row->field} }}
                            @endforeach

                            @elseif(property_exists($row->details, 'options'))
                            @if (!empty(json_decode($data->{$row->field})))
                            @foreach(json_decode($data->{$row->field}) as $item)
                            @if (@$row->details->options->{$item})
                            {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                            @endif
                            @endforeach
                            @else
                            {{ __('::generic.none') }}
                            @endif
                            @endif

                            @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                            @if (@count(json_decode($data->{$row->field})) > 0)
                            @foreach(json_decode($data->{$row->field}) as $item)
                            @if (@$row->details->options->{$item})
                            {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                            @endif
                            @endforeach
                            @else
                            {{ __('generic.none') }}
                            @endif

                            @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') &&
                            property_exists($row->details, 'options'))

                            {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                            @elseif($row->type == 'date' || $row->type == 'timestamp')
                            @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                            {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                            @else
                            {{ $data->{$row->field} }}
                            @endif
                            @elseif($row->type == 'checkbox')
                            @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                            @if($data->{$row->field})
                            <span class="label label-info">{{ $row->details->on }}</span>
                            @else
                            <span class="label label-primary">{{ $row->details->off }}</span>
                            @endif
                            @else
                            {{ $data->{$row->field} }}
                            @endif
                            @elseif($row->type == 'color')
                            <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{
                                $data->{$row->field} }}</span>
                            @elseif($row->type == 'text')
                            {{-- @include('multilingual.input-hidden-bread-browse')--}}
                            <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) .
                                ' ...' : $data->{$row->field} }}</div>
                            @elseif($row->type == 'text_area')
                            {{-- @include('multilingual.input-hidden-bread-browse')--}}
                            <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) .
                                ' ...' : $data->{$row->field} }}</div>
                            @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                            {{-- @include('multilingual.input-hidden-bread-browse')--}}
                            @if(json_decode($data->{$row->field}) !== null)
                            @foreach(json_decode($data->{$row->field}) as $file)
                            <a href="{{ Storage::disk(config('storage.disk'))->url($file->download_link) ?: '' }}"
                                target="_blank">
                                {{ $file->original_name ?: '' }}
                            </a>
                            <br />
                            @endforeach
                            @else
                            <a href="{{ Storage::disk(config('storage.disk'))->url($data->{$row->field}) }}"
                                target="_blank">
                                Download
                            </a>
                            @endif
                            @elseif($row->type == 'rich_text_box')
                            {{-- @include('multilingual.input-hidden-bread-browse')--}}
                            <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ?
                                            mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' :
                                                        strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                            @elseif($row->type == 'coordinates')
                            @include('partials.coordinates-static-image')
                            @elseif($row->type == 'multiple_images')
                            @php $images = is_array($data->{$row->field}) ? $data->{$row->field} :
                            json_decode($data->{$row->field}); @endphp
                            @if($images)
                            @php $images = array_slice($images, 0, 3); @endphp
                            @foreach($images as $image)
                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Storage::url( $image ) }}@else{{ $image }}@endif"
                                style="width:50px">
                            @endforeach
                            @endif
                            @elseif($row->type == 'media_picker')
                            @php
                            if (is_array($data->{$row->field})) {
                            $files = $data->{$row->field};
                            } else {
                            $files = json_decode($data->{$row->field});
                            }
                            @endphp
                            @if ($files)
                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                            @foreach (array_slice($files, 0, 3) as $file)
                            <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif"
                                style="width:50px">
                            @endforeach
                            @else
                            <ul>
                                @foreach (array_slice($files, 0, 3) as $file)
                                <li>{{ $file }}</li>
                                @endforeach
                            </ul>
                            @endif
                            @if (count($files) > 3)
                            {{ __('media.files_more', ['count' => (count($files) - 3)]) }}
                            @endif
                            @elseif (is_array($files) && count($files) == 0)
                            {{ trans_choice('media.files', 0) }}
                            @elseif ($data->{$row->field} != '')
                            @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif"
                                style="width:50px">
                            @else
                            {{ $data->{$row->field} }}
                            @endif
                            @else
                            {{ trans_choice('media.files', 0) }}
                            @endif
                            @else
                            <span>{{ $data->{$row->field} }}</span>
                            @endif
                        </td>
                        @endforeach
                        <td>
                            @if($show)
                            <a href="{{route('shuttle.scaffold_interface.show',['scaffold_interface' => $scaffold_interface, 'id' => $data->id ])}}"
                                class="btn btn-warning default">დეტალურად</a>
                            @endif
                            @if($edit)
                            <a href="{{route('shuttle.scaffold_interface.edit',['scaffold_interface' => $scaffold_interface, 'id' => $data->id ])}}"
                                class="btn btn-primary default">რედაქტირება</a>
                            @endif
                            @if($delete)
                            <button type="button" class="btn btn-danger default remove-item"
                                data-id="{{$data->id}}">წაშლა</button>
                            @endif
                            @foreach($actions as $action)
                            @if (!method_exists($action, 'massAction'))
                            @include('shuttle::bread.partials.actions', ['action' => $action])
                            @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($isServerSide)
        <div class="pull-left">
            <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                'generic.showing_entries', $dataTypeContent->total(), [
                'from' => $dataTypeContent->firstItem(),
                'to' => $dataTypeContent->lastItem(),
                'all' => $dataTypeContent->total()
                ]) }}</div>
        </div>
        <div class="pull-right">
            {{ $dataTypeContent->appends([
            's' => $search->value,
            'filter' => $search->filter,
            'key' => $search->key,
            'order_by' => $orderBy,
            'sort_order' => $sortOrder,
            'showSoftDeleted' => $showSoftDeleted,
            ])->links() }}
        </div>
        @endif
    </div>
</div>

@push('js')
<script>
    $(document).on('mousedown','.remove-item',function (e) {
            e.preventDefault();
            var item = $(e.target);
            var form = $('<form action="'+"{{route('shuttle.scaffold_interface.destroy',['scaffold_interface' => $scaffold_interface, 'id' => '__id'])}}".replace('__id',item.data('id'))+'" method="post">'+
                '@csrf'+'@method("DELETE")'+'</form>');
            form.appendTo('body');
            form.submit();
        });
</script>
@endpush