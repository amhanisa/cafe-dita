@extends('layouts.app')

@push('style-before')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-heading">
        <h3>Konsultasi</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Impor Data Konsultasi</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <p class="card-text">Unggah data register dari web e-Link berformat .xlsx
                            </p>
                            <form class="row row-cols-lg-auto g-3 align-items-center"
                                action="{{ url('consultation/import') }}" method="post" enctype='multipart/form-data'>
                                @csrf
                                <div class="col-12">
                                    <input class="form-control" id="formFile" name="import_file" type="file">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Upload</button>
                                </div>
                                @error('import_file')
                                    <span class="validation-error"> {{ $message }} </span>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

