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
                            <h4>Foto Cafe</h4>
                            <div class="card-header-action">
                                <button id="btnSave" type="button" class="btn btn-primary btn-icon">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('owner.image.store', $cafe) }}" method="POST"
                                enctype="multipart/form-data" class="dropzone" id="mydropzone">
                                @csrf
                                <div class="fallback">
                                    <input name="file[]" type="file" multiple />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('library/dropzone/dist/dropzone.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('library/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script>
        if (window.Dropzone) {
            Dropzone.autoDiscover = false;
        }
        var dropzone = new Dropzone("#mydropzone", {
            paramName: 'file',
            url: "{{ route('owner.image.store', $cafe) }}",
            addRemoveLinks: true,
            autoProcessQueue: false,
            acceptedFiles: 'image/*',
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,
            dictRemoveFile: "Hapus Gambar",
            params: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            init: function() {
                var myDropzone = this;
                document.getElementById("btnSave").addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    for (let index = 0; index < myDropzone.files.length; index++) {
                        const element = myDropzone.files[index];
                        var imagename = element.name.split('.').pop().toLowerCase();
                        if ($.inArray(imagename, ['png', 'jpg', 'jpeg']) == -1) {
                            $('#data-alert-upload').html(
                                `<div class="alert alert-danger" role="alert"> Tipe gambar wajib png, jpg, jpeg</div>`
                            )
                            return false;
                        }
                        console.log('bisa')
                    }
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    console.log("Sending file:", file);
                    console.log("Sending formData:", formData);
                });
                this.on("queuecomplete", function() {
                    console.log('queuecomplete');
                });

                this.on("success", function(files, response) {
                    console.log(files, response);
                });

                this.on("successmultiple", function(files, response) {
                    console.log('successmultiple');
                    iziToast.success({
                        title: 'Berhasil',
                        message: "Berhasil menambahkan foto kafe",
                        position: 'topRight',
                        onClosed: function() {
                            window.location.replace(
                                "{{ route('owner.image.index', [$cafe]) }}");
                        }
                    });
                });
                this.on("errormultiple", function(files, response) {
                    console.log("errormultiple")
                });
            }
        });

        var minSteps = 6,
            maxSteps = 60,
            timeBetweenSteps = 100,
            bytesPerStep = 100000;
    </script>
@endpush
