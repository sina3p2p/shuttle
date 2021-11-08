@extends('layouts.admin')

@push('css-vendors')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/vendors/extensions/dragula.min.css')}}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/plugins/extensions/drag-and-drop.css')}}">
@endpush

@section('breadcrumbs')
    @include('admin.includes.breadcrumbs', ['breadCrumbs' => ['მთავარი' => route('admin.index'), $scaffold_interface->display_name_plural => route('admin.scaffold_interface.index',$scaffold_interface)], 'btn' => route('admin.scaffold_interface.create',$scaffold_interface)])
@stop

@section('main')
    {{--    @include('admin.includes.breadcrumbs',['title' => 'Menus', 'route' => false])--}}
    <div class="content-body">
        <section id="accordion">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="w-100 d-flex justify-content-between align-items-center mb-3">
                                <h5>პროდუქციის კატეგორიები</h5>
                                <form action="{{route('admin.scaffold_interface.sort',$scaffold_interface)}}" method="post">
                                    @csrf
                                    <button id="save-data2" type="button" class="btn mb-1 mt-1 btn-primary btn-lg btn-block waves-effect waves-light">შენახვა</button>
                                </form>
                            </div>
                            <!-- /.w-100 d-flex justify-content-center align-items-center -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="dd">
                                        <ol class="dd-list"></ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    </div>

    <textarea id="nestable_data" hidden>@json($dataTypeContent->where('pid',0)->load('recursiveChildren')->sortBy(function ($product, $key) {return $product->ord;})->values())</textarea>
@stop

@push('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script>
        $(document).ready(function () {

            var nested = $('.dd');
            nested.nestable({
                itemRenderer: function(item_attrs, content, children, options, item) {
                    var item_attrs_string = $.map(item_attrs, function(value, key) {
                        return ' ' + key + '="' + value + '"';
                    }).join(' ');
                    var html = '<' + options.itemNodeName + item_attrs_string + '>';
                    html += '<' + options.handleNodeName + ' class="' + options.handleClass + '">';
                    html += '<' + options.contentNodeName + ' class="' + options.contentClass + '">';
                    html += item.name;
                    html += '<div class="washla"><a class="edit-item" href="'+"{{route('admin.scaffold_interface.edit',['scaffold_interface' => $scaffold_interface, 'id' => '__id'])}}".replace('__id',item.id)+'" class="">რედაქტირება</a> / <a href="#" class="remove-item">წაშლა</a></div>';
                    html += '</' + options.contentNodeName + '>';
                    html += '</' + options.handleNodeName + '>';
                    html += children;
                    html += '</' + options.itemNodeName + '>';

                    return html;

                }
            });

            var obj = $('#nestable_data').val();

            var output = '';

            function buildItem(item) {
                var nestedItem = {"id": item.id ,"name": item.title, "children":[]};
                if (item.recursive_children) {

                    nestedItem["children"] = [];
                    $.each(item.recursive_children, function (index, sub) {
                        nestedItem.children.push(buildItem(sub))
                    });
                }
                return nestedItem;
            }


            $.each(JSON.parse(obj), function (index, item) {
                nested.nestable('add',buildItem(item) );
            });

            $('.dd-empty').remove();

            $(document).on('mousedown','a.remove-item',function (e) {
                e.preventDefault();
                var item = $(e.target).closest('li');
                var form = $('<form action="'+"{{route('admin.scaffold_interface.destroy',['scaffold_interface' => $scaffold_interface, 'id' => '__id'])}}".replace('__id',item.data('id'))+'" method="post">'+
                    '@csrf'+'@method("DELETE")'+'</form>');

                form.appendTo('body');
                form.submit();
                // var item = $(e.target).closest('li');
                // $.ajax({
                //     url : '/mygo/menu/items/'+item.data('id'),
                //     type: 'POST',
                //     data : {
                //         _method: "DELETE",
                //     },
                //     success(response){ //
                //         item.remove()
                //         // nested.nestable('add', response);
                //     }
                // })
            });

            $(document).on('mousedown','a.edit-item',function (e) {
                e.preventDefault();
                window.location.href = $(this).attr('href')

            });
            // $( "#handle-list-1" ).sortable({
            //     handle: ".handle"
            // });
            // dragula([document.getElementById("handle-list-1")], {
            //     moves: function (el, container, handle) {
            //         return handle.classList.contains('handle');
            //     }
            // });
            $("button#save-data2").on('click',function (e) {
                e.preventDefault();
                let form = $(this).parents('form');
                form.append('<textarea name="sort">'+JSON.stringify(nested.nestable('serialize'))+'</textarea>');
                form.submit()
                // console.log(nested.nestable('serialize'));
            });
        });


    </script>

@endpush


<style>
    #save-data2 {
        margin-top:0!important;
    }

    .dd-collapse {
        display:none;
    }
</style>
