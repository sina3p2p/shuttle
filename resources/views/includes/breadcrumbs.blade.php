


<div class="pageTitle">
    <div class="pageTitle-title">
        <h1>{{array_key_last ($breadCrumbs)}}</h1>
    </div>
    <!-- /.pageTitle-title -->
    <div class="pageTitle-down">
        <ul> 
            @foreach($breadCrumbs as $bread => $route)
            <li class="breadcrumb-item @if($loop->last) active @endif">
                <a href="{{$route}}">{{$bread}}</a>
            </li>
            @endforeach
        </ul>
        <a href="{{$btn}}" class="btn btn-primary"><svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

            <title/>
            
            <g id="Complete">
            
            <g data-name="add" id="add-2">
            
            <g>
            
            <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5"/>
            
            <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12"/>
            
            </g>
            
            </g>
            
            </g>
            
            </svg> ახლის დამატება</a>
    </div>
    <!-- /.pageTitle-down -->
</div>
<!-- /.pageTitle -->