@extends('layouts.app')

@push('style-before')
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.0/apexcharts.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <h3>Detail Pasien</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div>
                            <div class="row">
                                <div class="col-lg-8">

                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Nama</div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Nomor Rekam
                                            Medis
                                        </div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->medical_record_number }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">NIK</div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->nik }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Tanggal
                                            Lahir</div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->birthday }}
                                            ({{ \Carbon\Carbon::parse($patient->birthday)->age }} tahun)
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Jenis
                                            Kelamin</div>
                                        <div class="col-12 col-md-6 text-black">
                                            @if ($patient->sex == 'L')
                                                Laki - laki
                                            @else
                                                Perempuan
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Alamat</div>
                                        <div class="col-12 col-md-6 text-black">
                                            {{ $patient->address . ', Desa ' . $patient->village->name }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Pekerjaan
                                        </div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->job }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Nomor
                                            Telepon</div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->phone_number }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        @if ($treatmentStatus)
                                            <div class="callout callout-info d-flex justify-content-between mb-3">
                                                <span class="text-sm fw-bold text-uppercase text-muted">
                                                    Status Berobat
                                                </span>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-uppercase text-end">
                                                        Teratur
                                                    </span>
                                                    <span class="check-icon ms-2"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="callout callout-danger d-flex justify-content-between mb-3">
                                                <span class="text-sm fw-bold text-uppercase text-muted">
                                                    Status Berobat
                                                </span>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-uppercase text-end">
                                                        Tidak Teratur
                                                    </span>
                                                    <span class="exclamation-icon ms-2"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        @if ($hypertensionStatus)
                                            <div class="callout callout-danger d-flex justify-content-between mb-3">
                                                <span class="text-sm fw-bold text-uppercase text-muted">
                                                    Status Hipertensi
                                                </span>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-uppercase text-end">Tidak Terkendali</span>
                                                    <span class="exclamation-icon ms-2"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="callout callout-info d-flex justify-content-between mb-3">
                                                <span class="text-sm fw-bold text-uppercase text-muted">
                                                    Status Hipertensi
                                                </span>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-bold text-uppercase text-end">
                                                        Terkendali
                                                    </span>
                                                    <span class="check-icon ms-2"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row justify-content-between mb-3">
                                        <h6 class="text-muted">Action</h6>
                                        <div class="col-6">
                                            <a class="btn btn-block btn-secondary"
                                                href="{{ url('/patient/' . $patient->id . '/edit') }}">
                                                Edit Pasien
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <form id="delete-form" action="{{ url('patient/delete') }}" method="POST">
                                                @csrf
                                                <input name="id" type="hidden" value="{{ $patient->id }}">
                                            </form>
                                            <button class="btn btn-block btn-danger" id="delete-patient">
                                                Hapus Pasien
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            Riwayat Tensi
                        </h4>
                        <button
                            class="btn btn-outline-secondary button-collapse d-flex justify-content-center align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#riwayat-tensi" type="button" aria-expanded="false"
                            aria-controls="riwayat-tensi">
                            <i class="collapse-icon"></i>
                        </button>
                    </div>
                    <div class="card-body collapse" id="riwayat-tensi">
                        <div id="area"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                Riwayat Konsultasi
                            </h4>
                            <button
                                class="btn btn-outline-secondary button-collapse d-flex justify-content-center align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#riwayat-konsultasi" type="button"
                                aria-expanded="false" aria-controls="riwayat-konsultasi">
                                <i class="collapse-icon"></i>
                            </button>
                        </div>
                        <div class="card-body collapse" id="riwayat-konsultasi" width="100%">
                            <a class="btn btn-primary mb-3" href="{{ '/consultation/' . $patient->id . '/add' }}">Tambah
                                Konsultasi</a>
                            <div class="table-responsive">
                                <table class="table" id="consultations-table" width="100%">
                                    <thead>
                                        <th>No.</th>
                                        <th>Tanggal Konsultasi</th>
                                        <th>Tensi Darah
                                            <br>
                                            <span class="small fw-light">(mmHg)</span>
                                        </th>
                                        <th>Obat</th>
                                        <th>Keterangan</th>
                                        <th style="white-space: nowrap">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($consultations as $consultation)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $consultation->date }}</td>
                                                <td>{{ $consultation->systole . '/' . $consultation->diastole }}</td>
                                                <td>{{ $consultation->medicine }}</td>
                                                <td>{{ $consultation->note }}</td>
                                                <td style="white-space: nowrap">
                                                    <a class="btn btn-secondary"
                                                        href="{{ '/consultation/' . $consultation->id . '/edit' }}">
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-danger delete-consultation"
                                                        data-id="{{ $consultation->id }}">Hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form id="delete-consultation-form" action="{{ url('/consultation/delete') }}"
                                    method="post">
                                    @csrf
                                    <input name="consultation_id" type="hidden">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            Riwayat Kebiasaan
                        </h4>
                        <button
                            class="btn btn-outline-secondary button-collapse d-flex justify-content-center align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#riwayat-kebiasaan" type="button"
                            aria-expanded="false" aria-controls="riwayat-kebiasaan">
                            <i class="collapse-icon"></i>
                        </button>
                    </div>
                    <div class="card-body collapse" id="riwayat-kebiasaan">
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2">
                                <div class="input-group mb-3">
                                    <label class="input-group-text">Tahun</label>
                                    <select class="form-select" id="habit-selector">
                                        <option>2023</option>
                                        <option>2022</option>
                                        <option>2021</option>
                                        <option>2020</option>
                                        <option>2019</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="min-width: 180px;" rowspan="2">Kebiasaan</th>
                                        <th colspan="4">
                                            Januari
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=1') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Februari
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=2') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Maret
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=3') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            April
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=4') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Mei
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=5') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Juni
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=6') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Juli
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=7') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Agustus
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=8') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            September
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=9') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Oktober
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=10') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            November
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=11') }}">
                                                edit
                                            </a>
                                        </th>
                                        <th colspan="4">
                                            Desember
                                            <br>
                                            <a class="small fw-lighter"
                                                href="{{ url('patient-habit/edit?patient=' . $patient->id . '&year=' . $year . '&month=12') }}">
                                                edit
                                            </a>
                                        </th>

                                    </tr>
                                    <tr>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patientHabits as $habit)
                                        <tr>
                                            <td>{{ $habit->name }}</td>
                                            @php($counter = 0)
                                            @for ($i = 0; $i < 12; $i++)
                                                @isset($habit->patientHabits[$counter])
                                                    @if ($habit->patientHabits[$counter]->month == $i + 1)
                                                        @for ($j = 1; $j <= 4; $j++)
                                                            @if (is_null($habit->patientHabits[$counter]->{"week$j"}))
                                                                <td class="p-0">
                                                                </td>
                                                            @elseif ($habit->patientHabits[$counter]->{"week$j"} == true)
                                                                <td class="p-0">
                                                                    <div class="true-icon"></div>
                                                                </td>
                                                            @else
                                                                <td class="p-0">
                                                                    <div class="false-icon"></div>
                                                                </td>
                                                            @endif
                                                        @endfor
                                                        @php($counter++)
                                                    @else
                                                        <td class="p-0"> </td>
                                                        <td class="p-0"> </td>
                                                        <td class="p-0"> </td>
                                                        <td class="p-0"> </td>
                                                    @endif
                                                @else
                                                    <td class="p-0"> </td>
                                                    <td class="p-0"> </td>
                                                    <td class="p-0"> </td>
                                                    <td class="p-0"> </td>
                                                @endisset
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.0/apexcharts.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#consultations-table').DataTable({
                scrollX: true,
                language: {
                    emptyTable: "Belum ada data konsultasi"
                },
            });

            $('#delete-patient').click(function() {
                let form = $("#delete-form");
                event.preventDefault();
                Swal.fire({
                        title: `Apakah anda yakin menghapus data pasien ini?`,
                        text: "Jika anda menghapus, data tidak dapat dikembalikan",
                        icon: "warning",
                        buttons: true,
                        showCancelButton: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            form.submit();
                        }
                    });
            })

            $('.delete-consultation').click(function() {
                let form = $("#delete-consultation-form");
                let consultation_id = $(this).data('id');
                event.preventDefault();
                Swal.fire({
                        title: `Apakah anda yakin menghapus data konsultasi ini?`,
                        text: "Jika anda menghapus, data tidak dapat dikembalikan",
                        icon: "warning",
                        buttons: true,
                        showCancelButton: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            $('input[name="consultation_id"]').val(consultation_id);
                            form.submit();
                        }
                    });
            })
        });

        let patientId = "{{ $patient->id }}"

        let s = @json($systole);
        let d = @json($diastole);
        let dt = @json($date);

        var areaOptions = {
            series: [{
                name: 'Sistol',
                data: s,
                color: '#2E93fA'
            }, {
                name: 'Diastol',
                data: d,
                color: '#66DA26'
            }],
            chart: {
                height: 350,
                type: "line",
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "straight",
                width: 2,
            },
            annotations: {
                yaxis: [{
                        y: 140,
                        borderColor: '#febc3b',
                        borderWidth: 1,
                        opacity: 1,
                        strokeDashArray: 10,
                        label: {
                            position: 'left',
                            offsetX: 75,
                            borderColor: '#febc3b',
                            style: {
                                color: '#fff',
                                background: '#febc3b'
                            },
                            text: 'Batas Sistol'
                        }
                    },
                    {
                        y: 90,
                        borderColor: '#febc3b',
                        borderWidth: 1,
                        opacity: 0.3,
                        strokeDashArray: 10,
                        label: {
                            position: 'left',
                            offsetX: 75,
                            borderColor: '#febc3b',
                            style: {
                                color: '#fff',
                                background: '#febc3b'
                            },
                            text: 'Batas Diastol',
                        }
                    }
                ]
            },
            markers: {
                size: 5,
                strokeColors: '#fff',
                strokeWidth: 2,
                strokeOpacity: 0.9,
                strokeDashArray: 0,
                fillOpacity: 1,
                discrete: [],
                shape: "circle",
                radius: 2,
                offsetX: 0,
                offsetY: 0,
                showNullDataPoints: true,
                hover: {
                    size: undefined,
                    sizeOffset: 3
                }
            },
            xaxis: {
                type: "datetime",
                categories: dt
            },
            tooltip: {
                x: {
                    format: "dd MMMM yyyy",
                },
            },
            noData: {
                text: 'Belum ada data konsultasi'
            }
        }

        var area = new ApexCharts(document.querySelector("#area"), areaOptions)
        area.render()

        const year = "{{ $year }}";

        $('#habit-selector').val(year).change();

        $('#habit-selector').change(function() {
            const link = window.location.href.split('?')[0] + '?year=' + this.value;
            window.location.replace(link);
        })


        $(".collapse").on("shown.bs.collapse", function() {
            localStorage.setItem("coll_" + this.id, true);
            console.log('SHOW ' + this.id);
            $.each($.fn.dataTable.tables(true), function() {
                $(this).DataTable().columns.adjust().draw();
            });
        });

        $(".collapse").on("hidden.bs.collapse", function() {
            localStorage.removeItem("coll_" + this.id);
            console.log('HIDE' + this.id);
        });

        $(".collapse").each(function() {
            console.log('EACH ' + this.id);
            if (localStorage.getItem("coll_" + this.id) === "true") {
                $(this).addClass("show");
            } else {
                $("button[data-bs-target='#" + this.id + "']").addClass('collapsed');
                $(this).addClass("hide");
            }
        });
    </script>
@endpush
