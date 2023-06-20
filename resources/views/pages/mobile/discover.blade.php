@extends('layouts.mobile')

@section('title', 'Coffound')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
@endpush

@section('nav')
    <h6 style="margin-top: 5px">Temukan Cafe Disekitarmu</h6>
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                <div style="height: 100vh;">
                    <div class="leaflet-map" style="height: 100vh" id="map"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>

    <script>
        let latLong = undefined

        navigator.geolocation.getCurrentPosition(function(position) {
            latLong = [position.coords.latitude, position.coords.longitude]
            latLongTweaked = [position.coords.latitude, position.coords.longitude]
            latLongTweaked[0] = position.coords.latitude - 0.01

            var map = L.map('map').setView(latLongTweaked, 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);
            marker = L.marker(latLong, {
                draggable: false
            }).addTo(map);
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/cafe') }}?lat=${latLong[0]}&lng=${latLong[1]}`,
                async: false,
                dataType: 'json',
                success: function(result) {
                    console.log(result)
                    let _html = '';
                    $.each(result.data, function(i, val) {
                        marker = L.marker([val.lat, val.lng], {
                            draggable: false
                        }).addTo(map);
                        console.log(val.name.length)
                    })
                }
            });
        })
    </script>
@endpush
