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
    <div class="modal fade" tabindex="-1" role="dialog" id="cafeModal">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center" role="dialog">
                <div class="modal-content">
                    <div class="modal-body rounded">
                        <div class="row">
                            <div class="col-12">
                                <img class="img-modal-cafe img-fluid" alt=""
                                    style="width: 100%; margin-bottom: 1rem; border-radius: 10px; max-height: 250px; object-fit:cover">
                            </div>
                            <div class="col-10">
                                <h3 class="text-dark text-cafe"></h3>
                            </div>
                            <div class="col-2 text-center pt-1">
                                <a class="text-url" target="_blank" href="">
                                    <i class="fab fa-whatsapp text-success" style="font-size: 1.5rem !important"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1 pl-3 pr-0">
                                <i class="fas fa-lg fa-location-dot text-primary"></i>
                            </div>
                            <div class="col-11 px-2 text-100rem text-address">
                            </div>
                            <div class="col-1 pl-3 pr-0 pt-1">
                                <i class="fas fa-lg fa-star text-warning"></i>
                            </div>
                            <div class="col-11 px-2 pt-1 text-100rem text-rating">
                            </div>
                        </div>
                        <div class="text-desc text-container w-80 mt-3 mb-3" id="text-desc-parent" style="font-size: 14px;">
                        </div>
                        <a href="" class="btn btn-primary btn-block btn-icon btn-cafe">
                            <i class="fas fa-external-link mr-1"></i> Selengkapnya tentang kafe ini
                        </a>
                    </div>
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

        function showRestoModal(id) {
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/cafe') }}/` + id,
                async: false,
                dataType: 'json',
                success: function(result) {

                    if (result.status) {
                        console.log(result)
                        $('.img-modal-cafe').attr('src', result.data.img)
                        $('.text-cafe').html(result.data.name)
                        $('.text-address').html(result.data.address)
                        $('.text-rating').html(result.data.rating)
                        $('.text-url').attr('href', result.data.whatsapp_url)
                        $('.text-desc').html(result.data.desc)
                        $('.btn-cafe').attr('href', result.data.url)
                        $('#cafeModal').modal('show')
                    }
                }
            });
        }


        navigator.geolocation.getCurrentPosition(function(position) {
            latLong = [position.coords.latitude, position.coords.longitude]
            latLongTweaked = [position.coords.latitude, position.coords.longitude]
            latLongTweaked[0] = position.coords.latitude - 0.01

            var map = L.map('map').setView(latLongTweaked, 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap',
            }).addTo(map);
            marker = L.marker(latLong, {
                draggable: false,
                alt: 'Lokasi Anda'
            }).addTo(map).bindPopup('Lokasi Anda Saat ini');
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/cafe') }}?lat=${latLong[0]}&lng=${latLong[1]}`,
                async: false,
                dataType: 'json',
                success: function(result) {
                    $.each(result.data, function(i, val) {
                        marker = L.marker([val.lat, val.lng], {
                            draggable: false,
                            alt: val.name,
                            data: val.id
                        }).addTo(map);

                        marker.on('click', function(e) {
                            var markerData = this.options.data;
                            showRestoModal(markerData)
                        })
                    })
                }
            });
        })
    </script>
@endpush
@push('style')
    <style>
        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
            pointer-events: none;
        }

        .vertical-align-center {
            /* To center vertically */
            display: table-cell;
            vertical-align: middle;
            pointer-events: none;
        }

        .navbar-bottom {
            display: none !important
        }

        .nav-link {
            display: none !important
        }

        .btn-back-nav {
            display: block !important
        }

        .text-container {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Number of lines to show */
            -webkit-box-orient: vertical;
            line-height: 1.25rem !important
        }
    </style>
@endpush
