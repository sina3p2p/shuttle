<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <title>myGO Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{route('shuttle.assets','fonts/iconsmind/style.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','fonts/simple-line-icons/css/simple-line-icons.css')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="https://www.mygo.ge/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.mygo.ge/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.mygo.ge/favicon/favicon-16x16.png">
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/dropzone.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/perfect-scrollbar.css')}}" />
    @stack('css-vendors')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/main.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{route('shuttle.assets','css/dore.light.blue.min.css')}}" />
    @stack('css')
</head>
<body id="app-container" class="menu-default show-spinner">
<nav class="navbar fixed-top">
    <div class="d-flex align-items-center navbar-left">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17"><rect x="0.48" y="0.5" width="7" height="1" /><rect x="0.48" y="7.5" width="7" height="1" /><rect x="0.48" y="15.5" width="7" height="1" /></svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17"><rect x="1.56" y="0.5" width="16" height="1" /><rect x="1.56" y="7.5" width="16" height="1" /><rect x="1.56" y="15.5" width="16" height="1" /></svg>
        </a>
        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17"><rect x="0.5" y="0.5" width="25" height="1" /><rect x="0.5" y="7.5" width="25" height="1" /><rect x="0.5" y="15.5" width="25" height="1" /></svg>
        </a>
    </div>
    <a class="navbar-logo" href="https://mygo.ge" target="_blank"><span class="logo d-none d-xs-block"></span><span class="logo-mobile d-block d-xs-none"></span></a>
    <div class="navbar-right">
        <div class="header-icons d-inline-block align-middle">
            <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                <i class="simple-icon-size-fullscreen"></i><i class="simple-icon-size-actual"></i>
            </button>
        </div>
        <div class="user d-inline-block">
            <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="name"></span>
                <span><lottie-player src="{{route('shuttle.assets','user.json')}}" background="transparent" speed="1" style="width: 40px; height: 40px;" autoplay></lottie-player></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="{{route('shuttle.setting.index')}}#setting-password">????????????????????? ????????????????????????</a>
                <a class="dropdown-item" href="/mygo/logout">????????????????????????</a>
            </div>
        </div>
    </div>
</nav>
<div class="sidebar">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <li><a href="{{route('shuttle.index')}}"><i class="iconsmind-Home"></i>?????????????????????</a></li>
                @canany(['pages_browse','developer'])
                    <li><a href="{{route('shuttle.page.index')}}"><i class="iconsmind-Files"></i>????????????????????????</a></li>
                @endcanany
                @foreach($scaffold as $sf)
                    @canany([$sf->name.'_browse', 'developer'])
                        <li><a href="{{route('shuttle.scaffold_interface.index', $sf)}}"><i class="{{$sf->icon}}"></i>{{$sf->display_name_plural}}</a></li>
                    @endcanany
                @endforeach
                @canany(['menus_browse','developer'])
                    <li><a href="{{route('shuttle.menu.index')}}"><i class="simple-icon-list"></i>???????????????????????????</a></li>
                @endcanany
                @canany(['roles_browse','developer'])
                    <li><a href="{{route('shuttle.roles.index')}}"><i class="simple-icon-lock"></i>??????????????????</a></li>
                @endcanany
                @canany(['translates_browse','developer'])
                    <li><a href="{{route('shuttle.translation.index')}}"><i class="simple-icon-refresh"></i>????????????????????????</a></li>
                @endcanany
                @canany(['settings_browse','developer'])
                    <li><a href="{{route('shuttle.setting.index')}}"><i class="simple-icon-settings"></i>?????????????????????????????????</a></li>
                @endcanany
                @if(auth()->user()->role == "developer")
                    <li><a href="#developer"><i class="iconsmind-Cool-Guy"></i>???????????????????????????</a></li>
                @endif
            </ul>
        </div>
    </div>
    @if(auth()->user()->role == "developer")
    <div class="sub-menu">
        <div class="scroll">
            <ul class="list-unstyled" data-link="developer">
                <li><a href="{{route('shuttle.database.index')}}"><i class="simple-icon-layers"></i>??????????????????</a></li>
                <li><a href="{{route('shuttle.bread.index')}}"><i class="simple-icon-organization"></i>????????????????????????</a></li>
                <li><a href="{{route('shuttle.component.index')}}"><i class="simple-icon-puzzle"></i>????????????????????????????????????</a></li>
                <li><a href="{{route('shuttle.type.index')}}"><i class="simple-icon-compass"></i>??????????????????</a></li>
            </ul>
        </div>
    </div>
    @endif
</div>
<main>
    <div class="container-fluid">
        @yield('breadcrumbs')
        <div class="row">
            <div class="col-md-12">
                @yield('main')
            </div>
        </div>
    </div>
</main>
<script src="{{route('shuttle.assets','js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{route('shuttle.assets','js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{route('shuttle.assets','js/vendor/perfect-scrollbar.min.js')}}"></script>
<script src="{{route('shuttle.assets','js/vendor/bootstrap-notify.min.js')}}"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@stack('js-vendor')
<script src="{{route('shuttle.assets','js/dore.script.js')}}"></script>
<script src="{{route('shuttle.assets','js/scripts.js')}}"></script>
<script>$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});</script>
@stack('js')
@if($errors->any())
    <script>
        @foreach ($errors->getMessages() as $key => $error)
        @if(is_array($error))
        @foreach($error as $er)
        showNotification('top', 'right', "{{$key}}", "{{ $er }}");
        @endforeach
        @else
        showNotification('top', 'right', "{{$key}}", "{{ $error }}");
        @endif
        @endforeach
    </script>
@endif
</body>
</html>
