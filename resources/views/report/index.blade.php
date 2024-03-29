@extends('layouts.app')

@push('style-before')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.0/apexcharts.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <h3>Laporan</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter</h4>
                    </div>
                    <div class="card-body">
                        @include('report.form')
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
                            <form action="{{ url('report/export') }}">
                                <input name="start_date" type="hidden" value="{{ $startDate }}">
                                <input name="end_date" type="hidden" value="{{ $endDate }}">
                                <button class="btn btn-primary mb-3">Unduh Laporan</button>
                            </form>
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
        var villagesName = @json($villagesName);

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
                categories: villagesName
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
