@extends('layouts.mobile')

@section('title', 'Coffound')

@section('nav')
    <h6 style="margin-top: 5px">Hi, {{ auth()->user()->name }}!</h6>
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header px-3">
                            <h4>Profil</h4>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-3 pt-2">
                                    <img src="{{ asset(auth()->user()->img) }}" alt="" width="60px"
                                        height="60px">
                                </div>
                                <div class="col-9 pt-3">
                                    <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                                    <p class="mb-1">{{ auth()->user()->email }}</p>
                                    <p>{{ auth()->user()->phone }}</p>
                                </div>
                            </div>
                            <hr>
                            @if (auth()->user()->priv != 'user')
                                <a data-href="{{ route('owner.cafe.index') }}" class="link-desktop text-primary">
                                    <div class="row py-3">

                                        <div class="col-2 text-center">
                                            <i class="fas fa-dashboard"></i>
                                        </div>
                                        <div class="col-10 pl-0">
                                            Kelola Cafe
                                        </div>
                                    </div>
                                </a>
                            @endif
                            <a href="{{ url('mobile/fav') }}">
                                <div class="row py-3">
                                    <div class="col-2 text-center">
                                        <i class="fas fa-shop"></i>
                                    </div>
                                    <div class="col-10 pl-0">
                                        Cafe Favorit
                                    </div>
                                </div>
                            </a>
                            <hr>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-danger btn-block btn-icon">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script>
        $('#nav-item-profile').addClass('nav-item-bottom-active')
        $('.link-desktop').on('click', function() {
            event.preventDefault();
            let _this = $(this)
            // console.log(_this.attr('data-href'))
            swal({
                    title: 'Lanjutkan?',
                    text: 'Tampilan ini akan lebih maksimal jika dibuka dengan perangkat desktop, apakah anda ingin melanjutkan',
                    icon: 'warning',
                    buttons: {
                        cancel: {
                            text: "Batal",
                            className: 'btn btn-danger',
                            closeModal: true,
                            visible: true,
                        },
                        confirm: {
                            text: "Ya, Lanjutkan",
                            className: 'btn btn-primary',
                            visible: true,
                        }
                    },
                    dangerMode: false,
                })
                .then((status) => {
                    if (status)
                        window.location = _this.attr('data-href')

                });
        })
    </script>
@endpush
@push('style')
@endpush
