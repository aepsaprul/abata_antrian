@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if (in_array("tambah", $data_navigasi))
                            <div class="card-header">
                                <h3 class="card-title">
                                    <button type="button" id="btn-create" class="btn bg-gradient-primary btn-sm pl-3 pr-3">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </h3>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">No</th>
                                        <th class="text-center text-indigo">Nama</th>
                                        <th class="text-center text-indigo">Jabatan</th>
                                        <th class="text-center text-indigo">Email</th>
                                        <th class="text-center text-indigo">Cabang</th>
                                        <th class="text-center text-indigo">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @foreach ($item->antrianUser as $item_antrian_user)
                                                    {{ $item_antrian_user->jabatan }} {{ $item_antrian_user->nomor }}
                                                @endforeach
                                            </td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @if ($item->karyawan)
                                                    {{ $item->karyawan->cabang->nama_cabang }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    @if (in_array("ubah", $data_navigasi) || in_array("hapus", $data_navigasi))
                                                        <a
                                                            href="#"
                                                            class="dropdown-toggle btn bg-gradient-primary btn-sm"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                                <i class="fas fa-cog"></i>
                                                        </a>
                                                    @endif
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if (in_array("akses", $data_navigasi))
                                                            <a
                                                                href="#"
                                                                class="dropdown-item btn-access"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fas fa-lock pr-1"></i> Akses
                                                            </a>
                                                        @endif
                                                        @if (in_array("ubah", $data_navigasi))
                                                            <a
                                                                href="#"
                                                                class="dropdown-item btn-edit"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fas fa-edit pr-1"></i> Ubah
                                                            </a>
                                                        @endif
                                                        @if (in_array("hapus", $data_navigasi))
                                                            <a
                                                                href="#"
                                                                class="dropdown-item btn-delete"
                                                                data-id="{{ $item->id }}">
                                                                    <i class="fas fa-minus-circle pr-1"></i> Hapus
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


{{-- modal create --}}
<div class="modal fade modal-create" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-create">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_nama" class="form-label">Nama</label>
                        <select name="create_nama" id="create_nama" class="form-control create_nama_select2"></select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-primary btn-create-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-create-save" style="width: 130px;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal access --}}
<div class="modal fade modal-access" id="modal-default">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form-access">

                {{-- karyawan id --}}
                <input type="hidden" name="access_karyawan_id" id="access_karyawan_id">

                <div class="modal-body">
                    <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center text-indigo">Main</th>
                                <th class="text-center text-indigo">Sub</th>
                                <th class="text-center text-indigo">Button</th>
                                <th class="text-center text-indigo">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data_navigasi">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-access-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-access-save" style="width: 130px;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade modal-edit" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-edit">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Data User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- karyawan id --}}
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama</label>
                        <input type="text" name="edit_nama" id="edit_nama" class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jabatan" class="form-label">Jabatan</label>
                        <select name="edit_jabatan" id="edit_jabatan" class="form-control"></select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor" class="form-label">Nomor</label>
                        <input type="number" name="edit_nomor" id="edit_nomor" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-primary btn-edit-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-edit-save" style="width: 130px;">
                        <i class="fas fa-save"></i> Perbaharui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal delete --}}
