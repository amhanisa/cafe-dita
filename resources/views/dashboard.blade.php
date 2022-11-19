@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col mb-3">

                Halo, {{ Auth::user()->name }}
            </div>
            <hr>
        </section>
        <section>
            <h3 class="mb-4">
                Menu
            </h3>
        </section>
        <section class="row">
            <div class="col-12 col-lg-3 col-md-6">
                <a class="btn btn-primary btn-block btn-lg shadow-lg rounded-3 mb-4" href="{{ url('patient') }}">
                    <div class="d-flex px-4 py-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg class="text-white" style="height: 1.5rem; width: 1.5rem;"
                                xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                <path fill-rule="evenodd"
                                    d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                            <div class="ms-3 me-auto">
                                <h4 class="text-white mb-0 me-auto">Pasien</h4>
                            </div>
                        </div>
                        <svg class="bi bi-arrow-right-circle" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 col-md-6">
                <a class="btn btn-primary btn-block btn-lg shadow-lg rounded-3 mb-4" href="{{ url('consultation') }}">
                    <div class="d-flex px-4 py-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg class="text-white" style="height: 1.5rem; width: 1.5rem;"
                                xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" />
                            </svg>
                            <div class="ms-3 me-auto">
                                <h4 class="text-white mb-0 me-auto">Konsultasi</h4>
                            </div>
                        </div>
                        <svg class="bi bi-arrow-right-circle" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 col-md-6">
                <a class="btn btn-primary btn-block btn-lg shadow-lg rounded-3 mb-4" href="{{ url('report') }}">
                    <div class="d-flex px-4 py-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg class="text-white" style="height: 1.5rem; width: 1.5rem;"
                                xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M6 12v-2h3v2H6z" />
                                <path
                                    d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM3 9h10v1h-3v2h3v1h-3v2H9v-2H6v2H5v-2H3v-1h2v-2H3V9z" />
                            </svg>
                            <div class="ms-3 me-auto">
                                <h4 class="text-white mb-0 me-auto">Laporan</h4>
                            </div>
                        </div>
                        <svg class="bi bi-arrow-right-circle" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-3 col-md-6">
                <a class="btn btn-primary btn-block btn-lg shadow-lg rounded-3 mb-4" href="{{ url('user') }}">
                    <div class="d-flex px-4 py-3 align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg class="text-white" style="height: 1.5rem; width: 1.5rem;"
                                xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path
                                    d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z" />
                            </svg>
                            <div class="ms-3 me-auto">
                                <h4 class="text-white mb-0 me-auto">Petugas</h4>
                            </div>
                        </div>
                        <svg class="bi bi-arrow-right-circle" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                        </svg>
                    </div>
                </a>
            </div>

        </section>
    </div>
@endsection
