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
                            <h4>Review</h4>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table table-striped text-left">
                                <thead>
                                    <th>#</th>
                                    <th class="text-center">Reviewer</th>
                                    <th>Review</th>
                                    <th>Di Review Pada</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($review as $r)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset($r->user->img) }}" alt="" class="rounded-circle "
                                                    width="32" height="32">
                                                <div class="d-flex flex-column">
                                                    <b class="mt-2">{{ $r->user->name }}</b>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    {{ $r->message->message }}
                                                </p>
                                                <div class="mb-2">
                                                    @foreach ($r->message->image as $image)
                                                        <img class="img-review" src="{{ asset($image->img) }}"
                                                            alt="" height="100" width="100">
                                                    @endforeach
                                                </div>
                                                <br>
                                                @if ($r->messages->count() > 1)
                                                    <b>Reply</b> <br>

                                                    @foreach ($r->messages as $m)
                                                        @if ($m->id != $r->message->id)
                                                            {{ $m->message }} <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                {{ $r->created_at->translatedFormat('d F Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="" class="btn btn-icon btn-danger">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> Laporkan
                                                </a>
                                                <button data-id="{{ $r->id }}" data-msg="{{ $r->message->message }}"
                                                    class="btn btn-icon btn-primary btn-modal">
                                                    <i class="fas fa-reply mr-1"></i> Balas
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                    <h5 class="modal-title">Balas Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="text-review">Balas Review</p>
                    <form id="form-reply" action="{{ route('owner.review.reply', $cafe) }}" method="POST">
                        @csrf
                        <input type="hidden" id="input-review-id" name="review_id">
                        <div class="form-group">
                            <label for="message">Balasan</label>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control" style="height: 150px"></textarea>
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
    @include('components.modal')
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
@push('scripts')
    <script>
        $('table').DataTable({})
        $('.btn-modal').on('click', function() {
            let _this = $(this)
            $('#input-review-id').val(_this.attr('data-id'))
            $('#text-review').html(_this.attr('data-msg'))
            $('#exampleModal').modal('toggle')
        })

        $('.btn-save').on('click', function() {
            $('#form-reply').submit()
        })
        $('.img-review').on('click', function() {
            $('#img-modal-review').attr('src', $(this).attr('src'));
            $('#reviewModal').modal('show')
        })
    </script>
@endpush
