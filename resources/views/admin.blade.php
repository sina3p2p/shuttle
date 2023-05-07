<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <title>Shuttle Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{route('shuttle.assets','fonts/iconsmind-s/css/iconsminds.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','fonts/simple-line-icons/css/simple-line-icons.css')}}" />
    @stack('css-vendors2')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/dropzone.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    {{-- <style>
        :root {
            --theme-color-1: {
                    {
                    setting('shuttle-primary-color', '#da251c')
                }
            }

            ;
            --theme-color-2: #2a93d5;
            --theme-color-3: #6c90a1;
            --theme-color-4: #365573;
            --theme-color-5: #47799a;
            --theme-color-6: #8e9599;
            --theme-color-1-10: rgba(20, 83, 136, .1);
            --theme-color-2-10: rgba(42, 147, 213, .1);
            --theme-color-3-10: rgba(108, 144, 161, .1);
            --theme-color-4-10: rgba(54, 85, 115, .1);
            --theme-color-5-10: rgba(71, 121, 154, .1);
            --theme-color-6-10: hsla(202, 5%, 58%, .1);
            --primary-color: #212121;
            --foreground-color: #fff;
            --separator-color: #d7d7d7
        }
    </style> --}}
    @stack('css-vendors')
    <link rel="stylesheet" href="{{route('shuttle.assets','css/main.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.vue-assets','app.css') }}?v={{ time() }}" />
    @stack('css')
</head>

<body id="app-container" class="ltr rounded menu-default show-spinner">
  

    @php $children = []; @endphp

   


<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-top">
                    <div class="header-top__logo">
                        <a href="/">Shuttle <span></span></a>
                    </div>
                    <!-- /.header-top__logo -->
                    <div class="header-top__actions">

                        <div class="user">
                            <div class="user-img">
                                <figure>
                                    <img src="https://cdn.landesa.org/wp-content/uploads/default-user-image.png" alt="">
                                </figure>
                            </div>
                            <!-- /.user-img -->
                            <div class="user-title">
                                <h3>გამარჯობა , {{ auth()->user()->name }}</h3>
                                <a href="{{ route('shuttle.logout') }}">გასვლა</a>
                            </div>
                            <!-- /.user-title -->
                        </div>
                        <!-- /.user -->
                    </div>
                    <!-- /.header-top__actions -->
                </div>
                <!-- /.header-top -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</header>
<!-- /.header -->



    <div class="menu">
        <div class="main-menu">
            <h3>მთავარი მენიუ</h3>
            <div class="scroll">
                <ul class="list-unstyled">
                    @foreach ($menus ?? [] as $m)
                    @if($m->children->count())
                    <li>
                        <a href="#menu-{{ $m->id }}">
                            @if($m->svg)
                            {!! $m->svg !!}
                            @else
                            <i class="{{ $m->image }}"></i>
                            @endif
                            {{ $m->label }}
                        </a>
                    </li>
                    @php $children[$m->id] = $m->children @endphp
                    @else
                    <li><a href="{{ url('/mypanel/'.$m->link) }}">
                            @if($m->svg)
                            {!! $m->svg !!}
                            @else
                            <i class="{{ $m->image }}"></i>
                            @endif
                            {{ $m->label }}
                        </a>
                    </li>
                    @endif
                    @endforeach
                  
                    {{-- @if(auth()->user()->role == "developer")
                    <li><a href="#developer"><i class="iconsmind-Cool-Guy"></i>ვებისთვის</a></li>
                    @endif --}}


                   
                    @if(auth()->user()->role == "developer")
                    <div class="forus">
                    <h3 >ვებისთვის</h3>
                        <li><a href="{{route('shuttle.developer.database.index')}}"><i
                                    class="simple-icon-layers"></i>ბაზები</a></li>
                        <li><a href="{{route('shuttle.developer.bread.index')}}"><i
                                    class="simple-icon-organization"></i>მოდელები</a></li>
                        <li><a href="{{route('shuttle.component.index')}}"><i
                                    class="simple-icon-puzzle"></i>კომპონენტები</a></li>
                        <li><a href="{{route('shuttle.developer.type.index')}}"><i
                                    class="simple-icon-compass"></i>ტიპები</a></li>
                        <li><a href="{{route('shuttle.developer.menu.index')}}"><i class="simple-icon-compass"></i>Menu</a>
                        </li>
                        <li><a href="{{route('shuttle.developer.setting')}}"><i class="simple-icon-compass"></i>Setting</a>
                        </li>
                    </div>
                    <!-- /.forus -->
                    @endif
                </ul>
            </div>
        </div>
        
            </div>
        </div>
    </div>
    <main id="app">
        
        <my-dialog ref="confirm"></my-dialog>
        <div class="container-fluid">
            @yield('breadcrumbs')
            <div class="row">
                <div class="col-md-12">
                    @yield('main')
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>Shuttle {{ date('Y') }}</p>
        </footer>
        <!-- /.footer -->
    </main>

   
    {{-- <script src="{{route('shuttle.assets','js/vendor/jquery-3.3.1.min.js')}}"></script> --}}
    {{-- <script src="{{route('shuttle.assets','js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/perfect-scrollbar.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/bootstrap-notify.min.js')}}"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script> --}}
    @stack('js-vendor')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

    <script src="{{route('shuttle.vue-assets','manifest.js') }}?v={{ time() }}"></script>
    <script src="{{route('shuttle.vue-assets','vendor.js') }}?v={{ time() }}"></script>
    <script src="{{route('shuttle.vue-assets','app.js') }}?v={{ time() }}"></script>
    <script src="{{route('shuttle.assets','js/dore.script.js')}}"></script>
    <script src="{{route('shuttle.assets','js/scripts.js')}}"></script>
    

    <script>
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    @stack('js')
    @if($errors->any())
    <script>
        @foreach($errors->getMessages() as $key => $error)
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