<div class="modal fade modal-delete" id="modal-default">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form-delete">
                <input type="hidden" id="delete_id" name="delete_id">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger" type="button" data-dismiss="modal" style="width: 130px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary btn-delete-spinner d-none" disabled style="width: 130px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button type="submit" class="btn btn-primary btn-delete-yes text-center" style="width: 130px;">
                        Ya
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="{{ asset('public/themes/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('public/themes/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('public/themes/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function () {
        $("#example1").DataTable();
    });
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // create
        $('#btn-create').on('click', function(e) {
            e.preventDefault();
            $('#create_nama').empty();

            $.ajax({
                url: "{{ URL::route('user.create') }}",
                type: "get",
                success: function (response) {
                    let val_karyawan = '<option value="">--Pilih Karyawan--</option>';
                    $.each(response.karyawans, function (index, item) {
                        val_karyawan += '<option value="' + item.id + '_' + item.nama_lengkap + '_' + item.email + '">' + item.nama_lengkap;
                            if (item.jabatan) {
                                val_karyawan += ' - ' + item.jabatan.nama_jabatan;
                            }
                            if (item.cabang) {
                                val_karyawan += ' - ' + item.cabang.nama_cabang;
                            }
                        val_karyawan +='</option>';
                    })
                    $('#create_nama').append(val_karyawan);

                    $('.modal-create').modal('show');
                }
            })
        });

        $(document).on('shown.bs.modal', '.modal-create', function() {
            $('#create_nama').focus();
            $('.create_nama_select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $(".modal-create")
            });
        });

        $('#form-create').submit(function (e) {
            e.preventDefault();

            var formData = {
                nama: $('#create_nama').val()
            }

            $.ajax({
                url: "{{ URL::route('user.store') }}",
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('.btn-create-spinner').removeClass('d-none');
                    $('.btn-create-save').addClass('d-none');
                },
                success: function (response) {
                    if (response.status == "false") {
                        Toast.fire({
                            icon: 'error',
                            title: response.keterangan
                        });

                        setTimeout(() => {
                            $('.btn-create-spinner').addClass('d-none');
                            $('.btn-create-save').removeClass('d-none');
                        }, 1000);
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data behasil ditambah'
                        });

                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + error

                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // access
        $(document).on('click', '.btn-access', function(e) {
            e.preventDefault();
            $('#data_navigasi').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("user.access", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "get",
                success: function (response) {
                    $('#access_karyawan_id').val(response.karyawan_id);

                    let val_navigasi = '';
                    $.each(response.nav_mains, function (index, iteme) {
                        val_navigasi += '' +
                            '<tr>' +
                                '<td rowspan="' + iteme.nav_button.length + '" style="padding: 5px;">' + iteme.title + '</td>';
                                $.each(iteme.nav_sub, function (index, item) {
                                    val_navigasi += '' +
                                        '<td rowspan="' + item.nav_button.length + '" style="padding: 5px;">';
                                            if (item.title != iteme.title) {
                                                val_navigasi += item.title;
                                            }
                                    val_navigasi += '</td>';
                                    $.each(item.nav_button, function (index, item_nav_button) {
                                        val_navigasi += '' +
                                            '<td style="padding: 5px;">' +
                                                item_nav_button.title +
                                            '</td>' +
                                            '<td class="text-center" style="padding: 5px;">' +
                                                '<input type="checkbox" id="button_check_ ' + item_nav_button.id + '" name="button_check[]" value="' + item_nav_button.id + '"';
                                                $.each(response.nav_access, function (index, item_nav_access) {
                                                    if (item_nav_access.nav_button_id == item_nav_button.id) {
                                                        val_navigasi += ' checked';
                                                    }
                                                })
                                                val_navigasi += '>' +
                                            '</td>' +
                                        '</tr>';
                                    })
                                    val_navigasi += '</tr>';
                                })
                                val_navigasi += '</tr>';
                    })
                    $('#data_navigasi').append(val_navigasi);

                    $('.modal-access').modal('show');
                }
            })
        });

        $(document).on('submit', '#form-access', function (e) {
            e.preventDefault();

            let val_check = [];
            $('input[name="button_check[]"]:checked').each(function() {
                data_check = this.value;
                val_check.push(data_check);
            });

            let formData = {
                data_navigasi: val_check,
                karyawan_id: $('#access_karyawan_id').val()
            }

            $.ajax({
                url: "{{ URL::route('user.access_store') }}",
                type: "post",
                data: formData,
                beforeSend: function () {
                    $('.btn-access-spinner').removeClass('d-none');
                    $('.btn-access-save').addClass('d-none');
                },
                success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil disimpan'
                    });

                    setTimeout( () => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + error

                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            })
        })

        // edit
        $(document).on('click', '.btn-edit', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("user.edit", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    $('#edit_id').val(response.user.id);
                    $('#edit_nama').val(response.user.name);
                    $('#edit_nomor').val(response.antrian_user.nomor);

                    let val_jabatan = '' +
                        '<option value="">--Pilih Jabatan</option>' +
                        '<option value="desain"';
                        if (response.antrian_user.jabatan == "desain") {
                            val_jabatan += ' selected';
                        }
                        val_jabatan += '>desain</option>' +
                        '<option value="cs"';
                        if (response.antrian_user.jabatan == "cs") {
                            val_jabatan += ' selected';
                        }
                        val_jabatan += '>cs</option>';

                    $('#edit_jabatan').append(val_jabatan);

                    $('.modal-edit').modal('show');
                }
            })
        })

        $(document).on('submit', '#form-edit', function (e) {
            e.preventDefault();

            var formData = {
                id: $('#edit_id').val(),
                nama: $('#edit_nama').val(),
                jabatan: $('#edit_jabatan').val(),
                nomor: $('#edit_nomor').val()
            }

            $.ajax({
                url: "{{ URL::route('user.update') }}",
                type: 'post',
                data: formData,
                beforeSend: function () {
                    $('.btn-edit-spinner').removeClass("d-none");
                    $('.btn-edit-save').addClass("d-none");
                },
                success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui'
                    });

                    setTimeout( () => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + error

                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // delete
        $('body').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');

            $('#delete_id').val(id);
            $('.modal-delete').modal('show');
        });

        $('#form-delete').submit(function (e) {
            e.preventDefault();

            var formData = {
                id: $('#delete_id').val()
            }

            $.ajax({
                url: "{{ URL::route('user.delete') }}",
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('.btn-delete-spinner').removeClass('d-none');
                    $('.btn-delete-yes').addClass('d-none');
                },
                success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus'
                    });

                    setTimeout( () => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + error

                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });
    });
</script>

@endsection
