@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Caffemu</h1>
        </div>
        <div class="col-md-12">
            <div class="row">
                @foreach ($cafe as $c)
                    <div class="col-lg-6">
                        <div class="card card-large-icons h-90">
                            <div class="card-icon bg-cafe text-white"
                                style="background-image: url('{{ asset($c->main_image) }}')">

                            </div>
                            <div class="card-body">
                                <h4 style="min-height: 43.19px">{{ $c->name }}</h4>
                                <p>{{ $c->address }}</p>
                                <a href="{{ url('owner/cafe/' . $c->id) }}" class="card-cta">Kelola Cafemu <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .h-90 {
            height: 80%;
        }

        .bg-cafe {
            background-position: center center;
            /* object-fit: cover; */
            background-size: cover;
        }
    </style>
@endpush
