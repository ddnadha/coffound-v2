@extends('layouts.nonavmobile')

@section('title', 'Coffound')

@section('main')
    <div class="main-content">
        <div class="nav-custom" id="topbar">
            <div class="px-4 text-center vertical-align-middle">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-bar btn-lg px-3 rounded-circle btn-light float-left" onclick="history.back()">
                            <i class="fas fa-angle-left fa-xl"></i>
                        </a>
                    </div>
                    <div class="col-8 pt-2 text-center">
                        <h6 class="font-weight-bold text-dark text-name d-none">
                            Detail Cafe
                        </h6>
                    </div>
                    <div class="col-2">
                        @auth
                            @if ($cafe->is_fav)
                                <a class="btn btn-bar btn-lg px-3 btn-light rounded-circle btn-fav text-danger float-right">
                                    <i class="fas fa-heart fa-xl"></i>
                                </a>
                            @else
                                <a class="btn btn-bar btn-lg px-3 btn-light rounded-circle btn-fav float-right">
                                    <i class="far fa-heart fa-xl"></i>
                                </a>
                            @endif
                        @endauth
                        @guest
                            <a href="{{ route('login') }}"
                                class="btn btn-bar btn-lg px-3 btn-light rounded-circle btn-fav float-right">
                                <i class="far fa-heart fa-xl"></i>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
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
            <div class="row">
                <div class="col-10">
                    <h3 class="text-dark">{{ $cafe->name }}</h3>
                </div>
                <div class="col-2 text-center pt-1">
                    <a target="_blank" href="{{ 'https://wa.me/+62' . ltrim($cafe->user->phone, '0') }}">
                        <i class="fab fa-whatsapp text-success" style="font-size: 1.5rem !important"></i>
                    </a>

                </div>
            </div>
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
            <div class="leaflet-map" id="map" style="height: 25vh;"></div>
            {{-- Menu --}}
            @if (!$cafe->menu->isEmpty())
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
                                            <div class="d-flex justify-content-start align-items-end" style="flex: 1;">
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
            @endif

            {{-- Tema Suasana ~ tema --}}
            @if (!$cafe->category->isEmpty())
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
            @endif

            {{-- Tiktok ~ tiktok --}}
            @if (!$cafe->url->isEmpty())
                <h4 class="mt-4 mb-2 text-dark">Video</h4>
                <div class="d-flex align-items-start align-items-sm-center gap-4 h-px-200">
                    <div class="swiper h-px-200 mb-4" id="swiper-multiple-slides-url">
                        <div class="swiper-wrapper">
                            @foreach ($cafe->url as $url)
                                <div class="swiper-slide slide-menu mr-2 modal-tiktok" data-id="{{ $url->id }}"
                                    style="border-radius: 0.5rem; background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url({{ asset($url->thumbnail) }})">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Review ~ review --}}
            <div class="mt-3 mb-3">
                <hr>
                {{-- @if (auth()->id() and $cafe->review->firstWhere('user_id', auth()->id()) == null) --}}
                <b class="text-dark text-100rem">Anda pernah mengunjungi cafe ini ?</b>
                <p class="text-dark text-80rem line-height-15">
                    Bagikan pengalaman anda untuk membantu orang lain menemukan cafe tujuan mereka
                </p>
                <div class="d-flex mt-2">
                    <div class="reviewer-profile mx-2"
                        style="background-image: url({{ asset($cafe->main_image) }}) !important">
                    </div>
                    <a href="{{ route('mobile.review.create', $cafe) }}">
                        <div class="d-inline-block pl-3">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="far fa-star text-warning text-100rem mt-2"></i>
                            @endfor
                        </div>
                    </a>
                </div>
                <hr>
                {{-- @endif --}}
                @if (!$cafe->review->isEmpty())
                    <div class="text-dark">
                        <h4 class="mt-4 mb-3 ">Review</h4>
                        @php
                            if ($cafe->review->first()) {
                                $review_id = $cafe->review->first()->id;
                            }
                        @endphp
                        @foreach ($cafe->review->take(5) as $review)
                            @foreach ($review->messages as $message)
                                <div class="w-100 mt-2 mb-3"
                                    @if ($message != $review->messages->first()) style="margin-top: 20px; padding-left: 20px" @endif>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="reviewer-profile mr-3"
                                                style="background-image: url('{{ asset($review->user->img) }}');">
                                            </div>
                                        </div>
                                        <div class="col-10 p-0 pt-2 text-100rem font-weight-bold">
                                            {{ $message->user->name }}
                                        </div>
                                    </div>
                                    @if ($message == $review->messages->first())
                                        <div class="stars-container my-2 d-inline-block">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star text-warning vertical-align-middle"></i>
                                                @else
                                                    <i class="far fa-star text-warning vertical-align-middle"></i>
                                                @endif
                                            @endfor
                                            <span class="text-80rem p-1 h-100">
                                                {{ $message->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <p class="pr-0 text-100rem mb-0">
                                            {{ $message->message }}
                                        </p>
                                    @else
                                        <div class="stars-container my-2 d-inline-block">
                                            <span class="text-80rem p-1 h-100">
                                                {{ $message->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <p class="pr-0 text-100rem">
                                            {{ $message->message }}
                                        </p>
                                    @endif
                                    @foreach ($message->image as $image)
                                        <img class="img-review" src="{{ asset($image->img) }}" alt=""
                                            style="width: 50px; height: 50px; margin-top: 10px">
                                    @endforeach
                                </div>
                            @endforeach
                            @php
                                if ($review_id != $review->id or $review == $cafe->review->last()) {
                                    $review_id = $review->id;
                                    echo '<hr>';
                                }
                                
                            @endphp
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- End Review --}}

            {{-- Cafe Lain --}}
            <h4 class="mt-2 mb-2 text-dark">Cafe Lainnya</h4>
            <div class="row px-2">
                @foreach ($othercafe as $c)
                    <div class="col-6 px-1 pb-2">
                        <div class="card h-100 force-round-15">
                            <div class="card-header card-header-image"
                                style="background-image: linear-gradient( rgba(4, 32, 72, 0), rgba(4, 32, 72, 0) ), url('{{ asset($c->main_image) }}');">
                            </div>
                            <div class="card-body pt-3 pl-1 pr-1 text-dark card-body-cafe">
                                <div style="height: 2.5rem">
                                    <strong class="align-left">
                                        {{ strlen($c->name) > 15 ? substr($c->name, 0, 15) . '... ' : $c->name }}
                                    </strong>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-2 pl-3">
                                        <i class="fas fa-location-dot text-primary"></i>
                                    </div>
                                    <div class="col-9 px-2">
                                        {{ ucfirst($c->district->name) }}
                                    </div>
                                    <div class="col-2 pl-3 pt-1">
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <div class="col-9 px-2 pt-1">
                                        {{ $c->rating }}
                                    </div>
                                </div>
                                <div class="w-100 container-button-cafe">
                                    <a href="{{ route('caffee.show') }}/{{ str_replace(' ', '_', $c) }}"
                                        class="btn btn-primary btn-icon float-right mr-1 force-round-20">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- End Cafe Lain --}}
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="tiktokModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-0 pr-3 pt-2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-tiktok" id="video-container">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="menuModal">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center" role="document">
                <div class="modal-content mx-2">
                    <div class="modal-body rounded">
                        <div>
                            <img id="img-modal-menu" alt=""
                                style="width: 100%; margin-bottom: 1rem; border-radius: 10px">
                            <h4 id="text-modal-name" style="margin-bottom: 0.5rem"></h4>
                            <p class="" id="text-modal-desc"></p>
                            <h6 id="text-modal-price" style="margin-bottom: 0.5rem">Rp.
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modal')
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script>
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            console.log(scroll)
            if (scroll >= 100) {
                $("#topbar").addClass("bg-white");
                $('.btn-bar').removeClass('btn btn-circle btn-light')
                $('.btn-bar').addClass('py-0')
                $('.text-name').addClass('d-block')
                $('.text-name').removeClass('d-none')
            } else {
                $("#topbar").removeClass("bg-white");
                $('.btn-bar').addClass('btn btn-circle btn-light')
                $('.btn-bar').removeClass('py-0')
                $('.text-name').addClass('d-none')
                $('.text-name').removeClass('d-block')
            }
        });
        $(document).ready(function() {
            $('.modal-tiktok').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('/api/embed') }}/" + $(this).attr('data-id'),
                    async: false,
                    dataType: 'json',
                    success: function(result) {
                        $('#video-container').html(result.html)
                        $('#tiktokModal').modal('show')
                    }
                });
            })

            $('.slide-menu').on('click', function() {
                $.ajax({
                    type: 'GET',
                    url: `{{ url('/api/menu/') }}/` + $(this).attr('data-id'),
                    async: false,
                    dataType: 'json',
                    success: function(result) {
                        let _name = result.data.name.length > 23 ? result.data.name.slice(0,
                                20) + `...` :
                            result.data.name
                        console.log(result)
                        $('#img-modal-menu').attr('src', result.data.image)
                        $('#text-modal-name').html(_name)
                        $('#text-modal-price').html(result.data.price)
                        $('#text-modal-desc').html(result.data.desc)
                        $('#menuModal').modal('show')
                    }
                })
            })

            $('.btn-fav').on('click', function() {
                let _this = $(this)
                $.ajax({
                    type: 'POST',
                    url: `{{ url('mobile/caffe/fav') }}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    async: false,
                    dataType: 'json',
                    data: {
                        cafe: {{ $cafe->id }}
                    },
                    success: function(result) {
                        if (result.status) {
                            if (result.message ==
                                "Berhasil menambahkan cafe ke daftar favorit") {
                                _this.html('<i class="fas fa-heart text-danger"></i>')
                            } else if (result.message ==
                                "Berhasil menghapus cafe dari daftar favorit") {
                                _this.html('<i class="far fa-heart text-dark"></i>')
                            }
                            showToast(result.message);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        if (errorThrown == 'Unauthorized') {
                            window.location = "{{ route('login') }}"
                        }
                    }
                });

            })
            $('.img-review').on('click', function() {
                $('#img-modal-review').attr('src', $(this).attr('src'));
                $('#reviewModal').modal('show')
            })
            $('html').on('click', '#text-desc-cafe', function() {
                if (isDescExpanded) {
                    $('#text-desc-parent').html('{{ substr($cafe->desc, 0, 106) }}' +
                        ' <span id="text-desc-cafe" style="color: #0957DE">Selebihnya</span>')
                    isDescExpanded = false
                } else {
                    $('#text-desc-parent').html('{{ $cafe->desc }}' +
                        ' <span id="text-desc-cafe" style="color: #0957DE">Lebih Sedikit</span>')
                    isDescExpanded = true
                }

            })
        })
    </script>
    <script>
        let isDescExpanded = false
        //map and its bussiness
        var map = L.map('map').setView([{{ $cafe->lat }}, {{ $cafe->lng }}], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        marker = L.marker([
            {{ $cafe->lat }}, {{ $cafe->lng }}
        ], {
            draggable: false
        }).addTo(map);

        $('#nav-item-open').addClass('nav-item-bottom-active')
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
    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <style>
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

        .nav-custom {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 100;
            vertical-align: bottom;
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: transparent"

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
    </style>
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
    </style>
    {{-- modal styling --}}
    <style>
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
    </style>
@endpush
