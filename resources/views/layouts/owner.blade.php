@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
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
                                    <div class="profile-widget-item-value ">{{ $cafe->visit->count() }}</div>
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
                    <div class="mt-4 mb-3">
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/category') }}"
                            class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-boxes mr-1"></i> Kategori
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/image') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-image mr-1"></i> Foto
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/menu') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-hamburger mr-1"></i> Menu
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/url') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fab fa-tiktok mr-1"></i> Video Tiktok
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/review') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-message mr-1"></i> Review
                        </a>
                    </div>
                    {{-- card --}}
                    @yield('content')
                    {{-- endcard --}}
                </div>
            </div>
        </div>
    </section>
@endsection
