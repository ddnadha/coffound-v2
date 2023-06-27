@extends('layouts.mobile')

@section('title', 'Coffound')

@section('nav')
    <h6 style="margin-top: 5px">Buka Cafe Sekarang!</h6>
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                @if (auth()->check() and
                        !auth()->user()->cafe->isEmpty())
                    <div class="container text-center" style="padding-top: 30%; height: 100vh">
                        <img style="max-width: 100%" src="{{ asset('assets/img/8354051_3883064.jpg') }}" alt="">
                        <h1 style="font-size: 24px; font-weight: 700">Terima kasih sudah mendaftarkan cafe mu di coffound !
                        </h1>
                        <p style="font-size: 16px">
                            Kami sedang melakukan verifikasi untuk memastikan keamanan dan keaslian informasi Anda.
                        </p>
                        <a href="{{ url('/') }}" class="btn btn-primary text-white">Kembali ke Halaman Utama</a>
                    </div>
                @else
                    <div class="container text-center" style="padding-top: 40%; height: 100vh">
                        <img style="max-width: 100%" src="{{ asset('assets/img/8354051_3883064.jpg') }}" alt="">
                        <h1 style="font-size: 24px; font-weight: 700">Bergabunglah ke Coffound agar caffee-mu lebih dikenal
                            !</h1>
                        <p style="font-size: 16px">
                            Yuk, jadikan caffeemu lebih maju dan berkembang dengan bergabung ke platform kami !
                            Bergabunglah sekarang dan rasakan manfaatnya untuk caffeemu!
                        </p>
                        <a href="{{ route('caffe.open.form') }}" id="btn-join" class="btn btn-primary text-white">Gabung
                            Sekarang !</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $('#nav-item-open').addClass('nav-item-bottom-active')
    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <style>
        .swal2-actions-right {
            flex-direction: row-reverse;
        }

        body,
        section,
        .main-content {
            background: white;
        }
    </style>
@endpush
