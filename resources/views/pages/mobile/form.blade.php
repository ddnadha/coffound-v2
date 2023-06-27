@extends('layouts.mobile')

@section('title', 'Coffound')

@section('nav')
    <h6 style="margin-top: 5px">Tambahkan Cafe Baru</h6>
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body mb-4">
                <div class="col-12">
                    <form action="{{ url('mobile/caffee') }}" method="POST" class="mt-4 w-100" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="latlng" id="inputLatLong">
                        <div class="form-group mb-2">
                            <label class="mb-1" for="name">Nama Caffee</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group mb-2">
                            <label for="province" class="mb-1">Provinsi</label>
                            <select name="province" id="select_province" class="form-control select2">
                                @foreach ($province as $p)
                                    <option value="{{ $p->id }}">{{ ucfirst(strtolower($p->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="inputAddress">Kota / Kabupaten</label>
                            <select name="city" id="select_city" class="form-control select2">
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="inputAddress">Kecamatan</label>
                            <select name="district" id="select_district" class="form-control select2">
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="address" class="mb-1">Alamat Caffee</label>
                            <textarea class="form-control" name="address" id="address" rows="2"></textarea>
                            <div class="leaflet-map mt-2" id="map" style="height: 20vh;"></div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="address" class="mb-1">Deskripsi Caffee</label>
                            <textarea name="desc" id="autosize-demo" rows="3" class="form-control"
                                style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 83px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2 mb-2 btn-block">
                            Buat cafe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/autosize/autosize.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('js/fileupload.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.js') }}"></script>

    <script>
        $('#nav-item-open').addClass('nav-item-bottom-active')
        $(document).ready(function() {
            $('#select_province').select2()
            $('#select_city').select2()
            $('#select_district').select2()
            autosize($('#autosize-demo'));
            let latLong = undefined
            let marker = undefined
            @if (isset($data))
                latLong = [{{ $data->lat }}, {{ $data->lng }}]
                var map = L.map('map').setView(latLong, 15);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);
                marker = L.marker([
                    position.coords.latitude,
                    position.coords.longitude
                ], {
                    draggable: 'true'
                }).addTo(map);
                marker.on('move', function(param) {
                    latLong = [param.latlng.lat, param.latlng.lng]
                    $('#inputLatLong').val(JSON.stringify(latLong))
                })
            @else
                navigator.geolocation.getCurrentPosition(function(position) {
                    latLong = [position.coords.latitude, position.coords.longitude]
                    var map = L.map('map').setView([position.coords.latitude, position.coords.longitude],
                        15);
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(map);
                    marker = L.marker([
                        position.coords.latitude,
                        position.coords.longitude
                    ], {
                        draggable: 'true'
                    }).addTo(map);
                    $('#inputLatLong').val(JSON.stringify(latLong))
                    marker.on('move', function(param) {
                        latLong = [param.latlng.lat, param.latlng.lng]
                        $('#inputLatLong').val(JSON.stringify(latLong))
                    })
                });
            @endif

            if ($('#select_province').val()) {
                getCity($('#select_province').val())
            }

            $('#select_province').on('change', function() {
                getCity($(this).val())
            })
            $('#select_city').on('change', function() {
                getDistrict($(this).val())
            })
            $('#select_district').on('change', function() {
                console.log($(this).val())
            })
        })

        function getCity(province) {
            $('#select_city').html('');
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/geo/city') }}?province=${province}`,
                async: false,
                dataType: 'json',
                success: function(result) {
                    result.forEach(function(data) {
                        $('#select_city').append(new Option(data.name, data.id, false,
                            false)).trigger('change');
                    })
                }
            })
        }

        function getDistrict(city) {
            $('#select_district').html('');
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/geo/district') }}?city=${city}`,
                async: false,
                dataType: 'json',
                success: function(result) {
                    result.forEach(function(data) {
                        $('#select_district').append(new Option(data.name, data.id, false,
                            false)).trigger('change');
                    })
                }
            })
        }
    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fileupload.css') }}">
    <style>
        .main-content {
            padding-top: 60px !important;
        }
    </style>
@endpush
