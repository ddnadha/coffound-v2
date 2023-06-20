@extends('layouts.app')

@section('title', 'Laporan Review')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laporan Pelanggaran Caffee</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Laporan</h4>
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
                            @foreach ($report as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->user->name }}</td>
                                    <td>
                                        {{ $r->message }}
                                        <br>
                                        @foreach ($r->image as $image)
                                            <img src="{{ asset($image->img) }}" alt="" height="100" width="100">
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $r->created_at->diffForHumans() }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.report.destroy', $r) }}" method="POST">
                                            @csrf
                                            <a href="{{ route('admin.report.show', $r) }}"
                                                class="btn btn-icon btn-warning btn-sm">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirm('Apakah anda yakin ingin menghapus data ini ?')"
                                                type="submit">
                                                <i class="fas fa-trash"></i>
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
@endsection

@push('scripts')
    <script>
        $('.table-datatable').DataTable()
    </script>
@endpush
