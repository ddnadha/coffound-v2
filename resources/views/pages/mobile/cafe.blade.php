@extends('layouts.nonavmobile')

@section('title', 'Coffound')

@section('main')
    <div class="main-content">
        <div class="nav-custom">
            <div class="px-4 text-center vertical-align-middle">
                <a class="btn btn-lg px-3 rounded-circle btn-light float-left" onclick="history.back()">
                    <i class="fas fa-angle-left fa-xl"></i>
                </a>
                @if ($cafe->is_fav)
                    <a class="btn btn-lg px-3 btn-light rounded-circle text-danger float-right">
                        <i class="fas fa-heart fa-xl"></i>
                    </a>
                @else
                    <a class="btn btn-lg px-3 btn-light rounded-circle float-right">
                        <i class="far fa-heart fa-xl"></i>
                    </a>
                @endif
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
            <div class="leaflet-map" id="map" style="height: 25vh;"></div>
            {{-- Menu --}}
            <div class="row mt-5 mb-2">
                <div class="col-8">
                    <h4 class="text-dark">Menu di Cafe ini</h4>
                </div>
                <div class="col-4 mt-1 float-right">
                    Lebih banyak
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
            <h4 class="mt-5 mb-1 text-dark">Video</h4>
            <div class="d-flex align-items-start align-items-sm-center gap-4 h-px-200">
                <div class="swiper h-px-200 mb-4" id="swiper-multiple-slides-url">
                    <div class="swiper-wrapper">
                        @foreach ($cafe->url as $url)
                            <div class="swiper-slide slide-menu" data-id="{{ $url->id }}"
                                style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url({{ asset($url->thumbnail) }})">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Review ~ review --}}
            <div class="mt-5 mb-3">
                <hr>
                <b class="text-dark text-100rem">Anda pernah mengunjungi cafe ini ?</b>
                <p class="text-dark text-80rem line-height-15">
                    Bagikan pengalaman anda untuk membantu orang lain menemukan cafe tujuan mereka
                </p>
                <div class="d-flex mt-2">
                    <div class="reviewer-profile mx-2"></div>
                    <a href="{{ route('review.create', $cafe) }}">
                        <div class="d-inline-block pl-4">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="far fa-star text-warning text-100rem mt-2"></i>
                            @endfor
                        </div>
                    </a>
                </div>
                <hr>
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
                                    <img src="{{ asset($image->img) }}" alt=""
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
            </div>
            {{-- End Review --}}
            {{-- Cafe Lain --}}
            <h4 class="mt-2 mb-1 text-dark">Cafe Lainnya</h4>
            <div class="swiper" id="swiper-multiple-slides1" style="height: auto">
                <div class="swiper-wrapper ">
                    @foreach ($othercafe as $cafe)
                        <div class="swiper-slide px-0">
                            <div class="card h-100 card-body-cafe force-round-15">
                                <div class="card-header card-header-image"
                                    style="background-image: linear-gradient( rgba(4, 32, 72, 0), rgba(4, 32, 72, 0) ), url('{{ asset($cafe->main_image) }}');">
                                </div>
                                <div class="card-body pt-3 pl-1 pr-1 text-dark card-body-cafe">
                                    <div style="height: 2.5rem">
                                        <strong class="align-left">
                                            {{ strlen($cafe->name) > 15 ? substr($cafe->desc, 0, 15) . '... ' : $cafe->name }}
                                        </strong>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-2 pl-3">
                                            <i class="fas fa-location-dot text-primary"></i>
                                        </div>
                                        <div class="col-9 px-2">
                                            {{ ucfirst($cafe->district->name) }}
                                        </div>
                                        <div class="col-2 pl-3 pt-1">
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                        <div class="col-9 px-2 pt-1">
                                            {{ $cafe->rating }}
                                        </div>
                                    </div>
                                    <div class="w-100 container-button-cafe">
                                        <a href="{{ route('caffee.show') }}/${val.name.replace(" ", " _")}"
                                            class="btn btn-primary btn-icon float-right mr-1 force-round-20">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
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
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();

            if (scroll >= 100) {
                $("#topbar").addClass("bg-white");
                $('.btn-bar').removeClass('btn btn-circle btn-light')
                $('.btn-bar').addClass('btn-bar-scrolled')
            } else {
                $("#topbar").removeClass("bg-white");
                $('.btn-bar').addClass('btn btn-circle btn-light')
                $('.btn-bar').removeClass('btn-bar-scrolled')
            }
        });
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
@endpush
