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
                            <div class="row justify-content-center">
                                <div class="col-md-6 border border-1 rounded-4 p-4">
                                    <form action="{{ url('consultation/import') }}" method="post"
                                        enctype='multipart/form-data'>
                                        <input class="basic-filepond" type="file">
                                        <div class="d-flex justify-content-center">
                                            <input class="btn btn-primary" type="submit" value="Upload">
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script>
        $('.basic-filepond').filepond();
    </script>
@endpush

