@extends('shuttle::admin')

@push('css-vendors')
    <link rel="stylesheet" type="text/css" href="{{route('shuttle.assets','css/vendor/bootstrap-tagsinput.css')}}">
@endpush

@section('breadcrumbs')


            <div class="pageTitle mb-100">
                <div class="pageTitle-title">
                    <h1>@if($add) ახლის დამატება @else {{$page->title}} @endif</h1>
                                </div>
                <!-- /.pageTitle-title -->
                <div class="pageTitle-down">
                    <ul> 
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.page.index')}}">გვერდები</a>
                        </li>
                        <li class="breadcrumb-item active">
                          <a href="#"> @if($add) ახლის დამატება @else {{$page->title}} @endif</a>
                        </li>
                    </ul>

                    
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                    data-target="#componentModal"><svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            
                        <title/>
                        
                        <g id="Complete">
                        
                        <g data-name="add" id="add-2">
                        
                        <g>
                        
                        <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5"/>
                        
                        <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12"/>
                        
                        </g>
                        
                        </g>
                        
                        </g>
                        
                        </svg> კომპონენტის დამატება</a>
                </div>
                <!-- /.pageTitle-down -->
            </div>
            <!-- /.pageTitle -->


       
@stop

@section('main')
    <div id="app">
        <div class="content-body">
            <section id="nav-filled">
                <div class="row">
<div class="col-md-12">
<div class="choose-lang">
    <h1>გთხოვთ აირჩიოთ ენა</h1>
    <ul class="langs">
        @foreach(config('translatable.locales') as $translate)
        <li @if($lang == $translate) class="active" @endif><a href="?lang={{$translate}}"><img src="{{asset('assets/img/'.$translate.'.png')}}" alt="{{$translate}}">{{$translate}}</a></li>
        @endforeach
    </ul>
</div>
<!-- /.choose-lang -->
   
</div>
<!-- /.col-md-12 -->
                    <div class="col-md-12 col-12">
                        @include('shuttle::page.includes.user-editor')
                    </div>
                    
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade modal-right" id="componentModal" tabindex="-1" role="dialog" aria-labelledby="componentModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">კომპონენტის დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 1.8rem">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($components as $com)
                            <div class="compo-item">
                                <figure>
                                    <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_429_11113)">
                                        <path d="M12 2.99994L15 5.99994L12 8.99994L9 5.99994L12 2.99994Z" stroke="#292929" stroke-width="2.5" stroke-linejoin="round"/>
                                        <path d="M12 14.9999L15 17.9999L12 20.9999L9 17.9999L12 14.9999Z" stroke="#292929" stroke-width="2.5" stroke-linejoin="round"/>
                                        <path d="M18 8.99994L21 11.9999L18 14.9999L15 11.9999L18 8.99994Z" stroke="#292929" stroke-width="2.5" stroke-linejoin="round"/>
                                        <path d="M6 8.99994L9 11.9999L6 14.9999L3 11.9999L6 8.99994Z" stroke="#292929" stroke-width="2.5" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_429_11113">
                                        <rect width="24" height="24" fill="white"/>
                                        </clipPath>
                                        </defs>
                                        </svg>
                                </figure>
                                <div class="compo-item__title">
                                    <h3>{{$com->display_name}}</h3>
                                    <div class="btns">
                                    <a href="{{route('shuttle.user_component_store', ['component_id'=> $com->id,'page_id' => $page->id,'lang' => $lang])}}" class="btn-primary btn-add">
                                        <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C12.5523 4 13 4.44772 13 5V11H19C19.5523 11 20 11.4477 20 12C20 12.5523 19.5523 13 19 13H13V19C13 19.5523 12.5523 20 12 20C11.4477 20 11 19.5523 11 19V13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H11V5C11 4.44772 11.4477 4 12 4Z" fill="#000000"/>
                                            </svg> დამატება
                                    </a>
                                    <!-- /.btn-primary -->
                                
                                </div>
                                                <!-- /.btns -->
                                </div>
                                <!-- /.compo-item__title -->
                            </div>
                            <!-- /.compo-item -->
                            @endforeach
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js-vendor')
    <script src="{{route('shuttle.assets','js/vendor/dropzone.min.js')}}"></script>
    <script src="{{route('shuttle.assets','js/dore-plugins/select.from.library.js')}}"></script>
    <script src="{{route('shuttle.assets','js/vendor/bootstrap-tagsinput.min.js')}}"></script>
@endpush
@push('js')
    <script src="{{route('shuttle.model.js.data',['model' => 'component'])}}"></script>
@endpush
