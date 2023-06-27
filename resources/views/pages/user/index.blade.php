@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>User</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data User</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Jumlah Cafe</th>
                                <th>Tgl Daftar</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        <div class="d-flex justify-content-start">
                                            <img src="{{ asset($u->img) }}" alt="" class="rounded-circle mr-3"
                                                width="32" height="32">
                                            <div class="d-flex flex-column">
                                                <b>{{ $u->name }}</b>
                                                <span>{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($u->priv == 'admin')
                                            <div class="badge badge-warning">
                                                <i class="fas fa-user-cog mr-1"></i> Admin
                                            </div>
                                        @elseif($u->priv == 'pemilik_cafe')
                                            <div class="badge badge-success">
                                                <i class="fas fa-store mr-1"></i> Pemilik Cafe
                                            </div>
                                        @else
                                            <div class="badge badge-primary">
                                                <i class="fas fa-users mr-1"></i>
                                                Pengunjung
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $u->cafe->count() }} Kafe
                                    </td>
                                    <td class="text-center">
                                        {{ $u->created_at->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($u->status == 'active')
                                            <div class="badge badge-success">
                                                <i class="fas fa-user-cog mr-1"></i> Active
                                            </div>
                                        @else
                                            <div class="badge badge-danger">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $u->status }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.user.destroy', $u) }}" method="POST">
                                            @csrf
                                            @if ($u->status == 'active')
                                                <a href="{{ route('admin.user.show', $u) }}"
                                                    class="btn btn-icon btn-warning btn-sm">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.user.show', $u) }}"
                                                    class="btn btn-icon btn-success btn-sm">
                                                    <i class="fas fa-power-off"></i>
                                                </a>
                                            @endif

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
