@extends('layouts.app')

@push('style-before')
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" rel="stylesheet">
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
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Nomer Rekam
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
                                            ({{ \Carbon\Carbon::parse($patient->birthday)->age }}
                                            tahun)</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Alamat</div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->address }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Pekerjaan
                                        </div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->job }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-3 text-muted font-semibold">Nomer
                                            Telepon</div>
                                        <div class="col-12 col-md-6 text-black">{{ $patient->phone_number }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <h6 class="text-muted">Status Berobat</h6>
                                        <button class="btn btn-block btn-outline-success">Berobat Teratur</button>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="text-muted">Status Hipertensi</h6>
                                        <button class="btn btn-block btn-outline-success">Terkendali</button>
                                    </div>
                                    <div class="row justify-content-between mb-3">
                                        <h6 class="text-muted">Action</h6>
                                        <div class="col-6">

                                            <a class="btn btn-block btn-secondary"
                                                href="{{ '/consultation/' . $patient->id . '/add' }}">
                                                Edit Pasien</a>
                                        </div>
                                        <div class="col-6">

                                            <a class="btn btn-block btn-danger"
                                                href="{{ '/consultation/' . $patient->id . '/add' }}">
                                                Hapus Pasien</a>
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
                    <div class="card-body">
                        <h4>
                            Riwayat Tensi
                        </h4>
                        <div id="area"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <a class="btn btn-primary" href="{{ '/consultation/' . $patient->id . '/add' }}">Tambah
                                    Konsultasi</a>
                            </div>
                            <table class="table" id="consultations-table">
                                <thead>
                                    <th>Tanggal Konsultasi</th>
                                    <th>Tensi Darah
                                        <br>
                                        <span class="small fw-light">(mmHg)</span>
                                    </th>
                                    <th>Obat</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2022-10-01</td>
                                        <td>190/100</td>
                                        <td>Paracetamol x3</td>
                                        <td>Edit</td>
                                    </tr>
                                    <tr>
                                        <td>2022-10-01</td>
                                        <td>190/100</td>
                                        <td>Paracetamol x3</td>
                                        <td>Edit</td>
                                    </tr>
                                    <tr>
                                        <td>2022-10-01</td>
                                        <td>190/100</td>
                                        <td>Paracetamol x3</td>
                                        <td>Edit</td>
                                    </tr>
                                    <tr>
                                        <td>2022-10-01</td>
                                        <td>190/100</td>
                                        <td>Paracetamol x3</td>
                                        <td>Edit</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            Riwayat Kebiasaan
                        </h4>
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-4 col-xl-4 col-xxl-2">
                                <div class="input-group mb-3">
                                    <label class="input-group-text">Tahun</label>
                                    <select class="form-select">
                                        <option selected>2022</option>
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
                                        <th colspan="4">Januari</th>
                                        <th colspan="4">Februari</th>
                                        <th colspan="4">Maret</th>
                                        <th colspan="4">April</th>
                                        <th colspan="4">Mei</th>
                                        <th colspan="4">Juni</th>
                                        <th colspan="4">Juli</th>
                                        <th colspan="4">Agustus</th>
                                        <th colspan="4">September</th>
                                        <th colspan="4">Oktober</th>
                                        <th colspan="4">November</th>
                                        <th colspan="4">Desember</th>
                                    </tr>
                                    <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Makan Sayur & Buah</td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Olahraga</td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tidak Merokok</td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Minum Obat Rutin</td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="false-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                        <td class="p-0">
                                            <div class="true-icon"></div>
                                        </td>
                                    </tr>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.36.0/apexcharts.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#consultations-table').DataTable({
                // serverSide: true,
                // processing: true,
                // responsive: true,
                // ajax: 'patient',
                // dataSrc: 'data',
                // columns: [{
                //     data: 'name'
                // }, {
                //     data: 'medical_record_number'
                // }, {
                //     data: 'nik'
                // }, {
                //     data: 'sex'
                // }, {
                //     data: 'birthday'
                // }, {
                //     data: 'address'
                // }, {
                //     data: 'village'
                // }, {
                //     data: 'job'
                // }, {
                //     data: 'phone_number'
                // }, {
                //     data: 'action',
                //     orderable: false,
                //     searchable: false,
                // }]
            });
        });

        var areaOptions = {
            series: [{
                    name: "Sistol",
                    data: [160, 130, 145, 155, 150, 145, 150],
                    color: '#2E93fA'
                },
                {
                    name: "Diastol",
                    data: [80, 85, 95, 90, 85, 100, 95],
                    color: '#66DA26'
                },
            ],
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
                        borderWidth: 2,
                        opacity: 1,
                        strokeDashArray: 10,
                        label: {
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
                categories: [
                    "2018-09-01T00:00:00.000Z",
                    "2018-09-19T01:30:00.000Z",
                    "2018-09-20T02:30:00.000Z",
                    "2018-09-22T03:30:00.000Z",
                    "2018-09-30T04:30:00.000Z",
                    "2018-10-19T05:30:00.000Z",
                    "2018-11-19T06:30:00.000Z",
                ],
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy HH:mm",
                },
            },
        }
        var area = new ApexCharts(document.querySelector("#area"), areaOptions)

        area.render()
    </script>
@endpush

