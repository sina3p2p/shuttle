<div class="row">
    <div class="col-12">
        <div class="mb-2">
            <h1>{{array_key_last ($breadCrumbs)}}</h1>
            @if(isset($btn) && !is_null($btn))
            <div class="float-sm-right text-zero">
                <a href="{{$btn}}" class="btn btn-primary btn-lg">ახლის დამატება</a>
            </div>
            @endif
            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                <ol class="breadcrumb pt-0">
                    @foreach($breadCrumbs as $bread => $route)
                    <li class="breadcrumb-item">
                        <a href="{{$route}}">{{$bread}}</a>
                    </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        <div class="separator mb-5"></div>
    </div>
</div>
