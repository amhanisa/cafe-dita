@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Konsultasi</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Ubah Data Konsultasi Pasien</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ '/consultation/' . $consultation->id . '/edit' }}"
                                method="post">
                                @csrf
                                <input name="consultation_id" type="hidden" value="{{ $consultation->id }}">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nama Lengkap</label>
                                        <div class="col-md-8 col-lg-10 col-form-label">
                                            {{ $consultation->patient->name }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">NIK</label>
                                        <div class="col-md-8 col-lg-10 col-form-label">
                                            {{ $consultation->patient->nik }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nomer Rekam Medik</label>
                                        <div class="col-md-8 col-lg-10 col-form-label">
                                            {{ $consultation->patient->medical_record_number }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Tanggal Konsultasi</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input class="form-control form-control-lg @error('date') is-invalid @enderror"
                                                name="date" type="date" value="{{ $consultation->date }}">
                                            @error('date')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Sistol</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('systole') is-invalid @enderror"
                                                name="systole" type="number" value="{{ $consultation->systole }}">
                                            @error('systole')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Diastol</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('diastole') is-invalid @enderror"
                                                name="diastole" type="number" value="{{ $consultation->diastole }}">
                                            @error('diastole')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Obat</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('medicine') is-invalid @enderror"
                                                name="medicine" type="text" value="{{ $consultation->medicine }}">
                                            @error('medicine')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Keterangan</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input class="form-control form-control-lg @error('note') is-invalid @enderror"
                                                name="note" type="text" value="{{ $consultation->note }}">
                                            @error('note')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col offset-md-4 offset-lg-2">
                                            <div>
                                                <button class="btn btn-primary me-1 mb-1" type="submit">Simpan</button>
                                                <a class="btn btn-light-secondary me-1 mb-1"
                                                    href="{{ '/patient/' . $consultation->patient->id }}">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection

