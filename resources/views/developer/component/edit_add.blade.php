@extends('shuttle::admin')

@section('breadcrumbs')
    <div class="row">
        <div class="col-12">
            <div class="mb-2">
                <h1>@if($component->id){{$component->display_name}}@else New Component @endif</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.index')}}">მთავარი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('shuttle.component.index')}}">კომპონენტი</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">@if($component->id){{$component->display_name}}@else New Component @endif</a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="separator mb-5"></div>
        </div>
    </div>
@stop

@section('main')
    <div class="card">
        <div class="card-header pl-0 pr-0">
            <ul class="nav nav-tabs card-header-tabs ml-0 mr-0 nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#general-fill" role="tab" aria-controls="home-fill" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="messages-tab-fill" data-toggle="tab" href="#messages-fill" role="tab" aria-controls="messages-fill" aria-selected="false">Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="settings-tab-fill" data-toggle="tab" href="#settings-fill" role="tab" aria-controls="settings-fill" aria-selected="false">Code</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <form action="{{($component->id) ? route('shuttle.component.update',$component->id) : route('shuttle.component.store')}}" method="post">
                @csrf
                @if($component->id)
                    @method('PUT')
                @endif
                <div class="tab-content pt-1">
                    <div class="tab-pane active" id="general-fill" role="tabpanel" aria-labelledby="general-tab-fill">
                        <div class="form form-vertical">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="component-name">Component Name</label>
                                            <input type="text" id="component-name" class="form-control" name="name" placeholder="Name" value="{{$component->name}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="component-name">Component Display Name</label>
                                            <input type="text" id="component-name" class="form-control" name="display_name" placeholder="Name" value="{{$component->display_name}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="component-name">Component Icon</label>
                                            <input type="text" id="component-name" class="form-control" name="icon" placeholder="Name" value="{{$component->icon}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages-fill" role="tabpanel" aria-labelledby="messages-tab-fill">
                        <div id="app">

                            <input type="checkbox" v-model="fromDatabase" /> Load data from database
                            <button @click.prevent="addRow">Add</button>
                            <ul>
                                <textarea name="myData" hidden>@{{ myData }}</textarea>
                                <li v-for="item,index in data">
                                    <input :name="'data['+index+'][field]'" v-model="item.field">
                                    <select :name="'data['+index+'][type]'" v-model="item.type"><option v-for="type in types">@{{ type }}</option></select>
                                    <my-array-component v-if="item.type == 'array'" :item="item" :index="index" @on-add-click="addObjectToData" @on-remove-click="removeObjectFromData"></my-array-component>
                                    <input v-else v-model="item.display_name">
                                    {{-- <div v-if="item.type == 'model' || item.type == 'arrayModel'">
                                        ID:    <input @input="update(item.options, 'id', $event)" :value="item.options.id">
                                        KEY:   <input @input="update(item.options, 'field', $event)" :value="item.options.field">
                                        LABEL: <input @input="update(item.options, 'display_name', $event)" :value="item.options.display_name">
                                    </div> --}}
                                    <div v-if="item.type == 'c_relationship'">
                                        type:    <input @input="update(item.details, 'type', $event)" :value="item.details.type">
                                        key:    <input @input="update(item.details, 'key', $event)" :value="item.details.key">
                                        label:   <input @input="update(item.details, 'label', $event)" :value="item.details.label">
                                        column: <input @input="update(item.details, 'column', $event)" :value="item.details.column">
                                        model: <input @input="update(item.details, 'model', $event)" :value="item.details.model">
                                        scope: <input @input="update(item.details, 'scope', $event)" :value="item.details.scope">
                                        {{-- LABEL: <input @input="update(item.options, 'display_name', $event)" :value="item.options.display_name"> --}}
                                    </div>
                                    <button @click.prevent="removeRow(index)">Remove</button>
                                </li>
                            </ul>
                            <div v-if="fromDatabase">
                                <textarea name="myModelData">@{{ myModelData }}</textarea>
                                <select v-model="model.name">
                                    @foreach(getModels() as $m)
                                        <option value="{{$m}}">{{$m}}</option>
                                    @endforeach
                                </select>
                                <button @click.prevent="addModelRow">Add</button>
                                <ul>
                                    <li v-for="item,index in model.conditions">
                                        <input v-model="item.field">
                                        <input v-model="item.type">
                                        <input v-model="item.display_name">
                                        <button @click.prevent="removeModelRow(index)">Remove</button>
                                    </li>
                                </ul>
                                <input v-model="model.order">
                                <input v-model="model.scope">
                                <input v-model="model.limit">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="settings-fill" role="tabpanel" aria-labelledby="settings-tab-fill">
                        <pre id="editor"></pre>
                    </div>
                    <textarea name="html" hidden>{{$component->content}}</textarea>
                </div>
                <button type="submit" class="card-link btn btn-primary mt-2">Save</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{route('shuttle.assets','js/vendor/ace/ace.js')}}"></script>
    <style type="text/css" media="screen">
        #editor {
            margin: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 700px;
        }
    </style>
    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/twilight");
        editor.session.setMode("ace/mode/html");
        var textarea = $('textarea[name="html"]').hide();
        editor.getSession().setValue(textarea.val());
        editor.getSession().on('change', function(){
            textarea.val(editor.getSession().getValue());
        });

        Vue.mixin({
            data: function() {
                return {
                    get inputTypes() {
                        // return  ['string','array','image', 'html', 'map', 'model', 'arrayModel'];
                        return  ['text','array','image', 'rich_text_box', 'map', 'model', 'arrayModel', 'c_relationship'];
                    }
                }
            }
        });

        Vue.component('my-model-component', {
            props: ['item', 'index'],
            data: function () {
                return {
                    count: 0
                }
            },
            template: '<button @click.prevent="$emit(\'on-add-click\', item)">Add</button>' +
                '<li v-for="object,objIndex in item.children">' +
                '<input :name="\'data[\'+index+\'][object][\'+objIndex+\'][field]\'" v-model="mocdl.field">\n' +
                '<input :name="\'data[\'+index+\'][object][\'+objIndex+\'][field]\'" v-model="mocdl.field">\n' +
                '<input :name="\'data[\'+index+\'][object][\'+objIndex+\'][field]\'" v-model="mocdl.field">\n' +
                '<select :name="\'data[\'+index+\'][object][\'+objIndex+\'][type]\'" v-model="object.type"><option v-for="type in inputTypes">@{{ type }}</option></select>\n' +
                '<my-array-component v-if="object.type == \'array\'" :item="object" :index="objIndex" @on-add-click="addClick" @on-remove-click="removeClick"></my-array-component>\n' +
                '<input v-else v-model="object.display_name">' +
                '<button @click.prevent="$emit(\'on-remove-click\', item, objIndex)">Remove</button>\n' +
                '</li></ul>',
            methods: {
                addClick(obj)
                {
                    this.$emit('on-add-click',obj);
                },
                removeClick(obj,key)
                {
                    this.$emit('on-remove-click',obj, key);
                }
            }
        });

        Vue.component('my-array-component', {
            props: ['item', 'index'],
            data: function () {
                return {
                    count: 0
                }
            },
            template: '<ul><button @click.prevent="$emit(\'on-add-click\', item)">Add</button>' +
                '<li v-for="object,objIndex in item.children">' +
                '<input :name="\'data[\'+index+\'][object][\'+objIndex+\'][field]\'" v-model="object.field">\n' +
                '<select :name="\'data[\'+index+\'][object][\'+objIndex+\'][type]\'" v-model="object.type"><option v-for="type in inputTypes">@{{ type }}</option></select>\n' +
                '<my-array-component v-if="object.type == \'array\'" :item="object" :index="objIndex" @on-add-click="addClick" @on-remove-click="removeClick"></my-array-component>\n' +
                '<input v-else v-model="object.display_name">' +
                // '<input @input="update(object, \'value\', $event)" :value="object.value">\n' +
                '<button @click.prevent="$emit(\'on-remove-click\', item, objIndex)">Remove</button>\n' +
                '</li></ul>',
            methods: {
                addClick(obj)
                {
                    this.$emit('on-add-click',obj);
                },
                removeClick(obj,key)
                {
                    this.$emit('on-remove-click',obj, key);
                }
            }
        });

        var myModel = {
            name: '',
            order: '',
            conditions: [],
            limit: 0,
        };

        @if($component->model)
            myModel = @json($component->model_settings['model']);
            @endif

        var vm = new Vue({
                el: '#app',
                computed: {
                    myData(){
                        return JSON.stringify(this.data)
                    },
                    myModelData(){
                        return JSON.stringify({model: this.model})
                    }
                },
                data: {
                    fromDatabase: @if($component->model) true @else false @endif,//false,
                    types: ['text','array','image', 'rich_text_box', 'map', 'model', 'arrayModel', 'c_relationship'],
                    model: myModel,
                    data: @json($component->rows ?? [])
                },
                methods: {
                    update: function(obj, prop, event) {
                        Vue.set(obj, prop, event.target.value);
                    },
                    addRow(){
                        this.data.push({
                            field: '',
                            type: 'text',
                            display_name: '',
                            details: {},
                            children: [],
                        })
                    },
                    addModelRow(){
                        this.model.conditions.push({
                            field: '',
                            type: 'where',
                            display_name: '',
                        })
                    },
                    removeModelRow(key){
                        this.model.conditions.splice(key,1)
                    },
                    removeRow(key){
                        this.data.splice(key,1)
                    },
                    removeObjectFromData(obj,key2,key){
                        obj.children.splice(key2,1)
                    },
                    addObjectToData(obj) {
                        obj.children.push({
                            field: '',
                            type: 'text',
                            children: [],
                            display_name: '',
                        })
                    },
                    update: function(obj, prop, event) {
                        Vue.set(obj, prop, event.target.value);
                    },
                    showResult(){
                        console.log(this.model)
                    }
                },
                makeKey(length) {
                    var result           = '';
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    var charactersLength = characters.length;
                    for ( var i = 0; i < length; i++ ) {
                        result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    }
                    return result;
                }
            })
    </script>
@endpush
