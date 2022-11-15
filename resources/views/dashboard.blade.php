@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col mb-3">

                Halo, User
            </div>
        </section>
        <section>
            MENU
            <hr>
        </section>
        <section class="row">
            <div class="col-12 col-lg-3 col-md-6">
                <a class="card border-start border-5 border-primary" href="{{ url('patient') }}">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col d-flex">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    <path fill-rule="evenodd"
                                        d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                </svg>
                                <h4 class="ms-3 mb-0">Pasien</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 col-md-6">
                <a class="card border-start border-5 border-primary" href="{{ url('patient') }}">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col d-flex">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    <path fill-rule="evenodd"
                                        d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                </svg>
                                <h4 class="ms-3 mb-0">Konsultasi</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 col-md-6">
                <a class="card border-start border-5 border-primary" href="{{ url('patient') }}">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col d-flex">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    <path fill-rule="evenodd"
                                        d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                </svg>
                                <h4 class="ms-3 mb-0">Laporan</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 col-md-6">
                <a class="card border-start border-5 border-primary" href="{{ url('patient') }}">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col d-flex">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    <path fill-rule="evenodd"
                                        d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                </svg>
                                <h4 class="ms-3 mb-0">Petugas</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </section>
    </div>
@endsection
