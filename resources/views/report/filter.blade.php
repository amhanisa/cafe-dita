@extends('layouts.app')

@section('content')
    <div class="page-heading">
        <h3>Laporan</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter</h4>
                    </div>
                    <div class="card-body">
                        @include('report.form')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

