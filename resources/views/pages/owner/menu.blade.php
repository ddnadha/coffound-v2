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
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Menu</h4>
                            <div class="card-header-action">
                                <a href="{{ route('owner.menu.create', $cafe) }}" class="btn btn-primary btn-icon">
                                    <i class="fas fa-plus"></i> Tambah Menu
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($cafe->menu as $menu)
                                    <div class="col-md-4 col-sm-6 px-2">
                                        <div class="card card-hero">
                                            <div class="card-header card-header-image p-0"
                                                style="background-image: url({{ asset($menu->main_image) }})">
                                                <div class="card-header-action float-right pt-1 pr-1">
                                                    <form action="{{ route('owner.menu.destroy', [$cafe, $menu]) }}"
                                                        method="POST">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <a href="{{ route('owner.menu.edit', [$cafe, $menu]) }}"
                                                            class="btn btn-sm btn-icon btn-warning "
                                                            style="padding: 2px 10px">
                                                            <i class="fas fa-pencil"></i>
                                                        </a>
                                                        <button
                                                            onclick="confirm('Apakah anda yakin ingin menghapus data ini ?')"
                                                            type="submit" class="btn btn-sm btn-icon btn-danger "
                                                            style="padding: 2px 10px">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <h6>{{ $menu->name }}</h6>
                                                <p style="line-height: 1.25rem !important">{{ $menu->desc }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style>
        .card-header-image {
            min-height: 160px !important;
            background-position: center center;
            background-size: cover;
        }
    </style>
@endpush
