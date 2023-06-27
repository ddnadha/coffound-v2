@extends('layouts.app')

@section('title', 'Buka Suspend')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Permintaan Buka Suspend Kafe</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Permintaan</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Kafe</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Tgl Ajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($act as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $c->cafe->name }}</td>
                                    <td>{{ $c->reason }}</td>
                                    <td class="text-center">
                                        @if ($c->status == 'pending')
                                            <div class="badge badge-warning">Menunggu</div>
                                        @elseif ($c->status == 'accepted')
                                            <div class="badge badge-success">Diterima</div>
                                        @elseif ($c->status == 'rejected')
                                            <div class="badge badge-danger">Ditolak</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $c->created_at->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-icon btn-primary"
                                            href="{{ url('/mobile/caffee') }}/{{ str_replace(' ', '_', $c->cafe->name) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($c->status == 'pending')
                                            <a class="btn btn-icon btn-success"
                                                href="{{ route('admin.activation.show', $c) }}?action=1">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a class="btn btn-icon btn-danger"
                                                href="{{ route('admin.activation.show', $c) }}?action=0">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
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
