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
                            <h4>Menu</h4>
                            <div class="card-header-action">
                                <button id="btnSave" type="button" class="btn btn-primary btn-icon">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form-menu"
                                action="{{ isset($menu) ? route('owner.menu.update', [$cafe, $menu]) : route('owner.menu.store', $cafe) }}"
                                method="POST" enctype="multipart/form-data">
                                @if (isset($menu))
                                    {{ method_field('PUT') }}
                                @endif
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama Menu</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ @$menu->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga Menu</label>
                                    <input type="number" name="price" id='price' class="form-control"
                                        value="{{ @$menu->price }}">
                                </div>
                                <div class="form-group">
                                    <label for="desc">Deskripsi Menu</label>
                                    <textarea name="desc" id="desc" rows="10" class="form-control">{{ @$menu->desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <div class="photo_submit-container">
                                        <label
                                            style="font-weight: 600; font-size:12px; color: #34395e; letter-spacing: 0.5px">Foto</label>
                                        <div class="photo_submit-container">
                                            <label class="photo_submit js-photo_submit1">
                                                <input class="photo_submit-input js-photo_submit-input" type="file"
                                                    accept="image/*" name="image" />
                                                <span class="photo_submit-plus"></span>
                                                <span class="photo_submit-delete"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('css/fileupload.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/fileupload.js') }}"></script>
    <script>
        $('#btnSave').click(function() {
            $('#form-menu').submit()
        })
    </script>
    @if (isset($menu))
        <script>
            $('.photo_submit').addClass('photo_submit--image')
            $('.photo_submit').css('background-image', 'url({{ asset($menu->main_image) }})')
        </script>
    @endif
@endpush
