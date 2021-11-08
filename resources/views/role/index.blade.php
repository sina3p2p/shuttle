@extends('shuttle::admin')

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'გვერდები' => route('shuttle.page.index')], 'btn' => route('shuttle.roles.create')])
@stop

@section('main')
    <div class="content-body">
        <div class="row" id="table-responsive">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">სათაური</th>
                                        <th scope="col">შექმნის დრო</th>
                                        <th scope="col">განახლების დრო</th>
                                        <th scope="col">აქტივობები</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roles as $r)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$r->name}}</td>
                                            <td>{{$r->created_at}}</td>
                                            <td>{{$r->updated_at}}</td>
                                            <td>
                                                <a href="{{route('shuttle.roles.edit',$r)}}" class="btn btn-primary default">რედაქტირება</a>
                                                <button type="button" class="btn btn-danger default remove-item" data-id="{{$r->id}}">წაშლა</button>
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
