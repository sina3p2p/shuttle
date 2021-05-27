@foreach($items as $item)
<div class="card mb-4 {{$mySetting['key']}}">
    <div class="card-body">
        <div class="w-100 d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-4">სიახლე - {{$loop->index}}</h5>
        <button class="btn btn-sm btn-primary remove-item">წაშლა</button>
        </div>
        <!-- /.w-100 d-flex justify-content-between align-items-center -->

        @php $index = $loop->index @endphp
        @foreach($settings as $setting)
            @switch($setting['type'])
                @case('array')
                <div class="form-group">
                    @include('shuttle::page.includes.array-component', ['settings' => data_get($setting,'objects'),'items' => data_get($item,$setting['key'])])
                </div>
                @break
                @case('image')
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label">{{data_get($setting,'value')}}</label>
                    <div class="col-sm-10">
                        <div class="select-from-library-container">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-4">
                                    <div class="select-from-library-button sfl-single mb-5" data-library-id="#libraryModal"
                                         data-count="1" data-name="{{$mySetting['key']}}[{{$index}}][{{data_get($setting,'key')}}]"
                                         @if(data_get($item,$setting['key']))
                                         data-preview-path="{{ Storage::url(data_get($item,$setting['key'])) }}"
                                         data-path="{{data_get($item,$setting['key'])}}"
                                            @endif>
                                        <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                                            Select an item from library
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <input class="form-control" v-model="component_data[item.key]" data-media="1" value="{{data_get($item,$setting['key'])}}">--}}
                    </div>
                </div>
                @break
                @case('html')
                <div class="form-group row">
                    <div class="col-md-2">
                        <span>{{data_get($setting,'value')}}</span>
                    </div>
                    <div class="col-md-10">
                        <textarea  id="{{$mySetting['key'].'-'.$setting['key'].'-'.$index}}" class="richTextBox" name="{{$mySetting['key']}}[{{$index}}][{{data_get($setting,'key')}}]">{{data_get($item,$setting['key'])}}</textarea>
                    </div>
                </div>
                @break
                @default
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{data_get($setting,'value')}}</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="{{$mySetting['key']}}[{{$index}}][{{data_get($setting,'key')}}]" value="{{data_get($item,$setting['key'])}}">
                    </div>
                </div>
            @endswitch
        @endforeach
    </div>
</div>
@endforeach
