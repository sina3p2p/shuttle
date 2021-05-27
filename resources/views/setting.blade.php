@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'პარამეტრები' => route('shuttle.setting.index')]])
@stop

@section('main')
<section id="page-account-settings">
    <div class="row">
        <!-- left menu section -->
        <div class="col-md-3 mb-2 mb-md-0">
            <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                <li class="nav-item">
                    <a class="nav-link d-flex py-75 active" id="setting-label-general" data-toggle="pill" href="#setting-general" aria-expanded="true">
                        <i class="feather icon-globe mr-50 font-medium-3"></i>
                        ძირითადი ინფორმაცია
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex py-75" id="setting-label-password" data-toggle="pill" href="#setting-password" aria-expanded="false">
                        <i class="feather icon-lock mr-50 font-medium-3"></i>
                        პაროლის ცვლილება
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex py-75" id="setting-label-social" data-toggle="pill" href="#setting-social" aria-expanded="false">
                        <i class="feather icon-camera mr-50 font-medium-3"></i>
                        სოციალური გვერდები
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex py-75" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                        <i class="feather icon-info mr-50 font-medium-3"></i>
                        Analytics
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="setting-general" aria-labelledby="setting-label-general" aria-expanded="true">
                                <form action="{{route('shuttle.setting.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="select-from-library-container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="select-from-library-button sfl-single" data-library-id="#libraryModal"
                                                             data-count="1" data-name="header-logo"
                                                             @if(isset($setting["header-logo"]))
                                                             data-preview-path="{{ Storage::url($setting["header-logo"]) }}"
                                                             data-path="{{ $setting["header-logo"] }}"
                                                             @endif>
                                                            <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                                                                Select an item from library
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="select-from-library-container">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="select-from-library-button sfl-single" data-library-id="#libraryModal"
                                                             data-count="1" data-name="footer-logo"
                                                             @if(isset($setting["footer-logo"]))
                                                             data-preview-path="{{ Storage::url($setting["footer-logo"]) }}"
                                                             data-path="{{ $setting["footer-logo"] }}"
                                                             @endif>
                                                            <div class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center">
                                                                Select an item from library
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="form-group">
                                                <label for="setting-general-header-menu">ზედა მენიუ</label>
                                                <select class="form-control" id="setting-general-header-menu" name="header_menu">
                                                    @foreach($menu as $m)
                                                    <option value="{{$m->id}}" @if($m->id == data_get($setting,'header_menu', 0))selected @endif>{{$m->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="setting-general-footer-menu">ქვედა მენიუ</label>
                                                <select class="form-control" id="setting-general-footer-menu" name="footer_menu">
                                                    @foreach($menu as $m)
                                                    <option value="{{$m->id}}" @if($m->id == data_get($setting,'footer_menu', 0))selected @endif>{{$m->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="setting-general-footer-menu-2">ქვედა მენიუ</label>
                                                <select class="form-control" id="setting-general-footer-menu-2" name="footer_menu_2">
                                                    @foreach($menu as $m)
                                                        <option value="{{$m->id}}" @if($m->id == data_get($setting,'footer_menu_2', 0))selected @endif>{{$m->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit" class="btn btn-primary mb-1 mb-sm-0">ცვლილელების შენახვა</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="setting-password" role="tabpanel" aria-labelledby="setting-label-password" aria-expanded="false">
                                <form action="{{route('shuttle.change_password')}}" method="post" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="account-old-password">ძველი პაროლი</label>
                                        <input type="password" name="password" class="form-control" id="account-old-password" required placeholder="ძველი პაროლი" data-validation-required-message="This old password field is required">
                                    </div>
                                    <div class="form-group">
                                        <label for="account-new-password">ახალი პაროლი</label>
                                        <input type="password" name="new_password" id="account-new-password" class="form-control" placeholder="ახალი პაროლი" required data-validation-required-message="The password field is required" minlength="6">
                                    </div>
                                    <div class="form-group">
                                        <label for="account-retype-new-password">გაიმეორეთ ახალი პაროლი</label>
                                        <input type="password" name="re_password" class="form-control" required id="account-retype-new-password" data-validation-match-match="password" placeholder="გაიმეორეთ ახალი პაროლი" data-validation-required-message="The Confirm password field is required" minlength="6">
                                    </div>
                                    <div class="d-flex flex-sm-row flex-column justify-content-end">
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0">შენახვა</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                <form action="{{route('shuttle.setting.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="accountTextarea">View ID</label>
                                        <input class="form-control" id="accountTextarea" name="view_id" value="{{data_get($setting,'view_id')}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="account-phone">Service Account Credentials Json File</label>
                                        <input name="service_credentials" type="file" class="form-control" id="account-phone">
                                    </div>

                                    <div class="d-flex flex-sm-row flex-column justify-content-end">
                                        <button type="submit" class="btn btn-primary mb-1 mb-sm-0">შენახვა</button>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane fade" id="setting-social" role="tabpanel" aria-labelledby="setting-label-social" aria-expanded="false">
                                <form action="{{route('shuttle.setting.store')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="w-100 d-flex justify-content-between align-items-center mb-4">
                                                <h2>სოციალური გვერდები</h2>
                                                <button class="btn btn-primary d-flex align-items-center" id="addSocial" type="button"><i class="simple-icon-plus mr-2"></i> დამატება</button> <!-- /.btn btn-primary -->
                                            </div>
                                            <div class="social">
                                                @foreach(data_get($setting,'social',[]) as $social)
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <button class="btn btn-default remove-social" type="button"><i class="simple-icon-trash"></i></button>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <input type="text" name="social[{{$loop->index}}][icon]" class="form-control" placeholder="აიქონის დასახელება" value="{{data_get($social,'icon')}}">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" name="social[{{$loop->index}}][link]" class="form-control" placeholder="სოციალური გვერდის ლინკი" value="{{data_get($social,'link')}}">
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit" class="btn btn-primary mb-1 mb-sm-0">შენახვა</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('js-vendor')
    <script src="{{route('shuttle.assets','js/vendor/dropzone.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/plugins/select.from.library.js')}}"></script>
@endpush

@push('js')
    <script>
        $("#addSocial").on('click',function (e) {
            e.preventDefault();
            var social = $(".social");
            let length = social.children('.row').length;
            let $el =
                '<div class="row">' +
                '<div class="col-md-1"><button class="btn btn-default remove-social" type="button"><i class="simple-icon-trash"></i></button></div>' +
                '<div class="form-group col-md-5">' +
                '<input type="text" name="social['+length+'][icon]" class="form-control" placeholder="აიქონის დასახელება">' +
                '</div><div class="form-group col-md-6">' +
                '<input type="text" name="social['+length+'][link]" class="form-control" placeholder="სოციალური გვერდის ლინკი">' +
                '</div></div>';
            social.append($el)
        });
        $(document).on('click','.remove-social',function (e) {
            e.preventDefault();
            $(this).parents('.row:first').remove()
        })
    </script>
@endpush
