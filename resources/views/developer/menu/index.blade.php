@extends('shuttle::admin')

@push('css-vendors')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
<link rel="stylesheet" href="{{route('shuttle.assets', 'css/vendor/select2.min.css')}}" />
@endpush

@section('main')
<div class="content-body">
    <section id="accordion">
        <div class="row">
            <div class="col-md-4">
                <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <fieldset class="form-label-group">
                                        <input type="text" class="form-control" id="menu-name-input" placeholder="Menu Name" value="{{$menu->name}}" @if($menu->name) disabled
                                        @endif>
                                    </fieldset>
                                </div>
                                <div class="col-12">
                                    <div class="accordion-default collapse-bordered">
                                        @foreach($menuable as $m)
                                        <div class="card collapse-header">
                                            <div id="heading{{$loop->index}}" class="card-header collapse-header" data-toggle="collapse" role="button" data-target="#accordion{{$loop->index}}" aria-expanded="false" aria-controls="accordion{{$loop->index}}">
                                                <span class="lead collapse-title">{{$m["display_name_plural"]}}</span>
                                            </div>
                                            <div id="accordion{{$loop->index}}" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading{{$loop->index}}" class="collapse">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <form class="add-menu" action="{{route('shuttle.menu.store')}}" method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <input name="menuable_type" value="{{$m[" model"]}}" hidden>
                                                                <div class="col-12">
                                                                    <select class="form-control select2-single" id="basicSelect" name="menuable_id">
                                                                        <option value="">აირჩიეთ კონკრეტული</option>
                                                                        @foreach($m["data"] ?? [] as $d)<option value="{{$d->id}}">{{$d->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-12">
                                                                    <button type="submit" class="btn mb-1 mt-1 btn-outline-primary btn-lg btn-block waves-effect waves-light">საიტზე
                                                                        გამოჩენა</button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="card collapse-header">
                                            <div id="heading2" class="card-header collapse-header" data-toggle="collapse" role="button" data-target="#accordion2" aria-expanded="false" aria-controls="accordion2">
                                                <span class="lead collapse-title">შექმენით თქვენით</span>
                                            </div>
                                            <div id="accordion2" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading2" class="collapse" aria-expanded="false">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <form class="add-menu" action="{{route('shuttle.menu.store')}}" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="custom-label-ka">სახელი</label>
                                                                <input name="ka[title]" class="form-control" id="custom-label-ka">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="custom-label-icon">სახელი</label>
                                                                <input name="icon" class="form-control" id="custom-label-icon">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="custom-label-ka">ლინკი</label>
                                                                <input name="url" class="form-control" id="custom-label-ka">
                                                            </div>
                                                            <button type="submit" class="btn mb-1 mt-1 btn-outline-primary btn-lg btn-block waves-effect waves-light">საიტზე
                                                                გამოჩენა</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{route('shuttle.menu.sort')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input id="menu-id-input" name="menu_id" value="{{$menu->id}}" hidden>
                                                        <button id="save-data" type="button" class="btn mb-1 mt-1 btn-primary btn-lg btn-block waves-effect waves-light">შენახვა</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
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
{{-- <textarea id="nestable_data"
    hidden>@json($menu->where('pid',0)->load('items.recursiveChildren')->sortBy(function ($product, $key) {return $product->ord;})->values())</textarea>--}}
<textarea id="nestable_data" hidden>@json($menu_items)</textarea>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf @method('put')
                    @foreach(config('translatable.locales') as $translate)
                    <div class="form-group">
                        <label for="custom-label-ka">სახელი {{$translate}}</label>
                        <input name="{{$translate}}[title]" class="form-control" id="custom-label-ka">
                    </div>
                    @endforeach
                    <div class="form-group">
                        <label for="custom-label-icon">ICON</label>
                        <input name="icon" class="form-control" id="custom-label-icon">
                    </div>
                    <div class="form-group">
                        <label for="custom-label-ka">ლინკი</label>
                        <input name="url" class="form-control" id="custom-label-ka">
                    </div>
                    <button type="submit" class="btn mb-1 mt-1 btn-outline-primary btn-lg btn-block waves-effect waves-light">საიტზე
                        გამოჩენა</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<script src="{{route('shuttle.assets','js/vendor/select2.full.js')}}"></script>
<script>
    $(document).ready(function() {

        var nested = $('.dd');
        nested.nestable({
            itemRenderer: function(item_attrs, content, children, options, item) {
                var item_attrs_string = $.map(item_attrs, function(value, key) {
                    if (key === 'data-info') {
                        return " ";
                    }
                    return ' ' + key + '="' + value + '"';
                }).join(' ');
                var html = '<' + options.itemNodeName + item_attrs_string + '>';
                html += '<' + options.handleNodeName + ' class="' + options.handleClass + '">';
                html += '<' + options.contentNodeName + ' class="' + options.contentClass + '">';
                html += item.name;
                html += '<div class="washla">';
                if (!item.info.menuable) {
                    delete item.info.children;
                    html += '<a href="' + item.id + '" class="edit-item" data-info="' + JSON.stringify(item.info).replace(/"/g, '&quot;') + '">რედაქტირება</a> / ';
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
            var nestedItem = {
                "id": item.id,
                "name": (item.menuable ? item.menuable.name : item.title),
                "info": item,
                "children": []
            };
            if (item.children) {
                nestedItem["children"] = [];
                $.each(item.children, function(index, sub) {
                    nestedItem.children.push(buildItem(sub))
                });
            }
            return nestedItem;
        }

        $.each(JSON.parse(obj), function(index, item) {
            nested.nestable('add', buildItem(item));
        });

        $('.dd-empty').remove();

        $('form.add-menu').on('submit', function(e) {
            e.preventDefault();
            var post_url = $(e.target).attr("action"); //get form action url
            var request_method = $(e.target).attr("method"); //get form GET/POST method
            var form_data = $(e.target).serializeArray(); //Encode form elements for submission
            var menu_name = $("#menu-name-input");
            var menu_id_el = $("#menu-id-input");
            form_data.push({
                name: "name",
                value: menu_name.val()
            });
            $.ajax({
                url: post_url,
                type: request_method,
                data: $.param(form_data),
                success(response) { //
                    nested.nestable('add', buildItem(response));
                    menu_name.prop("disabled", true);
                    menu_id_el.val(response.menu_id);
                }
            })
        });
        // .remove-item
        $(document).on('mousedown', 'a.remove-item', function(e) {
            e.preventDefault();
            var item = $(e.target).closest('li');
            $.ajax({
                url: '/mypanel/menu/items/' + item.data('id'),
                type: 'POST',
                data: {
                    _method: "DELETE",
                },
                success(response) {
                    item.remove()
                }
            })
        });

        $(document).on('mousedown', 'a.edit-item', function(e) {
            var button = $(this);
            var recipient = button.data('info');
            var modal = $('#exampleModal');
            var action = "{{route('shuttle.menuItem.update', ['menu_item' => '__id'])}}".replace("__id", recipient.id);
            for (var t in recipient.translations) {
                modal.find('.modal-body input[name="' + recipient.translations[t].locale + '[title]"]').val(recipient.translations[t].title)
            }
            modal.find('.modal-body form').attr('action', action);
            modal.find('.modal-body input[name="url"]').val(recipient.url);
            modal.find('.modal-body input[name="icon"]').val(recipient.icon);
            modal.modal('show');
        });

        $("button#save-data").on('click', function(e) {
            e.preventDefault();
            let form = $(this).parents('form');
            form.append('<textarea name="data" hidden>' + JSON.stringify(nested.nestable('serialize')) + '</textarea>');
            form.submit()
        });
    });
</script>
@endpush