<div class="row">
    <div class="col-12">
        <div class="card d-flex mb-4">
            <div class="d-flex flex-grow-1 min-width-zero">
                <div
                    class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                    <a href="#" class="list-item-heading mb-0 truncate w-80 mb-1 mt-1" data-toggle="collapse"
                        data-target="#q1" aria-expanded="true" aria-controls="q1">გვერდის პარამეტრები</a>
                </div>
                <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                    <button class="btn btn-outline-primary icon-button rotate-icon-click rotate" type="button"
                        data-toggle="collapse" data-target="#q1" aria-expanded="true" aria-controls="q1">
                        <i class="simple-icon-arrow-down with-rotate-icon"></i>
                    </button>
                </div>
            </div>
            <div class="question-collapse collapse @if($add) show @endif" id="q1">
                <div class="card-body pt-0">
                    <form
                        action="{{ ($add) ? route('shuttle.page.store',['lang' => $lang]) : route('shuttle.page.update',['page' => $page->id, 'lang' => $lang])}}"
                        method="post">
                        @csrf
                        @if(!$add)
                        @method('put')
                        @endif
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="page-title-input">გვერდის მისამართი</label>
                                <input id="page-title-input" class="form-control" name="{{$lang}}[title]"
                                    placeholder="გთხოვთ შეიყვანოთ გვერდის სათაური"
                                    value="{{optional($page->translate($lang))->title}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="page-type-input">მოკლე აღწერა (Seo)</label>
                                <select id="page-type-input" class="form-control" name="type_id">
                                    <option value="0">Static page</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}" @if($page->type_id == $type->id) selected
                                        @endif>{{$type->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="page-keywords-input">მოკლე აღწერა (Seo)</label>
                                <input id="page-keywords-input" class="form-control" name="{{$lang}}[keywords]"
                                    placeholder="გთხოვთ შეიყვანოთ გვერდის მოკლე აღწერა"
                                    value="{{optional($page->translate($lang))->keywords}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="page-description-input">გვერდის ქივორდები (Seo)</label>
                                <input id="page-description-input" class="form-control" name="{{$lang}}[description]"
                                    placeholder="გთხოვთ შეიყვანოთგვერდის ქივორდები"
                                    value="{{optional($page->translate($lang))->description}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>გვერდის ფოტოსურათი (og:image)</label>
                                <image-input name="image" @if(isset($page->image))
                                    path="{{ $page->image }}" preview="{{ Storage::url($page->image) }}"
                                    @endif>
                                </image-input>
                            </div>
                        </div>
                        <div class="separator mb-4"></div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">შენახვა</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row mb-4 sortable">
            @if($add)
            <div class="col-12">
                <div class="alert alert-warning">After save page u can add here how many component u want</div>
            </div>
            @else
            @foreach($page->components as $component)
            <div class="col-md-3 col-lg-4 col-sm-4 col-6 mt-2" id="{{$component->pivot->id}}">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('shuttle.user_component.delete',['page_component' => $component->pivot->id])}}"
                            class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <i class="{{$component->icon}}"></i>
                        <p class="card-text font-weight-semibold mb-0 cname">{{$component->display_name}}</p>
                        <a href="{{route('shuttle.user_component',$component->pivot->id)}}"
                            class="btn btn-sm btn-outline-primary ">რედაქტირება</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
<media-library-modal upload-url="{{route('shuttle.media.upload')}}"></media-library-modal>

@push('js')
<script src="{{route('shuttle.assets','js/vendor/jquery-ui.min.js')}}"></script>
<script>
    $( ".sortable" ).sortable({
            revert: true,
            update: function (event, ui) {
                let data = $(event.target).sortable("toArray");
                sortComponent(data);
            }
        });

        $("a.close").on('click',function (e) {
            e.preventDefault();
            let form = $('<form action="'+$(this).attr('href')+'" method="post">'+
                '@csrf'+'@method("DELETE")'+'</form>');
            form.appendTo('body');
            form.submit();
        });

        function sortComponent(data) {
            let frmData = new FormData();
            frmData.append('data',data);
            $.ajax({
                type: "post",
                url: "{{route('shuttle.component.sort')}}",
                data: {data: data},
                success: function () {
                    showNotification('top', 'right', "success", "Saved");
                }
            });
        }
</script>
@endpush