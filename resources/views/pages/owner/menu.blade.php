@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $cafe->name }}</h1>
        </div>
        <div class="col-md-12">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    @include('components.owner-nav')
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
                                    <div class="col-md-3 col-sm-6 px-2">
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
                                                <div class="text-container" style="height: 60px">{{ $menu->desc }}</div>
                                                <div class="font-weight-bold mt-2">Rp.
                                                    {{ number_format($menu->price, 0, '.', '.') }}</div>
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
