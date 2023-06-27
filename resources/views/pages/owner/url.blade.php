@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-12">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    @include('components.owner-nav')
                    <div class="card">
                        <div class="card-header">
                            <h4>Video Tiktok</h4>
                            <div class="card-header-action">
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-icon">
                                    <i class="fas fa-plus"></i> Tambah Video
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($cafe->url as $url)
                                    <div class="col-md-3 col-sm-4 px-2">
                                        <div class="mb-3">
                                            <img src="{{ asset($url->thumbnail) }}" class="w-100" alt="">
                                            <div class="w-100 px-4" style="position: absolute; top: 5px;">
                                                <form action="{{ route('owner.url.destroy', [$cafe, $url]) }}"
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
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Pastikan tautan yang kamu masukkan dapat dibuka</p>
                    <form id="form-url" action="{{ route('owner.url.store', $cafe) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="url">Link ke Video Tiktok</label>
                            <input type="text" name="url" id="url" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-icon btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times-circle mr-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-icon btn-primary btn-save">
                        <i class="fas fa-save mr-1"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
@endpush

@push('scripts')
    <script>
        $('.btn-save').click(function() {
            $('#form-url').submit()
        })
    </script>
@endpush
