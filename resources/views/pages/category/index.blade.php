@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kategori</h1>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Kategori</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.category.create') }}" class="btn btn-icon btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kategori</th>
                                <th>Icon</th>
                                <th>Penggunaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td><i class="{{ $c->icon }}"></i></td>
                                    <td>
                                        {{ $c->cafes->count() }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.category.destroy', $c) }}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <a href="{{ route('admin.category.edit', $c) }}"
                                                class="btn btn-warning btn-sm btn-icon">
                                                <i class="fas fa-pencil"></i>
                                            </a>
                                            <button class="btn btn-icon btn-sm btn-danger"
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
