<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="{{$setting['key']}}__{{$loop->index}}">{{data_get($setting,'value')}}</label>
    <div class="col-sm-10">
        <div id="map" data-lat="{{data_get($items,$setting['key']."-lat")}}" data-lng="{{data_get($items,$setting['key']."-lng")}}" style="height: 500px"></div>
{{--        <input id="{{$setting['key']}}__{{$loop->index}}" class="form-control" name="{{$setting['key']}}lat" value="{{data_get($c_setting,$setting['key']."lat")}}" hidden>--}}
{{--        <input id="{{$setting['key']}}__{{$loop->index}}" class="form-control" name="{{$setting['key']}}lng" value="{{data_get($c_setting,$setting['key']."lng")}}" hidden>--}}
    </div>
</div>
{{--<input name="lat" id="lat" type="text" hidden>--}}
{{--<input name="lng" id="lng" type="text" hidden>--}}

@push('js')
    <style>
        .bootstrap-tagsinput input {
            width: 50%!important;
        }
        .bootstrap-tagsinput {
            max-height: 50px;
            overflow: hidden;
        }
    </style>
    <script>
        var map;
        function initMap() {
            /*map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            */
            let mymarker;
            const element = document.getElementById("map");
            const options = {
                zoom: 3,
                center: new google.maps.LatLng(51.501527,-0.1921837)
            };
            const map = new google.maps.Map(element, options);
            var $mapElement = $("#map");
            if($mapElement.data('lat') && $mapElement.data('lng')) {
                mymarker = new google.maps.Marker({
                    position: new google.maps.LatLng($mapElement.data('lat'),$mapElement.data('lng')),
                    map: map
                });
            }

            map.addListener('click', function(event) {
                if (mymarker != null) {
                    mymarker.setMap(null);
                }
                mymarker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });
                $('input[name={{$setting["key"]}}-lat]').val(event.latLng.lat());
                $('input[name={{$setting["key"]}}-lng]').val(event.latLng.lng());
            });
        }

        $('#submit-button').click(function () {
            $("#data-form").submit();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"
            async defer></script>
@endpush
