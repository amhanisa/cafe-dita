@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Petugas</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <a class="btn btn-primary" href="{{ url('/user/add') }}">Tambah
                                    Petugas</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="users-table">
                                    <thead>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Desa</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

