@push('css-vendors')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
@endpush

@section('main')
    <div class="content-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dd">
                            <ol class="dd-list"></ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    <textarea id="nestable_data" hidden>@json($menu->where('pid',0)->load('items.recursiveChildren')->sortBy(function ($product, $key) {return $product->ord;})->values())</textarea>--}}
    <textarea id="nestable_data" hidden>@json($dataTypeContent)</textarea>
    <form action="{{route('shuttle.menu.sort')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="button" class="btn mb-1 mt-1 btn-primary btn-lg btn-block waves-effect waves-light save-data">შენახვა</button>
                </div>
            </div>
        </div>
    </form>
@stop

@push('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script src="{{route('shuttle.assets','js/vendor/select2.full.js')}}"></script>
    <script>
        $(document).ready(function () {

            var nested = $('.dd');
            nested.nestable({
                itemRenderer: function(item_attrs, content, children, options, item) {
                    var item_attrs_string = $.map(item_attrs, function(value, key) {
                        if(key === 'data-info'){
                            return " ";
                        }
                        return ' ' + key + '="' + value + '"';
                    }).join(' ');
                    var html = '<' + options.itemNodeName + item_attrs_string + '>';
                    html += '<' + options.handleNodeName + ' class="' + options.handleClass + '">';
                    html += '<' + options.contentNodeName + ' class="' + options.contentClass + '">';
                    html += item.name;
                    html += '<div class="washla">';
                    if(!item.info.menuable){
                        delete item.info.children;
                        html += '<a href="'+item.id+'" class="edit-item" data-info="'+JSON.stringify(item.info).replace(/"/g, '&quot;')+'">რედაქტირება</a> / ';
                    }
                    html += '<a href="#" class="remove-item">წაშლა</a></div>';
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
                var nestedItem = {"id": item.id ,"name":(item.menuable ? item.menuable.title : item.title), "info": item, "children":[]};
                if (item.children) {
                    nestedItem["children"] = [];
                    $.each(item.children, function (index, sub) {
                        nestedItem.children.push(buildItem(sub))
                    });
                }
                return nestedItem;
            }

            $.each(JSON.parse(obj), function (index, item) {
                nested.nestable('add',buildItem(item) );
            });

            $('.dd-empty').remove();

            $('form.add-menu').on('submit',function (e) {
                e.preventDefault();
                var post_url = $(e.target).attr("action"); //get form action url
                var request_method = $(e.target).attr("method"); //get form GET/POST method
                var form_data = $(e.target).serializeArray(); //Encode form elements for submission
                var menu_name = $("#menu-name-input");
                var menu_id_el = $("#menu-id-input");
                form_data.push({name: "name", value: menu_name.val()});
                $.ajax({
                    url : post_url,
                    type: request_method,
                    data :  $.param(form_data),
                    success(response){ //
                        nested.nestable('add',buildItem(response) );
                        menu_name.prop("disabled", true);
                        menu_id_el.val(response.menu_id);
                    }
                })
            });
            // .remove-item
            $(document).on('mousedown','a.remove-item',function (e) {
                e.preventDefault();
                var item = $(e.target).closest('li');
                $.ajax({
                    url : '/mygo/menu/items/'+item.data('id'),
                    type: 'POST',
                    data : {
                        _method: "DELETE",
                    },
                    success(response){
                        item.remove()
                    }
                })
            });

            $(document).on('mousedown','a.edit-item',function (e) {
                var button = $(this);
                var recipient = button.data('info');
                var action = "{{route('shuttle.scaffold_interface.edit',['scaffold_interface' => $scaffold_interface, 'id' => '__id' ])}}".replace("__id",recipient.id);
                window.location = action;
            });

            $("button.save-data").on('click',function (e) {
                e.preventDefault();
                let form = $('<form action="{{route("shuttle.scaffold_interface.sort",$scaffold_interface)}}" method="post">@csrf<textarea name="sort" hidden>'+JSON.stringify(nested.nestable('serialize'))+'</textarea></form>');
                $('body').append(form);
                form.submit()
            });
        });
    </script>
@endpush
