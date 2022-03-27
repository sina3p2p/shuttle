@extends('shuttle::admin')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet"/>
@endpush

@section('breadcrumbs')
    @include('shuttle::includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('shuttle.index'), 'თარგმნა' => route('shuttle.translation.index')]])
@stop

@section('main')
    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalRight">სიტყვის დამატება</button>
    <div class="card mb-4">
        <div class="card-body ">
            <h5 class="mb-4">თარგმნა</h5>
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th>Key</th>
                    @foreach($strings as $key => $locale)
                        <th>{{$key}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach(data_get($strings,config('app.locale').'.common', []) as $key2 => $item)
                    <tr>
                        <td>{{$key2}}</td>
                        @foreach($strings as $key4 => $locale)
                            <td class="editable" data-local="{{$key4}}" data-name="{{$key2}}">@if(isset($strings[$key4]['common'][$key2])) {{$strings[$key4]['common'][$key2]}}@endif</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade modal-right show" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalRight">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('shuttle.translation.store')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">სიტყვის დამატება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input hidden name="lang" value="ka">
                        <div class="form-group">
                            <label>Key</label>
                            <input name="key" placeholder=" დასახელება" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>დასახელება</label>
                            <input name="value" placeholder="დასახელება" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">გაუქმება</button>
                        <button id="send" type="submit" class="btn btn-primary">დამატება</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script src="{{route('shuttle.assets','js/vendor/SimpleTableCellEditor.es6.min.js')}}"></script>
    <script>


        {{--$.ajaxSetup({--}}
        {{--    beforeSend: function(xhr, settings) {--}}
        {{--        settings.data += "&_token={{csrf_token()}}";--}}
        {{--    }--}}
        {{--});--}}

        // $('.editable').editable().on('hidden', function(e, reason){
        //     var locale = $(this).data('locale');
        //     if(reason === 'save'){
        //         $(this).removeClass('status-0').addClass('status-1');
        //     }
        //     if(reason === 'save' || reason === 'nochange') {
        //         var $next = $(this).closest('tr').next().find('.editable.locale-'+locale);
        //         setTimeout(function() {
        //             $next.editable('show');
        //         }, 300);
        //     }
        // });

        const editor = new SimpleTableCellEditor("myTable");

        editor.SetEditableClass("editable");

        $('#myTable').on("cell:edited", function (event) {
            $.ajax({
                method: "post",
                data: {
                    lang: $(event.element).data('local'),
                    key: $(event.element).data('name'),
                    value: event.newValue,
                },
                url: "{{route('shuttle.translation.store')}}",
                success: function () {
                    console.log('sadasdsa')
                }
            });
            // console.log($(event.element).data('name'))
            // console.log()
            console.log(`Cell edited : ${event.oldValue} => ${event.newValue}`);
        });

        function saveData() {
            $.ajax({
                method: "post",
                url: "{{route('shuttle.translation.store')}}"
            })
        }

    </script>
@endpush