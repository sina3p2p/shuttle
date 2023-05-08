<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shuttle Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{route('shuttle.assets','fonts/iconsmind/style.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','fonts/simple-line-icons/css/simple-line-icons.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/vendor/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.assets','css/main.css')}}" />
    <link rel="stylesheet" href="{{route('shuttle.vue-assets','app.css') }}?v={{ time() }}" />

    <link rel="stylesheet" type="text/css" href="{{route('shuttle.assets','css/dore.light.blue.min.css')}}" />
</head>
<body class="background loginn">
  <img src="" alt="login image" class="login-img">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 login-section-wrapper">
          <div class="login-wrapper my-auto">
            <h1 class="login-title">ავტორიზაცია</h1>
            <form action="{{ route('shuttle.login.store') }}" method="POST" class="valid-form">
                @csrf
                <div class="form-group">
                <label for="email">თქვენი ელ.ფოსტა</label>
                <input id="email" name="email" class="form-control" data-validation="required|email" value="{{old('email')}}" placeholder="შეიყვანეთ ელ.ფოსტა"/>
                </div>
              <div class="form-group mb-4">
                <label for="password">თქვენი პაროლი</label>
                <input id="password" name="password" class="form-control" type="password" data-validation="required"  placeholder="შეიყვანეთ პაროლი"/>
              </div>
              <button class="btn btn-primary" type="submit">ავტორიზაცია</button>
            </form>
            {{-- <a href="{{ route('shuttle.forget') }}" class="forgot-password-link">დაგავიწყდათ პაროლი?</a> --}}
          </div>
        </div>
       
      </div>
    </div>

    <script src="{{route('shuttle.assets','js/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/jquery.form-validator.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/bootstrap-notify.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/dore.script.js')}}"></script>
    <script src="{{route('shuttle.assets','js/scripts.js')}}"></script>
    <script>
        let bg = ['https://www.mygo.ge/imagesmanager/1.jpg',
                  'https://www.mygo.ge/imagesmanager/2.jpg',
                  'https://www.mygo.ge/imagesmanager/3.jpg',
                  'https://www.mygo.ge/imagesmanager/4.jpg',
                  'https://www.mygo.ge/imagesmanager/5.jpg',
                  'https://www.mygo.ge/imagesmanager/6.jpg',
                  'https://www.mygo.ge/imagesmanager/7.jpg',
                  'https://www.mygo.ge/imagesmanager/8.jpg',
                  'https://www.mygo.ge/imagesmanager/9.jpg',
                  'https://www.mygo.ge/imagesmanager/10.jpg',
                  'https://www.mygo.ge/imagesmanager/11.jpg',];
        let imageUrl = bg[Math.floor(Math.random()*bg.length)];
        $('.login-img').attr("src", imageUrl);
    </script>
    @if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        showNotification('top', 'right', "danger", "{{ $error }}");
        @endforeach
    </script>
    @endif
</body>
</html>
