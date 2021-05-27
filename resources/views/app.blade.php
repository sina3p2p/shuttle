<html lang="{{$lang}}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @stack('seo')
    <link href="{{asset('path/to/file')}}" rel="stylesheet">
</head>
<body>
@yield('content')
@stack('js-vendor')
@stack('js')
</body>
</html>
