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
                                style="background-image: url('{{ asset($c->main_image) }}'); @if ($c->status == 'suspended' or $c->status == 'deactive') filter: grayscale(100%); @endif">

                            </div>
                            <div class="card-body">
                                <div style="min-height: 43.19px">
                                    <h4>
                                        {{ $c->name }}
                                    </h4>
                                    @if ($c->status == 'deactive')
                                        <span class="mb-1 badge badge-warning">Non Aktif</span>
                                    @elseif ($c->status == 'suspended')
                                        <span class="mb-1 badge badge-danger">Suspended</span>
                                    @endif
                                </div>

                                <p>{{ $c->address }}</p>
                                <a href="{{ url('owner/cafe/' . $c->id) }}" class="card-cta float-right">Kelola Cafemu <i
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
