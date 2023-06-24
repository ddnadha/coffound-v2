@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $cafe->name }}</h1>
        </div>
        <div class="col-md-12">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ asset($cafe->main_image) }}" height="100" style="object-fit: cover"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Kunjungan</div>
                                    <div class="profile-widget-item-value">{{ $cafe->visit->count() }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Ulasan</div>
                                    <div class="profile-widget-item-value">{{ $cafe->review->count() }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Rating</div>
                                    <div class="profile-widget-item-value">{{ $cafe->rating }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name text-dark font-weight-bold">
                                {{ $cafe->name }}
                            </div>
                            {{ $cafe->desc }}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    @include('components.owner-nav')
                    <div class="card">
                        <form method="post" action="{{ route('owner.cafe.update', $cafe) }}" class="needs-validation"
                            novalidate="">
                            <div class="card-header">
                                <h4>Edit Data Caffee</h4>
                            </div>
                            <div class="card-body">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label for="name">Nama Cafe</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ $cafe->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="address">Alamat Cafe</label>
                                    <input type="text" class="form-control" name="address" id="adress"
                                        value="{{ $cafe->address }}">
                                </div>
                                <div class="form-group">
                                    <label for="province" class="mb-1">Provinsi</label>
                                    <select name="province" id="select_province" class="form-control select2">
                                        @foreach ($province as $p)
                                            <option value="{{ $p->id }}"
                                                @if ($p->id == $cafe->district->regency->province_id) selected @endif>
                                                {{ ucfirst(strtolower($p->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Titik Lokasi</label>
                                    <input type="hidden" name="latlng" id="inputLatLong"
                                        value="{{ json_encode([$cafe->lat, $cafe->lng]) }}">
                                    <div class="leaflet-map mt-2" id="map" style="height: 40vh;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Kota / Kabupaten</label>
                                    <select name="city" id="select_city" class="form-control select2">
                                        <option value="{{ $cafe->district->regency_id }}">
                                            {{ ucfirst(strtolower($cafe->district->regency->name)) }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Kecamatan</label>
                                    <select name="district" id="select_district" class="form-control select2">
                                        <option value="{{ $cafe->district_id }}">
                                            {{ ucfirst(strtolower($cafe->district->name)) }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="mb-1">Deskripsi Caffee</label>
                                    <textarea name="desc" id="autosize-demo" rows="3" class="form-control"
                                        style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 83px;">{{ $cafe->desc }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/autosize/autosize.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#select_province').select2()
            $('#select_city').select2()
            $('#select_district').select2()
            autosize($('#autosize-demo'));
            let latLong = undefined
            let marker = undefined
            latLong = [{{ $cafe->lat }}, {{ $cafe->lng }}]
            var map = L.map('map').setView(latLong, 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            marker = L.marker(latLong, {
                draggable: 'true'
            }).addTo(map);
            marker.on('move', function(param) {
                latLong = [param.latlng.lat, param.latlng.lng]
                $('#inputLatLong').val(JSON.stringify(latLong))
            })

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
