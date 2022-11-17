@extends('layouts.app')

@push('style-before')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

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
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td><a class="btn btn-secondary"
                                                        href="{{ '/user/' . $user->id . '/edit' }}">
                                                        Edit
                                                    </a>
                                                    @if ($user->id != auth()->id())
                                                        <button class="btn btn-danger delete-user"
                                                            data-id="{{ $user->id }}">
                                                            Hapus
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form id="delete-form" action="{{ url('user/delete') }}" method="POST">
                                    @csrf
                                    <input name="id" type="hidden">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.delete-user').click(function() {
                let user_id = $(this).data('id');
                Swal.fire({
                        title: `Apakah anda yakin menghapus data petugas ini?`,
                        text: "Jika anda menghapus, data tidak dapat dikembalikan",
                        icon: "warning",
                        buttons: true,
                        showCancelButton: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            let form = $("#delete-form");
                            $('input[name="id"]').val(user_id);
                            form.submit();
                        }
                    });
            })
        });
    </script>
@endpush

