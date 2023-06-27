@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $cafe->name }}</h1>
        </div>
        <div class="col-md-12">
            @include('components.owner-nav')
            <div class="row mt-sm-4">
                <div class="col-6 col-md-6 col-lg-6">

                    <div class="card">
                        <form method="post" action="{{ route('owner.cafe.update', $cafe) }}" class="needs-validation"
                            novalidate="">
                            <div class="card-header">
                                <h4>Edit Data Caffee</h4>
                                <div class="card-header-action">
                                    @if ($cafe->status == 'deactive')
                                        <a href="{{ route('owner.cafe.activate', $cafe) }}" class="btn btn-success">
                                            <i class="fas fa-power-off mr-1"></i>
                                            Aktivasi Kafe
                                        </a>
                                    @else
                                        <a href="{{ route('owner.cafe.activate', $cafe) }}" class="btn btn-warning">
                                            <i class="fas fa-power-off mr-1"></i>
                                            Deaktivasi Kafe
                                        </a>
                                    @endif
                                    @if ($cafe->deletion == null or $cafe->deletion->status != 'pending')
                                        <a data-toggle="modal" data-target="#deletionModal"
                                            class="btn btn-danger text-white"><i class="fas fa-trash mr-1 "
                                                style="cursor: pointer"></i>Hapus Kafe</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                @php
                                    $pending = ($cafe->deletion and $cafe->deletion->status == 'pending');
                                    $p1 = ($cafe->deletion and $cafe->deletion->status != 'pending');
                                    $p2 = ($cafe->activation and $cafe->activation->status != 'pending');
                                @endphp
                                @if ($pending)
                                    <div class="alert alert-warning">
                                        <div class="alert-title">Pengajuan Penghapusan Kafemu sedang ditinjau</div>
                                        <p class="mb-0" style="line-height: 1.25rem;">
                                            Silahkan tunggu konfirmasi selanjutnya dari admin
                                        </p>
                                    </div>
                                @endif
                                @if ($cafe->status == 'suspended')
                                    <div class="alert alert-warning">
                                        <div class="alert-title">Kafemu telah disuspend</div>
                                        <p
                                            style="line-height: 1.25rem; @if (!$pending) margin-bottom: 30px @endif">
                                            Kami mendeteksi adanya
                                            aktivitas
                                            yang tidak wajar di
                                            kafemu, segera ajukan aktivasi
                                            untuk mengaktifkan kafemu kembali
                                            @if ($cafe->activation and $cafe->activation->status != 'pending')
                                                <a style="line-height: 1.25rem; margin-top: 10px; cursor: pointer"
                                                    class="float-right" data-toggle="modal" data-target="#exampleModal">
                                                    Aktivasi <i class="fas fa-angle-right"></i>
                                                </a>
                                            @endif
                                        </p>

                                    </div>
                                @endif
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
                                    <label for="">Titik Lokasi</label>
                                    <input type="hidden" name="latlng" id="inputLatLong"
                                        value="{{ json_encode([$cafe->lat, $cafe->lng]) }}">
                                    <div class="leaflet-map mt-2" id="map" style="height: 40vh;"></div>
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
                <div class="col-6 col-md-6 col-lg-6 bg-white">
                    <div class="swiper mb-4" id="swiper-single-slides" style="height: 50vh !important; ">
                        <div class="swiper-wrapper">
                            <div class="img-container-cover swiper-slide"
                                style="background-image: url('{{ asset($cafe->main_image) }}') !important; ">
                            </div>
                            @foreach ($cafe->image as $img)
                                <div class="img-container-contain swiper-slide"
                                    style="background-image: url('{{ asset($img->img) }}') !important; ">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="container px-3">
                        {{-- Data Cafe --}}
                        <h3 class="text-dark">{{ $cafe->name }}</h3>
                        <div class="row">
                            <div class="col-1 pl-3">
                                <i class="fas fa-lg fa-location-dot text-primary"></i>
                            </div>
                            <div class="col-11 px-2 text-100rem">
                                {{ $cafe->address }}
                            </div>
                            <div class="col-1 pl-3 pt-1">
                                <i class="fas fa-lg fa-star text-warning"></i>
                            </div>
                            <div class="col-11 px-2 pt-1 text-100rem">
                                {{ $cafe->rating }}
                            </div>
                        </div>
                        <div class="text-desc w-80 mt-3" id="text-desc-parent" style="font-size: 14px;">
                            {!! strlen($cafe->desc) > 106
                                ? substr($cafe->desc, 0, 106) . '... ' . ' <span id="text-desc-cafe" style="color: #0957DE">Selengkapnya</span>'
                                : $cafe->desc !!}
                        </div>
                        {{-- Lokasi --}}
                        <h4 class="mt-4 mb-3 text-dark">Lokasi</h4>
                        <div class="leaflet-map" id="map2" style="height: 25vh;"></div>
                        {{-- Menu --}}
                        <div class="row mt-5 mb-2">
                            <div class="col-8">
                                <h4 class="text-dark">Menu di Cafe ini</h4>
                            </div>
                            <div class="col-4 mt-1 float-right text-right">
                                <a href="{{ Request::url() . '/menu' }}">Semua</a>
                            </div>
                            <div class="col-12">
                                <div class="swiper mb-4" id="swiper-multiple-slides">
                                    <div class="swiper-wrapper">
                                        @foreach ($cafe->menu->take(5) as $menu)
                                            <div class="swiper-slide slide-menu" data-id="{{ $menu->id }}"
                                                style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.8) ), url({{ asset($menu->main_image) }})">
                                                <div class="d-flex flex-column h-100">
                                                    <div class="d-flex justify-content-start align-items-end"
                                                        style="flex: 1;">
                                                        <p class="text-100rem mb-2">
                                                            {{ strlen($menu->name) > 17 ? substr($menu->name, 0, 14) . '... ' : $menu->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tema Suasana ~ tema --}}
                        <h4 class="mt-5 mb-2 text-dark">Tema dan Suasana</h4>
                        <div class="">
                            @foreach ($cafe->category as $c)
                                <div class="badge mr-1 mt-2 badge-primary">
                                    @if ($c->category->icon != null)
                                        <i class="{{ $c->category->icon }}"></i> &nbsp;
                                    @endif
                                    {{ ucfirst($c->category->name) }}
                                </div>
                            @endforeach
                        </div>

                        {{-- Tiktok ~ tiktok --}}
                        <h4 class="mt-4 mb-2 text-dark">Video</h4>
                        <div class="d-flex align-items-start align-items-sm-center gap-4 h-px-200">
                            <div class="swiper h-px-200 mb-4" id="swiper-multiple-slides-url">
                                <div class="swiper-wrapper">
                                    @foreach ($cafe->url as $url)
                                        <div class="swiper-slide slide-menu mr-2 modal-tiktok"
                                            data-id="{{ $url->id }}"
                                            style="border-radius: 0.5rem; background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url({{ asset($url->thumbnail) }})">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permohonan Aktivasi Kafe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tuliskan alasan kenapa kamu ingin membuka blokir kafe ini</p>
                    <form id="form-activation" action="{{ route('owner.activation.store', $cafe) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Keterangan</label>
                            <textarea class="form-control" name="reason" id="reason" cols="30" rows="10" style="height: 10rem"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-icon btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times-circle mr-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-icon btn-primary btn-save-activation">
                        <i class="fas fa-save mr-1"></i>Ajukan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="deletionModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permohonan Penghapusan Kafe dari Sistem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tuliskan alasan kenapa kamu ingin menghapus kafe ini</p>
                    <form id="form-deletion" action="{{ route('owner.deletion.store', $cafe) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Alasan menghapus kafe</label>
                            <textarea class="form-control" name="reason" id="reason" cols="30" rows="10" style="height: 10rem"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-icon btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times-circle mr-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-icon btn-primary btn-save-deletion">
                        <i class="fas fa-save mr-1"></i>Ajukan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <style>
        .modal-tiktok {
            width: 120px !important;
            height: 200px;
        }

        .swiper .swiper-slide {
            /* padding: 2rem 0; */
            padding-right: 1rem;
            padding-left: 1rem;
            padding-top: 2rem;
            text-align: center;
            font-size: 1.5rem;
            background-color: #ecebed;
            background-position: center;
            background-size: cover;
        }

        .swiper {
            /* width: 600px; */
            min-height: 130px;
            height: 100%;
        }

        .swiper-subtitle {
            font-size: 10px;
            letter-spacing: 0px;
        }

        .reviewer-profile {
            height: 40px;
            width: 40px;
            background-image: url('{{ asset($cafe->main_image) }}');
            background-size: cover;
            background-position: center;
            border-radius: 30px
        }

        .badge {
            padding: 8px 12px;
        }

        .tiktok-embed {
            margin: 0 !important;
        }

        .modal-body-tiktok {
            padding: 0 !important;
        }

        blockquote {
            padding: 20px !important;
        }

        .btn-bar-scrolled {
            color: #061C49;
        }

        .modal-content {
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            max-width: inherit;
            /* For Bootstrap 4 - to avoid the modal window stretching full width */
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
            pointer-events: all;
        }

        .leaflet-map {
            border-radius: 15px;
            max-width: 450px;

        }

        .leaflet-control-zoom {
            display: none
        }

        .leaflet-control-attribution {
            display: none
        }

        .text-100rem {
            font-size: 1rem !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/autosize/autosize.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
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
            var map2 = L.map('map2').setView(latLong, 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
            marker = L.marker(latLong, {
                draggable: 'true'
            }).addTo(map);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map2);
            marker = L.marker(latLong, {
                draggable: 'true'
            }).addTo(map2);
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
    <script>
        let btn;
        $(document).ready(function() {
            //swiper
            new Swiper(document.querySelector('#swiper-multiple-slides'), {
                slidesPerView: 2,
                spaceBetween: 10,
                pagination: {
                    clickable: true,
                    el: '.swiper-pagination'
                }
            });
            new Swiper(document.querySelector('#swiper-single-slides'), {
                slidesPerView: 1,
                spaceBetween: 0,
                pagination: {
                    clickable: false,
                    el: '.swiper-pagination'
                }
            });

            new Swiper(document.querySelector('#swiper-multiple-slides1'), {
                slidesPerView: 2,
                spaceBetween: 0,
                pagination: {
                    clickable: true,
                    el: '.swiper-pagination'
                }
            });

            new Swiper(document.querySelector('#swiper-multiple-slides-url'), {
                slidesPerView: 3,
                spaceBetween: 0,
                pagination: {
                    clickable: true,
                    el: '.swiper-pagination'
                }
            });
        })

        $('.btn-save-activation').click(function() {
            $('#form-activation').submit()
        })
        $('.btn-save-deletion').click(function() {
            $('#form-deletion').submit()
        })
    </script>
@endpush
