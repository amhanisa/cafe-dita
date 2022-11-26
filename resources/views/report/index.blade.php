@extends('layouts.app')

@push('style-before')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.0/apexcharts.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">

                        </div>
                        <form action="{{ url('report') }}" method="get">
                            <div class="row justify-content-center">
                                <div class="col-lg-6">

                                    <div class="row mb-3">

                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Tanggal Awal</span>
                                                <input class="form-control" name="start_date" type="date"
                                                    value="{{ request()->get('start_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Tanggal Akhir</span>
                                                <input class="form-control" name="end_date" type="date"
                                                    value="{{ request()->get('end_date') }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Batas Usia Bawah</span>
                                                <input class="form-control" name="min_age" type="number"
                                                    value="{{ request()->get('min_age') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Batas Usia Atas</span>
                                                <input class="form-control" name="max_age" type="number"
                                                    value="{{ request()->get('max_age') }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3 justify-content-center">
                                        <div class="col-md-6">
                                            <input class="btn btn-block btn-primary" type="submit" value="Cari">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="bar"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-primary mb-3" href="/report/export">Unduh Laporan</a>
                        </div>
                        @include('report.table')
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.0/apexcharts.min.js"></script>
    <script>
        var a = @json($hypertensionCountPerVillage);
        var b = @json($notHypertensionCountPerVillage);
        var c = @json($routineTreatmentCountPerVillage);
        var d = @json($notRoutineTreatmentCountPerVillage);

        var barOptions = {
            series: [{
                    name: "Berobat Tidak Teratur",
                    data: d,
                    color: '#feb019',
                },
                {
                    name: "Berobat Teratur",
                    data: c,
                    color: '#008ffb'
                },
                {
                    name: "Tidak Terkendali",
                    data: a,
                    color: '#ff4560'
                },
                {
                    name: "Terkendali",
                    data: b,
                    color: '#00e396'
                },
            ],
            chart: {
                type: "bar",
                height: 350,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
            },
            xaxis: {
                categories: ["Buluagung", "Jati", "Jatiprahu", 'Karangan', 'Kayen', 'Kedungsigit', 'Kerjo', 'Ngentrong',
                    'Salamrejo', 'Sukowetan', 'Sumber', 'Sumberingin'
                ],
            },
            yaxis: {
                title: {
                    text: "jumlah penderita",
                },
            },
            fill: {
                opacity: 1,
            },
        }
        var bar = new ApexCharts(document.querySelector("#bar"), barOptions);
        bar.render();
    </script>
@endpush

