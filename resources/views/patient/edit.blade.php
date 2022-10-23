@extends('layouts.app')

@push('style-before')
    <link href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-heading">
        <h3>Pasien</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Ubah Data Pasien</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ url('patient/' . $patient->id . '/edit') }}"
                                method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nama Lengkap</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input class="form-control form-control-lg @error('name') is-invalid @enderror"
                                                name="name" type="text" value="{{ $patient->name }}">
                                            @error('name')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">NIK</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input class="form-control form-control-lg @error('nik') is-invalid @enderror"
                                                name="nik" type="text" value="{{ $patient->nik }}">
                                            @error('nik')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nomer Rekam Medik</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('medical_record_number') is-invalid @enderror"
                                                name="medical_record_number" type="text"
                                                value="{{ $patient->medical_record_number }}">
                                            @error('medical_record_number')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Tanggal Lahir</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('birthday') is-invalid @enderror"
                                                name="birthday" type="date" value="{{ $patient->birthday }}">
                                            @error('birthday')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <fieldset class="row mb-3">
                                        <legend class="col-form-label col-md-4 col-lg-2 pt-0">Jenis Kelamin</legend>
                                        <div class="col-md-8 col-lg-10">
                                            <div class="form-check">
                                                <input class="form-check-input" name="sex" type="radio" value="L"
                                                    {{ $patient->sex == 'L' ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    Laki-laki
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="sex" type="radio" value="P"
                                                    {{ $patient->sex == 'P' ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    Perempuan
                                                </label>
                                            </div>
                                            @error('sex')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </fieldset>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Alamat</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('address') is-invalid @enderror"
                                                name="address" type="text" value="{{ $patient->address }}">
                                            @error('address')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Desa</label>
                                        <div class="col-md-8 col-lg-10">
                                            <select class="choices  @error('village') is-invalid @enderror"
                                                id="village-form" name="village">
                                                <option value="">Pilih Desa</option>
                                                <option>Buluagung</option>
                                                <option>Jati</option>
                                                <option>Jatiprahu</option>
                                                <option>Karangan</option>
                                                <option>Kayen</option>
                                                <option>Kedungsigit</option>
                                                <option>Kerjo</option>
                                                <option>Ngentrong</option>
                                                <option>Salamrejo</option>
                                                <option>Suko Wetan</option>
                                                <option>Sumber</option>
                                                <option>Sumberingin</option>
                                            </select>
                                            @error('village')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Pekerjaan</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input class="form-control form-control-lg @error('job') is-invalid @enderror"
                                                name="job" type="text" value="{{ $patient->job }}">
                                            @error('job')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nomer Telepon</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('phone_number') is-invalid @enderror"
                                                name="phone_number" type="text" value="{{ $patient->phone_number }}">
                                            @error('phone_number')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col offset-md-4 offset-lg-2">
                                            <div>
                                                <button class="btn btn-primary me-1 mb-1" type="submit">Simpan</button>
                                                <a class="btn btn-light-secondary me-1 mb-1"
                                                    href="{{ '/patient/' . $patient->id }}">Batal</a>
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

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script>
        let selectedVillage = @json($patient->village);

        const choices = new Choices(document.querySelector('.choices'));
        choices.setChoiceByValue(selectedVillage)
    </script>
@endpush

