@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'ნავიგაცია' => route('shuttle.menu.index')], 'btn' => route('shuttle.menu.create')])
@stop

@section('main')
    {{--@include('admin.includes.breadcrumbs',['title' => 'Pages', 'route' => 'admin.page'])--}}
    <div class="content-body">
        <div class="row" id="table-responsive">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ნავიგაციის დასახელბა</th>
                                        <th scope="col">შექმნილია</th>
                                        <th scope="col">განახლებულია</th>
                                        <th scope="col">აქტივობები</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($menus as $menu)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$menu->name}}</td>
                                            <td>{{$menu->created_at}}</td>
                                            <td>{{$menu->updated_at}}</td>
                                            <td>
                                                <a href="{{route('shuttle.menu.edit',$menu)}}" class="btn btn-primary default">რედაქტირება</a>
                                                <button type="button" class="btn btn-danger default remove-item" data-id="{{$menu->id}}">წაშლა</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

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
