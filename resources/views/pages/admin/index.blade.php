@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        {{-- section atas --}}
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-shop"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Caffe Aktif</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlah_cafe }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pengguna</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlah_user }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-message"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Review Diterima</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlah_review }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Kunjungan</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlah_visit }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12 pb-1">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>Pengunjung</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="form-group">
                                    <select name="cafe" id="input-cafe" class="form-control select2">
                                        @foreach ($cafe as $cs => $c)
                                            <option value="{{ $cs }}">{{ $c->cafe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-icon btn-primary" id="btn-search">
                                    <i class="fas fa-search"></i> Cari Data Caffe
                                </button>
                            </div>
                        </div>
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12 pb-1">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>Cafe Teratas</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled list-unstyled-border">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($cafe as $c)
                                @if ($i < 5)
                                    <li class="media">
                                        <img class="mr-3 rounded-circle" width="50" height="50"
                                            src="{{ asset($c->cafe->main_image) }}" alt="avatar">
                                        <div class="media-body">
                                            <div class="float-right text-primary pt-1">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $c->jumlah_visitor }}
                                            </div>
                                            <div class="media-title pr-3">{{ $c->cafe->name }}</div>
                                            <span class="text-small text-muted">{{ $c->cafe->address }}</span>
                                        </div>
                                    </li>
                                @endif
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.js') }}"></script>
    <script>
        var visitation = []
        @foreach ($cafe as $c)
            visitation.push({{ $c->visitation }})
        @endforeach

        let currVisit = visitation[0]
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
                datasets: [{
                    label: 'Total Pengunjung Mingguan',
                    data: currVisit,
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                }, ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            // display: false,
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: Math.ceil(Math.max(...currVisit) - Math.min(...currVisit) / 7),
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });

        $('#btn-search').on('click', function() {
            tempVisit = visitation[$('#input-cafe').val() - 1]
            myChart.data.datasets[0].data = tempVisit;
            myChart.options.scales.yAxes[0].ticks.stepSize = Math.ceil(Math.max(...tempVisit) - Math.min(...
                tempVisit) / 7)
            myChart.update();
        })
    </script>
@endpush
