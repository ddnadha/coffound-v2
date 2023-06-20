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
                                        <a href="{{ route('cafe.show', $cafe) }}"
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
    <script>
        $('#nav-item-open').addClass('nav-item-bottom-active')
    </script>
@endpush
@push('style')
    <style>

    </style>
@endpush
