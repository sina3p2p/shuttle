<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dore jQuery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('assets/font/iconsmind/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/font/simple-line-icons/css/simple-line-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('css/admin/main.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/dore.light.blue.min.css')}}" />
</head>
<body class="background show-spinner">
<main>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-4 login-section-wrapper">
          <div class="brand-wrapper">
            <a href="https://www.mygo.ge"><img src="https://www.mygo.ge/img/mygo.png" alt="logo" class="logo"></a>
            <a href="mailto:info@mygo.ge" class="f">info@mygo.ge</a>
          </div>
          <div class="login-wrapper my-auto">
            <h1 class="login-title">პაროლის აღდგენა</h1>
            <form action="{{ route('admin.login.store') }}" method="POST" class="valid-form">
                @csrf
                <div class="form-group">
                <label for="email">თქვენი ელ.ფოსტა</label>
                <input id="email" name="email" class="form-control" data-validation="required|email" value="{{old('email')}}" placeholder="შეიყვანეთ ელ.ფოსტა"/>
                </div>
              <button class="loginin" type="submit">პაროლის აღდგენა</button>
            </form>
            <a href="{{ route('admin.login') }}" class="forgot-password-link">ავტორიზაცია</a>
          </div>
        </div>
        <div class="col-sm-8 px-0 d-none d-sm-block">
          <img src="https://www.mygo.ge/imagesmanager/5.jpg" alt="login image" class="login-img">
        </div>
      </div>
    </div>
  </main>
    <script src="{{asset('js/admin/vendor/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/admin/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/admin/dore.script.js')}}"></script>
    <script src="{{asset('js/admin/scripts.js')}}"></script>
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
        $('.fixed-background').css('background-image', 'url(' + imageUrl + ')');
        $('.image-side').css('background-image', 'url(' + imageUrl + ')');
    </script>
</body>
</html>
