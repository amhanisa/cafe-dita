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
                            <h4>Ubah Data Kebiasaan Pasien</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="{{ url('patient-habit/store') }}" method="post">
                                @csrf
                                <input name="patient_id" type="hidden" value="{{ $patient->id }}">
                                <input name="year" type="hidden" value="{{ $year }}">
                                <input name="month" type="hidden" value="{{ $month }}">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nama Lengkap</label>
                                        <label class="col-md-8 col-lg-10 col-form-label">{{ $patient->name }}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">NIK</label>
                                        <label class="col-md-8 col-lg-10 col-form-label">{{ $patient->nik }}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nomor Rekam Medis</label>
                                        <label
                                            class="col-md-8 col-lg-10 col-form-label">{{ $patient->medical_record_number }}</label>
                                    </div>

                                    @foreach ($habits as $habit)
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-2 col-form-label">{{ $habit->name }}</label>
                                            <div class="col-md-8 col-lg-10">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="4">{{ $monthName }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>1</th>
                                                                <th>2</th>
                                                                <th>3</th>
                                                                <th>4</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                @for ($i = 1; $i <= 4; $i++)
                                                                    @isset($habit->patientHabits[0])
                                                                        @if (is_null($habit->patientHabits[0]->{"week$i"}))
                                                                            <td>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                        type="radio" value="1">
                                                                                    <label class="form-check-label">
                                                                                        Ya
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                        type="radio" value="0">
                                                                                    <label class="form-check-label">
                                                                                        Tidak
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        @elseif($habit->patientHabits[0]->{"week$i"} == true)
                                                                            <td>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                        type="radio" value="1" checked>
                                                                                    <label class="form-check-label">
                                                                                        Ya
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                        type="radio" value="0">
                                                                                    <label class="form-check-label">
                                                                                        Tidak
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        @else
                                                                            <td>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                        type="radio" value="1">
                                                                                    <label class="form-check-label">
                                                                                        Ya
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                        type="radio" value="0" checked>
                                                                                    <label class="form-check-label">
                                                                                        Tidak
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                        @endif
                                                                    @else
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                    type="radio" value="1">
                                                                                <label class="form-check-label">
                                                                                    Ya
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    name="habit-{{ $habit->id }}-week-{{ $i }}"
                                                                                    type="radio" value="0">
                                                                                <label class="form-check-label">
                                                                                    Tidak
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                    @endisset
                                                                @endfor
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-lg-2 col-form-label">Catatan</label>
                                            <div class="col-md-8 col-lg-10">
                                                <input class="form-control form-control-lg" name="note-{{ $habit->id }}"
                                                    type="text" value="{{ $habit->patientHabits[0]->note ?? '' }}">
                                            </div>
                                        </div>

                                        <hr class="divider">
                                    @endforeach

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
