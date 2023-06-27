@extends('layouts.mobile')

@section('title', 'Coffound')

@section('nav')
    <h6 style="margin-top: 5px">Menu di {{ $cafe->name }}</h6>
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                <div class="row mx-3">
                    @foreach ($cafe->menu as $menu)
                        <div class="col-6 px-1 mb-2">
                            <div class="slide-menu" data-id="{{ $menu->id }}"
                                style="height: 150px; background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.8) ), url({{ asset($menu->main_image) }}); background-position:center; background-size:cover">
                                <div class="d-flex flex-column h-100 text-white px-2">
                                    <div class="d-flex justify-content-start align-items-end" style="flex: 1;">
                                        <p class="text-100rem mb-2">
                                            {{ strlen($menu->name) > 17 ? substr($menu->name, 0, 14) . '... ' : $menu->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="menuModal">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center px-2" role="document">
                <div class="modal-content">
                    <div class="modal-body rounded">
                        <div>
                            <img id="img-modal-menu" src="{{ asset($menu->main_image) }}" alt=""
                                style="width: 100%; margin-bottom: 1rem; border-radius: 10px">
                            <h4 id="text-modal-name" style="margin-bottom: 0.5rem">{{ $menu->name }}</h4>
                            <p class="" id="text-modal-desc">{{ $menu->desc }}</p>
                            <h6 id="text-modal-price" style="margin-bottom: 0.5rem">Rp.
                                {{ number_format($menu->price, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
            pointer-events: none;
        }

        .vertical-align-center {
            /* To center vertically */
            display: table-cell;
            vertical-align: middle;
            pointer-events: none;
        }

        .navbar-bottom {
            display: none !important
        }

        .nav-link {
            display: none !important
        }

        .btn-back-nav {
            display: block !important
        }
    </style>
@endpush
@push('scripts')
    <script>
        $('.slide-menu').on('click', function() {
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/menu/') }}/` + $(this).attr('data-id'),
                async: false,
                dataType: 'json',
                success: function(result) {
                    let _name = result.data.name.length > 23 ? result.data.name.slice(0,
                            20) + `...` :
                        result.data.name
                    console.log(result)
                    $('#img-modal-menu').attr('src', result.data.image)
                    $('#text-modal-name').html(_name)
                    $('#text-modal-price').html(result.data.price)
                    $('#text-modal-desc').html(result.data.desc)
                    $('#menuModal').modal('show')
                }
            })
        })
    </script>
@endpush
