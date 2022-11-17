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

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Tanggal Awal</span>
                                                <input class="form-control" name="start_date" type="date"
                                                    value="{{ request()->get('start_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Tanggal Awal</span>
                                                <input class="form-control" name="end_date" type="date"
                                                    value="{{ request()->get('end_date') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Umur Awal</span>
                                                <input class="form-control" name="min_age" type="number"
                                                    value="{{ request()->get('min_age') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Umur Akhir</span>
                                                <input class="form-control" name="max_age" type="number"
                                                    value="{{ request()->get('max_age') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="btn btn-block btn-primary" type="submit" value="Cari">
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
                    <div class="card-header">
                        <h4>Bar Chart</h4>
                    </div>
                    <div class="card-body">
                        <div id="bar"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Dashboard</h4>
                        <a class="btn btn-primary mb-3" href="/report/export">Unduh Laporan</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
        var barOptions = {
            series: [{
                    name: "Berobat Teratur",
                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
                },
                {
                    name: "Berobat Tidak Teratur",
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
                },
                {
                    name: "Terkendali",
                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
                },
                {
                    name: "Tidak Terkendali",
                    data: [35, 42, 3, 6, 5, 8, 54, 57, 45],
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
                colors: ["transparent"],
            },
            xaxis: {
                categories: ["Desa 1", "Desa 2", "Desa 3", "Desa 4", "Desa 5", "Desa 6", "Desa 7", "Desa 8", "Desa 9"],
            },
            yaxis: {
                title: {
                    text: "$ (thousands)",
                },
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands"
                    },
                },
            },
        }
        var bar = new ApexCharts(document.querySelector("#bar"), barOptions);
        bar.render();
    </script>
@endpush

