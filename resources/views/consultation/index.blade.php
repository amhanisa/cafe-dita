@extends('layouts.app')

@push('style-before')
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <h3>Daftar Konsultasi</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="mb-3">
                                @if (Auth::user()->role_id == 1)
                                    <a class="btn btn-primary" href="{{ url('consultation/import') }}">
                                        Impor Data Konsultasi
                                    </a>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="consultations-table" width="100%">
                                    <thead>
                                        <th>No</th>
                                        <th>Tanggal Konsultasi</th>
                                        <th>Nama Pasien</th>
                                        <th>Tensi Darah <br>
                                            <span class="small fw-lighter">
                                                (mmHg)
                                            </span>
                                        </th>
                                        <th>Obat</th>
                                        <th>Keterangan </th>
                                        <th>Action</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#consultations-table').DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                scrollX: true,
                language: {
                    emptyTable: "Belum ada data konsultasi"
                },
                ajax: "{{ route('datatable.consultation') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                }, {
                    data: 'date'
                }, {
                    data: 'patient.name'
                }, {
                    data: 'bloodtension'
                }, {
                    data: 'medicine'
                }, {
                    data: 'note'
                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                }]
            });
        });
    </script>
@endpush
