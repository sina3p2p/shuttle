@extends('shuttle::admin')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form action="{{route('shuttle.setting.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="select-from-library-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="select-from-library-button sfl-single"
                                                data-library-id="#libraryModal" data-count="1" data-name="header-logo"
                                                @if(isset($setting["shuttle-header-logo"]))
                                                data-preview-path="{{ Storage::url($setting[" shuttle-header-logo"]) }}"
                                                data-path="{{ $setting[" header-logo"] }}" @endif>
                                                <div
                                                    class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                                                    Select an item from library
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="accountTextarea">primary color</label>
                                <input class="form-control" id="accountTextarea" name="shuttle-primary-color"
                                    value="{{data_get($setting,'shuttle-primary-color')}}">
                            </div>
                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0">ცვლილელების
                                    შენახვა</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop