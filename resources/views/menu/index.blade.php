@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'ნავიგაცია' => route('shuttle.menu.index')], 'btn' => route('shuttle.menu.create')])
@stop

@section('main')
    {{--@include('admin.includes.breadcrumbs',['title' => 'Pages', 'route' => 'admin.page'])--}}
    <div class="content-body">
      
                                   
                                    <div class="page">
                                        <div class="page-title">
                                            <div class="page-title__item">#ID</div>
                                            <!-- /.page-title__item -->
                                            <div class="page-title__item">სათაური</div>
                                            <!-- /.page-title__item -->
                                            <div class="page-title__item">შექმნა</div>
                                            <!-- /.page-title__item -->
                                            <div class="page-title__item">განახლება</div>
                                            <!-- /.page-title__item -->
                                            <div class="page-title__item">აქტივობები</div>
                                            <!-- /.page-title__item -->
                                        </div>
                                        <!-- /.page-title -->
                                    
                                        <div class="page-content">
                                            @foreach($menus as $menu)
                                            <div class="page-content__item">
                                                <div class="item-init">{{$loop->iteration}}</div>
                                                <div class="item-init">{{$menu->name}}</div>
                                                <div class="item-init">{{$menu->created_at}}</div>
                                                <div class="item-init">{{$menu->updated_at}}</div>
                                                <div class="item-init">
                                                    <a href="{{route('shuttle.menu.edit',$menu)}}" class="btn btn-primary default"><svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    
                                                        <title/>
                                                        
                                                        <g id="Complete">
                                                        
                                                        <g id="edit">
                                                        
                                                        <g>
                                                        
                                                        <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                        
                                                        <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                        
                                                        </g>
                                                        
                                                        </g>
                                                        
                                                        </g>
                                                        
                                                        </svg></a>
                                                    <button type="button" class="btn btn-danger default remove-item" data-id="{{$menu->id}}"><svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M6 7V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V7" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg></button>
                                                </div>
                                            </div>
                                            <!-- /.page-content__item -->
                                        @endforeach
                                           
                                        </div>
                                        <!-- /.page-content -->
                                    </div>
                                    <!-- /.page -->
                                    
    </div>
@stop

@push('js')
    <script>
        $(document).on('mousedown','.remove-item',function (e) {
            e.preventDefault();
            var item = $(e.target);
            var form = $('<form action="'+"{{route('shuttle.menu.destroy',['menu' => '__id'])}}".replace('__id',item.data('id'))+'" method="post">'+
                '@csrf'+'@method("DELETE")'+'</form>');
            form.appendTo('body');
            form.submit();
        });
    </script>
@endpush
