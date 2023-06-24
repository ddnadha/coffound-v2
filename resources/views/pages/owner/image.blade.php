@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $cafe->name }}</h1>
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
                    @include('components.owner-nav')
                    <div class="card">
                        <div class="card-header">
                            <h4>Foto Cafe</h4>
                            <div class="card-header-action">
                                <a href="{{ route('owner.image.create', $cafe) }}" class="btn btn-primary btn-icon">
                                    <i class="fas fa-plus"></i> Tambah Foto
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($cafe->image as $image)
                                    <div class="col-md-4 col-sm-6 px-2 my-2">
                                        <div>
                                            <img src="{{ asset($image->img) }}" class="wh-px-200" alt="">
                                            <div class="w-100 px-4" style="position: absolute; top: 5px;">
                                                <form action="{{ route('owner.image.destroy', [$cafe, $image]) }}"
                                                    method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button
                                                        onclick="confirm('Apakah anda yakin ingin menghapus data ini ?')"
                                                        type="submit" class="btn btn-sm btn-icon btn-danger float-right"
                                                        style="padding: 2px 10px">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
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
        .wh-px-200 {
            height: 150px;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endpush
