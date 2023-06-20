@extends('layouts.mobile')

@section('title', 'Coffound')

@section('nav')
    <b>Lokasi</b> <br>
    Surabaya, Indonesia
@endsection

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-body">
                <div class="col-12 mb-4">
                    <div class="hero text-white hero-bg-image force-round-15"
                        style="background-image: linear-gradient(rgba(4, 32, 72, 0.5), rgba(4, 32, 72, 0.5)), url('https://awsimages.detik.net.id/community/media/visual/2022/05/24/demandailing-cafe_11.jpeg?w=700&q=90');">
                        <div class="hero-inner force-round-15">
                            <h2>Temukan tempat ngopi favorit anda dengan Coffound</h2>
                            <div class="mt-3">
                                <a href="#" class="btn btn-primary btn-rounded btn-no-shadow">
                                    Cari Cafe
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mb-3">
                    <div class="col-12 mb-2">
                        <h5 class="text-dark px-1">Cafe Terdekat</h5>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="switcher">
                            <div class="wrapper my-1 ">
                                <div class="taeb-switch left" style="text-align: center; display: flex;">
                                    <div class="taeb active" style="justify-content: center;" taeb-direction="left">Indoor
                                    </div>
                                    <div class="taeb" style="justify-content: center;" taeb-direction="right">Outdoor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mx-3" id="cafe-container">
                </div>
                <br>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#nav-item-home').addClass('nav-item-bottom-active')
        let category = 'indoor'
        let latLong = undefined
        $(function() {
            var taeb = $(".taeb-switch");
            taeb.find(".taeb").on("click", function() {
                var $this = $(this);

                if ($this.hasClass("active")) return;
                category = $this.html()
                var direction = $this.attr("taeb-direction");

                taeb.removeClass("left right").addClass(direction);
                taeb.find(".taeb.active").removeClass("active");
                $this.addClass("active");

                if (latLong != undefined) getCafe(latLong, category)
            });
        });
        navigator.geolocation.getCurrentPosition(function(position) {
            latLong = [position.coords.latitude, position.coords.longitude]
            getCafe(latLong, category)
        });

        function getCafe(latLong, category) {
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/cafe') }}?lat=${latLong[0]}&lng=${latLong[1]}&category=${category.toLowerCase()}`,
                async: false,
                dataType: 'json',
                success: function(result) {
                    console.log(result)
                    let _html = '';
                    $.each(result.data, function(i, val) {
                        let _name = val.name.length > 29 ? val.name.slice(0, 29) + `...` : val.name
                        _html += `
                        <div class="col-6 col-md-3 col-sm-6 p-1" style="max-height: 295px">
                        <div class="card h-100 card-body-cafe force-round-15">
                            <div class="card-header card-header-image"
                                style="background-image: linear-gradient( rgba(4, 32, 72, 0), rgba(4, 32, 72, 0) ), url('${val.img}');">
                            </div>
                            <div class="card-body pt-3 pl-1 pr-1 text-dark card-body-cafe">
                                <div style="height: 2.5rem">
                                    <strong>${_name}</strong>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-2 pl-3">
                                        <i class="fas fa-location-dot text-primary"></i>
                                    </div>
                                    <div class="col-9 px-2">
                                        ${val.district.name.charAt(0).toUpperCase() + val.district.name.slice(1).toLowerCase()}
                                    </div>
                                    <div class="col-2 pl-3 pt-1">
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <div class="col-9 px-2 pt-1">
                                        ${val.rating}
                                    </div>
                                </div>
                                <div class="w-100 container-button-cafe">
                                    <a href="{{ route('caffee.show') }}/${val.name.replace(" ", "_")}" class="btn btn-primary btn-icon float-right mr-1 force-round-20">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>`
                    })
                    $('#cafe-container').html(_html)
                }
            });
        }
    </script>
@endpush
@push('style')
    <style>
        .main-content {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    </style>
@endpush
