@extends('layouts.app')

@push('style-before')
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="page-heading">
        <h3>Daftar Pasien</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <a class="btn btn-primary" href="/patient/add">Tambah Pasien</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="patients-table">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No Rekam Medis</th>
                                        <th>NIK</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur
                                            <br>
                                            <span class="small fw-light">(tahun)</span>
                                        </th>
                                        <th>Alamat</th>
                                        <th>Desa</th>
                                        <th>Pekerjaan</th>
                                        <th>No Telepon</th>
                                        <th>Status</th>
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

    <script type="text/javascript">
        var datatable = $('#patients-table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            scrollX: true,
            ajax: {
                url: "{{ route('datatable.patient') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'medical_record_number'
                },
                {
                    data: 'nik'
                },
                {
                    data: 'sex'
                },
                {
                    data: 'birthday'
                },
                {
                    data: 'address'
                },
                {
                    data: 'village.name'
                },
                {
                    data: 'job'
                },
                {
                    data: 'phone_number'
                },
                {
                    data: 'status',
                    render: null
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                }
            ]
        });
    </script>
@endpush
