@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Caffee</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Caffee</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-datatable">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Domisili</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cafe as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $c->name }}
                                    </td>
                                    <td>
                                        {{ $c->address }}
                                    </td>
                                    <td><b>{{ ucfirst(strtolower($c->district->name)) }}</b></td>
                                    <td class="text-center">
                                        @if ($c->status == 'active')
                                            <div class="badge badge-success">
                                                <i class="fas fa-check mr-1"></i> Active
                                            </div>
                                        @else
                                            <div class="badge badge-warning">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                {{ $c->status }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.cafe.destroy', $c) }}" method="POST">
                                            @csrf
                                            @if ($c->status != 'active')
                                                <a href="{{ route('admin.cafe.show', $c) }}"
                                                    class="btn btn-icon btn-primary btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.cafe.show', $c) }}"
                                                    class="btn btn-icon btn-warning btn-sm">
                                                    <i class="fas fa-ban"></i>
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
