@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <section class="section">
        <div class="section-header">Kategori</div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Kategori</h4>

                </div>
                <div class="card-body">
                    <div class="col-md-6">
                        <form
                            action="{{ !isset($category) ? route('admin.category.store') : route('admin.category.update', $category) }}"
                            method="POST">
                            @if (isset($category))
                                {{ method_field('PUT') }}
                            @endif
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Kategori</label>
                                <input type="text" class="form-control" name="name" id="name" required
                                    value="{{ @$category->name }}">
                            </div>
                            <div class="form-group">
                                <label for="icon">Icon (Font Awesome Icon)</label>
                                <input type="text" class="form-control" name="icon" placeholder="fas fa-home"
                                    id="icon" value="{{ @$category->icon }}">
                            </div>
                            <button type="submit" class="btn btn-primary float-right btn-icon">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
