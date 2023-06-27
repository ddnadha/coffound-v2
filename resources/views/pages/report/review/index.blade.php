@extends('layouts.app')

@section('title', 'Laporan Review')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Pelanggaran Review oleh Caffee</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Laporan Review</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Terlapor</th>
                                <th>Laporan</th>
                                <th>Waktu Laporan</th>
                                <th>Tindak Lanjut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($review as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->review->user->name }}</td>
                                    <td>
                                        @php
                                            $res = $r->review->messages->first();
                                        @endphp
                                        {{ $res->message }}
                                        <br>
                                        @foreach ($res->image as $image)
                                            <img class="img-review" src="{{ asset($image->img) }}" alt=""
                                                height="100" width="100">
                                        @endforeach

                                        <br><br>
                                        <b>Laporan :</b>
                                        <br>
                                        {{ $r->message }}
                                    </td>
                                    <td>
                                        {{ $r->created_at->diffForHumans() }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.review.destroy', $r) }}" method="POST">
                                            @csrf
                                            <a href="{{ route('admin.review.show', $r) }}"
                                                class="btn btn-icon btn-warning ">
                                                <i class="fas fa-exclamation-circle mr-1"></i> Suspend
                                            </a>
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-icon btn-danger"
                                                onclick="confirm('Apakah anda yakin ingin menghapus data ini ?')"
                                                type="submit">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @include('components.modal')
@endsection

@push('scripts')
    <script>
        $('.table-datatable').DataTable()
        $('.img-review').on('click', function() {
            $('#img-modal-review').attr('src', $(this).attr('src'));
            $('#reviewModal').modal('show')
        })
    </script>
@endpush
