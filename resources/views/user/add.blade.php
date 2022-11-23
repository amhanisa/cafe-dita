@extends('layouts.app')

@push('style-before')
    <link href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-heading">
        <h3>Petugas</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Tambah Petugas</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="/user/store" method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Nama Lengkap</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input class="form-control form-control-lg @error('name') is-invalid @enderror"
                                                name="name" type="text" value="{{ old('name') }}">
                                            @error('name')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('username') is-invalid @enderror"
                                                name="username" type="text" value="{{ old('username') }}">
                                            @error('username')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Password</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                name="password" type="password">
                                            @error('password')
                                                <span class="invalid-feedback"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Konfirmasi Password</label>
                                        <div class="col-md-8 col-lg-10">
                                            <input
                                                class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" type="password">
                                            @error('password_confirmation')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-2 col-form-label">Role</label>
                                        <div class="col-md-8 col-lg-10">
                                            <select class="choices  @error('role_id') is-invalid @enderror" name="role_id">
                                                <option value="">Pilih Role</option>
                                                @foreach ($roles as $key => $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                                <span class="validation-error"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col offset-md-4 offset-lg-2">
                                            <div>
                                                <button class="btn btn-primary me-1 mb-1" type="submit">Tambah</button>
                                                <a class="btn btn-light-secondary me-1 mb-1" href="/user">Batal</a>
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
        const choices = new Choices(document.querySelector('.choices'));
    </script>
@endpush
