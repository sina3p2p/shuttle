@php $url = ""; if(isset($page) && $page->model == 'home'){ if(LaravelLocalization::getCurrentLocale() == 'ka') { $url = url('/'); } else { $url = LaravelLocalization::localizeUrl('/'); } } else { $url = url()->current(); } @endphp
@extends('app')
@push('seo')
    <title>{{($data && !is_array($data) && !is_a($data, 'Illuminate\Database\Eloquent\Collection') && !is_a($data, 'Illuminate\Pagination\LengthAwarePaginator')) ? $data->title : $page->title}} - ABAO.GE</title>
    <meta name="keywords" content="{{($data && !is_array($data)  && !is_a($data, 'Illuminate\Database\Eloquent\Collection') && !is_a($data, 'Illuminate\Pagination\LengthAwarePaginator')) ? $data->keywords : $page->keywords}}">
    <meta name="description" content="{{($data && !is_array($data) && !is_a($data, 'Illuminate\Database\Eloquent\Collection') && !is_a($data, 'Illuminate\Pagination\LengthAwarePaginator')) ? $data->description : $page->description}}">
    <link rel="canonical" href="{{$url}}" />
    <meta itemprop="name" content="{{$page->title}} - SERVER1.GE">
    <meta itemprop="description" content="{{($data && !is_array($data) && !is_a($data, 'Illuminate\Database\Eloquent\Collection') && !is_a($data, 'Illuminate\Pagination\LengthAwarePaginator')) ? $data->description : $page->description}}">
    <meta itemprop="image" content="{{($data && isset($data->image)) ? url(Storage::url($data->image)) : url(Storage::url($page->image))}}">
    <meta property="fb:app_id" content="788287088369573" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="SERVER1.GE" />
    <meta property="og:url" content="{{$url}}" />
    <meta property="og:title" content="{{($data && isset($data->title)) ? $data->title : $page->title}} - SERVER1.GE" />
    <meta property="og:description" content="{{$page->description}}" />
    <meta property="og:image" content="{{($data && isset($data->image)) ? url(Storage::url($data->image)) : url(Storage::url($page->image))}}" />
    <meta name="geo.region" content="GE-TB" />
    <meta name="geo.placename" content="Tbilisi" />
    <meta name="geo.position" content="41.726687;44.744868" />
    <meta name="ICBM" content="41.726687, 44.744868" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/fav/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/fav/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/fav/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/fav/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/fav/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/fav/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/fav/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/fav/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/fav/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('assets/fav/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/fav/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/fav/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/fav/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/fav/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

@endpush
@section('content')
    @if(optional($page->type)->name != 'home')<x-breadcrumb :data="$data" :page="$page"></x-breadcrumb>@endif
    @includeIf($include_file, ['data' => $data, 'route' => $route])
@stop
