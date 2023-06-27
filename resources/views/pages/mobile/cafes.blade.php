@extends('layouts.mobile')

@section('title', 'Coffound')

@section('nav')
    <h6 style="margin-top: 5px">Kelola Cafemu</h6>
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                <div class="row mx-3" id="cafe-container">
                    @foreach ($cafes as $cafe)
                        <div class="col-6 col-md-3 col-sm-6 p-1" style="max-height: 295px">
                            <div class="card h-100 card-body-cafe force-round-15">
                                <div class="card-header card-header-image"
                                    style="background-image: linear-gradient( rgba(4, 32, 72, 0), rgba(4, 32, 72, 0) ), url('{{ asset($cafe->main_image) }}');">
                                </div>
                                <div class="card-body pt-3 pl-1 pr-1 text-dark card-body-cafe">
                                    <div style="height: 2.5rem">
                                        <strong>{{ $cafe->name }}</strong>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-2 pl-3">
                                            <i class="fas fa-location-dot text-primary"></i>
                                        </div>
                                        <div class="col-9 px-2">
                                            {{ ucfirst(strtolower($cafe->district->name)) }}
                                        </div>
                                        <div class="col-2 pl-3 pt-1">
                                            <i class="fas fa-star text-warning"></i>
                                        </div>
                                        <div class="col-9 px-2 pt-1">
                                            {{ $cafe->rating }}
                                        </div>
                                    </div>
                                    <div class="w-100 container-button-cafe">
                                        <a data-url="{{ route('cafe.show', $cafe) }}"
                                            class="btn btn-primary btn-icon btn-manage-cafe float-right mr-1 force-round-20 text-light">
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
    <div class="w-100" style="bottom: 100px; z-index: 999; height: 61px; position: fixed; padding-right: 10px">
        <a href="{{ url('mobile/open/form') }}"
            class="btn btn-lg btn-icon btn-primary rounded-circle float-right h-100 px-3 pt-3" style="width: 61px">
            <i class="fas fa-plus " style="font-size: 1.5rem"></i>
        </a>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script>
        $('#nav-item-open').addClass('nav-item-bottom-active')
        $('.btn-manage-cafe').on('click', function() {
            let _this = $(this)
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
                        window.location = _this.attr('data-url');
                });
        })
    </script>
@endpush
@push('style')
    <style>

    </style>
@endpush
