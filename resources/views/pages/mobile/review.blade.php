@extends('layouts.nonavmobile')

@section('title', 'Berikan Review Anda')
@section('main')
    <div class="main-section mt-3">
        <section class="section">
            <div class="section-body">
                <div class="container text-center py-2 mb-4 mt-2">
                    <i class="fas fa-arrow-left" style="float: left; margin-left: 5px; margin-top: 5px"
                        onclick="history.back()"></i>
                    {{ $cafe->name }}
                </div>
                <div class="container px-5">
                    <div class="d-flex">
                        <div class="reviewer-profile"></div>
                        <div class="w-100" style="vertical-align: middle">
                            <h6 style="line-height: 40px; margin-left: 15px">{{ auth()->user()->name }}</h6>
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-around mb-2" style="padding-left: 40px">
                        <i class="far fa-star star-review" data-order="1" style="color: #FCB425;"></i>
                        <i class="far fa-star star-review" data-order="2" style="color: #FCB425;"></i>
                        <i class="far fa-star star-review" data-order="3" style="color: #FCB425;"></i>
                        <i class="far fa-star star-review" data-order="4" style="color: #FCB425;"></i>
                        <i class="far fa-star star-review" data-order="5" style="color: #FCB425;"></i>
                    </div>
                    <form method="POST" class="mt-4 w-100" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="rate">
                        <div class="form-group mb-2">
                            <label class="mb-2" for="review">Bagikan pengalaman anda di cafe ini</label>
                            <textarea style="font-size: 12px; height: 75px" class="form-control" name="review" id="review" rows="3"></textarea>
                        </div>
                        <div class="my-2">
                            <div class="wrapper">
                                <div class="photo_submit-container">
                                    <div class="photo_submit-container ">
                                        <label class="photo_submit js-photo_submit1">
                                            <input class="photo_submit-input js-photo_submit-input" type="file"
                                                accept="image/*" name="image[]" />
                                            <span class="photo_submit-plus"></span>
                                            {{-- <span class="photo_submit-uploadLabel">Upload photo</span> --}}
                                            <span class="photo_submit-delete"></span>
                                        </label>
                                        <label class="photo_submit js-photo_submit2">
                                            <input class="photo_submit-input js-photo_submit-input" type="file"
                                                accept="image/*" name="image[]" />
                                            <span class="photo_submit-plus"></span>
                                            {{-- <span class="photo_submit-uploadLabel">Upload photo</span> --}}
                                            <span class="photo_submit-delete"></span>
                                        </label>
                                        <label class="photo_submit js-photo_submit3">
                                            <input class="photo_submit-input js-photo_submit-input" type="file"
                                                accept="image/*" name="image[]" />
                                            <span class="photo_submit-plus"></span>
                                            {{-- <span class="photo_submit-uploadLabel">Upload photo</span> --}}
                                            <span class="photo_submit-delete"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary  mb-2">
                            Kirim Review
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('style')
    <style>
        .reviewer-profile {
            height: 40px;
            width: 40px;
            background-image: url('{{ asset(auth()->user()->img) }}');
            background-size: cover;
            background-position: center;
            border-radius: 30px
        }

        .fa-star {
            font-size: 24px
        }

        .btn {
            font-size: 12px;
            font-weight: 400;
            width: 100%;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 100px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/fileupload.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/fileupload.js') }}"></script>
    <script>
        $('.star-review').click(function() {
            let _this = {}
            _this.order = $(this).attr('data-order')
            $('input[name="rate"]').val(_this.order)

            for (var i = 1; i <= 5; i++) {
                let star = $(`.star-review[data-order=${i}]`)
                if (i <= _this.order) {
                    star.removeClass('far')
                    star.addClass('fas')
                } else {
                    star.removeClass('fas')
                    star.addClass('far')
                }

            }
        })
    </script>
@endpush
