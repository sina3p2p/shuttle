@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'გვერდები' => route('shuttle.page.index')], 'btn' => route('shuttle.page.create')])
@stop

@section('main')
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
                                    <th scope="col">სათაური</th>
                                    <th scope="col">ლინკი</th>
                                    <th scope="col">შექმნის დრო</th>
                                    <th scope="col">განახლების დრო</th>
                                    <th scope="col">აქტივობები</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pages as $page)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$page->title}}</td>
                                        <td>{{$page->url}}</td>
                                        <td>{{$page->created_at}}</td>
                                        <td>{{$page->updated_at}}</td>
                                        <td>
                                            <a href="{{route('shuttle.page.edit',$page->id)}}" class="btn btn-primary default">რედაქტირება</a>
                                            <button type="button" class="btn btn-danger default remove-item" data-id="{{$page->id}}">წაშლა</button>
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
            var form = $('<form action="'+"{{route('shuttle.page.destroy' , ['page' => '__id'])}}".replace('__id',item.data('id'))+'" method="post">'+
                '@csrf'+'<input type="hidden" name="_method" value="DELETE">'+'</form>');
            form.appendTo('body');
            form.submit();
        });
    </script>
@endpush
