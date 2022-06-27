@extends('layouts.app')

@section('style')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/themes/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				    <h1>Navigasi</h1>
				</div>
				<div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Navigasi</li>
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
                        <div class="card-body">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-tombol-tab" data-toggle="pill" href="#custom-tabs-four-tombol" role="tab" aria-controls="custom-tabs-four-tombol" aria-selected="true">Navigasi Tombol</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-sub-tab" data-toggle="pill" href="#custom-tabs-four-sub" role="tab" aria-controls="custom-tabs-four-sub" aria-selected="true">Navigasi Sub</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-main-tab" data-toggle="pill" href="#custom-tabs-four-main" role="tab" aria-controls="custom-tabs-four-main" aria-selected="false">Navigasi Utama</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">

                                        {{-- navigasi button --}}
                                        <div class="tab-pane fade show active" id="custom-tabs-four-tombol" role="tabpanel" aria-labelledby="custom-tabs-four-tombol-tab">
                                            <button id="tombol-button-create" type="button" class="btn bg-gradient-primary btn-sm pl-3 pr-3 mb-4"><i class="fa fa-plus"></i> Tambah</button>
                                            <table id="example1" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-indigo">No</th>
                                                        <th class="text-center text-indigo">Title</th>
                                                        <th class="text-center text-indigo">Link</th>
                                                        <th class="text-center text-indigo">Navigasi Sub</th>
                                                        <th class="text-center text-indigo">Navigasi Utama</th>
                                                        <th class="text-center text-indigo">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nav_tombols as $key => $item)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="tombol_title_{{ $item->id }}">{{ $item->title }}</td>
                                                        <td class="tombol_link_{{ $item->id }}">{{ $item->link }}</td>
                                                        <td class="tombol_sub_{{ $item->id }}">
                                                            @if ($item->navSub)
                                                                {{ $item->navSub->title }}
                                                            @else
                                                                Navigasi sub kosong
                                                            @endif
                                                        </td>
                                                        <td class="tombol_main_{{ $item->id }}">
                                                            @if ($item->navMain)
                                                                {{ $item->navMain->title }}
                                                            @else
                                                                Navigasi utama kosong
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a
                                                                    class="dropdown-toggle btn bg-gradient-primary btn-sm"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                        <i class="fa fa-cog"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a
                                                                        class="dropdown-item text-indigo border-bottom tombol-btn-edit"
                                                                        href="#"
                                                                        data-id="{{ $item->id }}">
                                                                            <i class="fa fa-pencil-alt px-2"></i> Ubah
                                                                    </a>
                                                                    <a
                                                                        class="dropdown-item text-indigo tombol-btn-delete"
                                                                        href="#"
                                                                        data-id="{{ $item->id }}">
                                                                            <i class="fa fa-trash-alt px-2"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- navigasi sub --}}
                                        <div class="tab-pane fade show" id="custom-tabs-four-sub" role="tabpanel" aria-labelledby="custom-tabs-four-sub-tab">
                                            <button id="sub-button-create" type="button" class="btn bg-gradient-primary btn-sm pl-3 pr-3 mb-4"><i class="fa fa-plus"></i> Tambah</button>
                                            <table id="example2" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-indigo">No</th>
                                                        <th class="text-center text-indigo">Title</th>
                                                        <th class="text-center text-indigo">Link</th>
                                                        <th class="text-center text-indigo">Navigasi Utama</th>
                                                        <th class="text-center text-indigo">Aktif</th>
                                                        <th class="text-center text-indigo">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nav_subs as $key => $item)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="sub_title_{{ $item->id }}">{{ $item->title }}</td>
                                                        <td class="sub_link_{{ $item->id }}">{{ $item->link }}</td>
                                                        <td class="sub_main_{{ $item->id }}">
                                                            @if ($item->navMain)
                                                                {{ $item->navMain->title }}
                                                            @else
                                                                Navigasi utama kosong
                                                            @endif
                                                        </td>
                                                        <td class="sub_aktif_{{ $item->id }}">{{ $item->aktif }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a
                                                                    class="dropdown-toggle btn bg-gradient-primary btn-sm"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                        <i class="fa fa-cog"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a
                                                                        class="dropdown-item text-indigo border-bottom sub-btn-edit"
                                                                        href="#"
                                                                        data-id="{{ $item->id }}">
                                                                            <i class="fa fa-pencil-alt px-2"></i> Ubah
                                                                    </a>
                                                                    <a
                                                                        class="dropdown-item text-indigo sub-btn-delete"
                                                                        href="#"
                                                                        data-id="{{ $item->id }}">
                                                                            <i class="fa fa-trash-alt px-2"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- navigasi main --}}
                                        <div class="tab-pane fade" id="custom-tabs-four-main" role="tabpanel" aria-labelledby="custom-tabs-four-main-tab">
                                            <button id="main-button-create" type="button" class="btn bg-gradient-primary btn-sm pl-3 pr-3 mb-4"><i class="fa fa-plus"></i> Tambah</button>
                                            <table id="example3" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-indigo">No</th>
                                                        <th class="text-center text-indigo">Title</th>
                                                        <th class="text-center text-indigo">link</th>
                                                        <th class="text-center text-indigo">Icon</th>
                                                        <th class="text-center text-indigo">Aktif</th>
                                                        <th class="text-center text-indigo">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($nav_mains as $key => $item)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="main_title_{{ $item->id }}">{{ $item->title }}</td>
                                                        <td class="main_link_{{ $item->id }}">{{ $item->link }}</td>
                                                        <td class="main_icon_{{ $item->id }}">{{ $item->icon }}</td>
                                                        <td class="main_aktif_{{ $item->id }}">{{ $item->aktif }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a
                                                                    class="dropdown-toggle btn bg-gradient-primary btn-sm"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                        <i class="fa fa-cog"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a
                                                                        class="dropdown-item text-indigo main-btn-edit"
                                                                        href="#"
                                                                        data-id="{{ $item->id }}">
                                                                            <i class="fa fa-pencil-alt px-2"></i> Ubah
                                                                    </a>
                                                                    <a
                                                                        class="dropdown-item text-indigo main-btn-delete"
                                                                        href="#"
                                                                        data-id="{{ $item->id }}">
                                                                            <i class="fa fa-trash-alt px-2"></i> Hapus
                                                                    </a>
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
                    </div>
				</div>
			</div>
		</div>
	</section>
</div>

{{-- main modal create  --}}
<div class="modal fade main-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Navigasi Utama</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="main_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_title"
                            name="main_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="main_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_link"
                            name="main_create_link"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="main_create_icon" class="form-label">Icon</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_icon"
                            name="main_create_icon"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="main_create_aktif" class="form-label">Aktif</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_create_aktif"
                            name="main_create_aktif"
                            maxlength="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary main-btn-create-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary main-btn-create-save" style="width: 120px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal create  --}}
<div class="modal fade sub-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Menu Sub</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_title"
                            name="sub_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_link"
                            name="sub_create_link"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_main_id" class="form-label">Menu Utama</label>
                        <select name="sub_create_main_id" id="sub_create_main_id" class="form-control form-control-sm" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_create_aktif" class="form-label">Aktif</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_create_aktif"
                            name="sub_create_aktif"
                            maxlength="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary sub-btn-create-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary sub-btn-create-save" style="width: 120px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- tombol modal create  --}}
<div class="modal fade tombol-modal-create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tombol_form_create">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Menu tombol</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tombol_create_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="tombol_create_title"
                            name="tombol_create_title"
                            maxlength="30" required>
                    </div>
                    <div class="mb-3">
                        <label for="tombol_create_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="tombol_create_link"
                            name="tombol_create_link"
                            maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="tombol_create_sub_id" class="form-label">Menu Sub</label>
                        <select name="tombol_create_sub_id" id="tombol_create_sub_id" class="form-control form-control-sm" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tombol_create_main_id" class="form-label">Menu Utama</label>
                        <select name="tombol_create_main_id" id="tombol_create_main_id" class="form-control form-control-sm" required>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary tombol-btn-create-spinner d-none" disabled style="width: 120px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary tombol-btn-create-save" style="width: 120px;"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- main modal edit  --}}
<div class="modal fade main-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="main_edit_id"
                    name="main_edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Menu Utama</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="main_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_title"
                            name="main_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="main_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_link"
                            name="main_edit_link"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="main_edit_icon" class="form-label">Icon</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_icon"
                            name="main_edit_icon"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="main_edit_aktif" class="form-label">Aktif</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="main_edit_aktif"
                            name="main_edit_aktif"
                            maxlength="100"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary main-btn-edit-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary main-btn-edit-save" style="width: 130px;"><i class="fa fa-save"></i> Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal edit  --}}
<div class="modal fade sub-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="sub_edit_id"
                    name="sub_edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Menu Sub</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_title"
                            name="sub_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_link"
                            name="sub_edit_link"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_main_id" class="form-label">Navigasi Utama</label>
                        <select class="form-control form-control-sm" name="sub_edit_main_id" id="sub_edit_main_id">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_edit_aktif" class="form-label">Aktif</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="sub_edit_aktif"
                            name="sub_edit_aktif"
                            maxlength="100"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary sub-btn-edit-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary sub-btn-edit-save" style="width: 130px;"><i class="fa fa-save"></i> Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- tombol modal edit  --}}
<div class="modal fade tombol-modal-edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tombol_form_edit">

                {{-- id  --}}
                <input
                    type="hidden"
                    id="tombol_edit_id"
                    name="tombol_edit_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Menu tombol</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal">
                            <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tombol_edit_title" class="form-label">Title</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="tombol_edit_title"
                            name="tombol_edit_title"
                            maxlength="30"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tombol_edit_link" class="form-label">Link</label>
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="tombol_edit_link"
                            name="tombol_edit_link"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tombol_edit_sub_id" class="form-label">Navigasi Sub</label>
                        <select class="form-control form-control-sm" name="tombol_edit_sub_id" id="tombol_edit_sub_id">

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tombol_edit_main_id" class="form-label">Navigasi Utama</label>
                        <select class="form-control form-control-sm" name="tombol_edit_main_id" id="tombol_edit_main_id">

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary tombol-btn-edit-spinner" disabled style="width: 130px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary tombol-btn-edit-save" style="width: 130px;"><i class="fa fa-save"></i> Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- main modal delete  --}}
<div class="modal fade main-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="main_form_delete">

                {{-- id  --}}
                <input type="hidden" id="main_delete_id" name="main_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="main_delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 120px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary main-btn-delete-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary main-btn-delete-yes text-center" style="width: 120px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sub modal delete  --}}
<div class="modal fade sub-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="sub_form_delete">

                {{-- id  --}}
                <input type="hidden" id="sub_delete_id" name="sub_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="sub_delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 120px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary sub-btn-delete-spinner" disabled style="width: 120px; display: none;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary sub-btn-delete-yes text-center" style="width: 120px;">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- tombol modal delete  --}}
<div class="modal fade tombol-modal-delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tombol_form_delete">

                {{-- id  --}}
                <input type="hidden" id="tombol_delete_id" name="tombol_delete_id">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin akan dihapus <span class="tombol_delete_title text-decoration-underline"></span> ?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width: 120px;"><span aria-hidden="true">Tidak</span></button>
                    <button class="btn btn-primary tombol-btn-delete-spinner d-none" disabled style="width: 120px;">
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading..
                    </button>
                    <button type="submit" class="btn btn-primary tombol-btn-delete-yes text-center" style="width: 120px;">Ya</button>
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

<script>
    $(document).ready(function() {
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

        $("#example1").DataTable({
            responsive: true,
            destroy: true,
            searching: true,
            paging: true,
            info: false
        });

        $(document).on('shown.bs.tab', function () {
            $("#example2").DataTable({
                responsive: true,
                destroy: true,
                searching: true,
                paging: true,
                info: false
            });

            $("#example3").DataTable({
                responsive: true,
                destroy: true,
                searching: true,
                paging: true,
                info: false
            });
        });

        // main create
        $('#main-button-create').on('click', function() {
            $('.main-modal-create').modal('show');
        });

        $(document).on('shown.bs.modal', '.main-modal-create', function() {
            $('#main_create_title').focus();
        });

        $('#main_form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                title: $('#main_create_title').val(),
                link: $('#main_create_link').val(),
                icon: $('#main_create_icon').val(),
                aktif: $('#main_create_aktif').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.main_store') }} ',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.main-btn-create-spinner').css("display", "block");
                    $('.main-btn-create-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil disimpan.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'danger',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // sub create
        $('#sub-button-create').on('click', function() {
            $('#sub_create_main_id').empty();

            $.ajax({
                url: '{{ URL::route('navigasi.sub_create') }}',
                type: 'GET',
                success: function(response) {
                    var nav_main_value = "<option value=\"\">--Pilih Menu Utama--</option>";

                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\">" + value.title + "</option>";
                    });

                    $('#sub_create_main_id').append(nav_main_value);
                    $('.sub-modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.sub-modal-create', function() {
            $('#sub_create_title').focus();
        });

        $('#sub_form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                title: $('#sub_create_title').val(),
                link: $('#sub_create_link').val(),
                main_id: $('#sub_create_main_id').val(),
                aktif: $('#sub_create_aktif').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.sub_store') }} ',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.sub-btn-create-spinner').css("display", "block");
                    $('.sub-btn-create-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil disimpan.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // tombol create
        $('#tombol-button-create').on('click', function() {
            $('#tombol_create_main_id').empty();

            $.ajax({
                url: '{{ URL::route('navigasi.tombol_create') }}',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    var nav_main_value = "<option value=\"\">--Pilih Menu Utama--</option>";
                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\">" + value.title + "</option>";
                    });

                    var nav_sub_value = "<option value=\"\">--Pilih Menu Sub--</option>";
                    $.each(response.nav_subs, function(index, value) {
                        nav_sub_value += "<option value=\"" + value.id + "\">" + value.title + "</option>";
                    });

                    $('#tombol_create_main_id').append(nav_main_value);
                    $('#tombol_create_sub_id').append(nav_sub_value);
                    $('.tombol-modal-create').modal('show');
                }
            });
        });

        $(document).on('shown.bs.modal', '.tombol-modal-create', function() {
            $('#tombol_create_title').focus();
        });

        $('#tombol_form_create').submit(function(e) {
            e.preventDefault();

            var formData = {
                title: $('#tombol_create_title').val(),
                link: $('#tombol_create_link').val(),
                sub_id: $('#tombol_create_sub_id').val(),
                main_id: $('#tombol_create_main_id').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.tombol_store') }} ',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.tombol-btn-create-spinner').removeClass("d-none");
                    $('.tombol-btn-create-save').addClass("d-none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil disimpan.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // main edit
        $('body').on('click', '.main-btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).attr('data-id');
            var url = '{{ route("navigasi.main_edit", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#main_edit_id').val(response.id);
                    $('#main_edit_title').val(response.title);
                    $('#main_edit_link').val(response.link);
                    $('#main_edit_icon').val(response.icon);
                    $('#main_edit_aktif').val(response.aktif);

                    $('.main-modal-edit').modal('show');
                }
            })
        });

        $('#main_form_edit').submit(function(e) {
            e.preventDefault();

            $('.main_title_' + $('#main_edit_id').val()).empty();
            $('.main_link_' + $('#main_edit_id').val()).empty();
            $('.main_icon_' + $('#main_edit_id').val()).empty();
            $('.main_aktif_' + $('#main_edit_id').val()).empty();

            var formData = {
                id: $('#main_edit_id').val(),
                title: $('#main_edit_title').val(),
                link: $('#main_edit_link').val(),
                icon: $('#main_edit_icon').val(),
                aktif: $('#main_edit_aktif').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.main_update') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.main-btn-edit-spinner').css("display", "block");
                    $('.main-btn-edit-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });

                    $('.main_title_' + response.id).append(response.title);
                    $('.main_link_' + response.id).append(response.link);
                    $('.main_icon_' + response.id).append(response.icon);
                    $('.main_aktif_' + response.id).append(response.aktif);

                    setTimeout(() => {
                        $('.main-modal-edit').modal('hide');
                        $('.main-btn-edit-spinner').css("display", "none");
                        $('.main-btn-edit-save').css("display", "block");
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'danger',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // sub edit
        $('body').on('click', '.sub-btn-edit', function(e) {
            e.preventDefault();
            $('#sub_edit_main_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("navigasi.sub_edit", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#sub_edit_id').val(response.id);
                    $('#sub_edit_title').val(response.title);
                    $('#sub_edit_link').val(response.link);
                    $('#sub_edit_aktif').val(response.aktif);

                    var nav_main_value = "<option value=\"\">--Pilih Navigasi Utama--</option>";

                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\"";

                        if (value.id == response.main_id) {
                            nav_main_value += "selected";
                        }

                        nav_main_value += ">" + value.title + "</option>";
                    });

                    $('#sub_edit_main_id').append(nav_main_value);
                    $('.sub-modal-edit').modal('show');
                }
            })
        });

        $('#sub_form_edit').submit(function(e) {
            e.preventDefault();

            $('.sub_title_' + $('#sub_edit_id').val()).empty();
            $('.sub_link_' + $('#sub_edit_id').val()).empty();
            $('.sub_main_' + $('#sub_edit_id').val()).empty();
            $('.sub_aktif_' + $('#sub_edit_id').val()).empty();

            var formData = {
                id: $('#sub_edit_id').val(),
                title: $('#sub_edit_title').val(),
                link: $('#sub_edit_link').val(),
                main_id: $('#sub_edit_main_id').val(),
                aktif: $('#sub_edit_aktif').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.sub_update') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.sub-btn-edit-spinner').css("display", "block");
                    $('.sub-btn-edit-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });

                    $('.sub_title_' + response.id).append(response.title);
                    $('.sub_link_' + response.id).append(response.link);
                    $('.sub_main_' + response.id).append(response.main_title);
                    $('.sub_aktif_' + response.id).append(response.aktif);

                    setTimeout(() => {
                        $('.sub-modal-edit').modal('hide');
                        $('.sub-btn-edit-spinner').css("display", "none");
                        $('.sub-btn-edit-save').css("display", "block");
                        $('#sub_edit_main_id').empty();
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // tombol edit
        $('body').on('click', '.tombol-btn-edit', function(e) {
            e.preventDefault();
            $('#tombol_edit_main_id').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("navigasi.tombol_edit", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('#tombol_edit_id').val(response.id);
                    $('#tombol_edit_title').val(response.title);
                    $('#tombol_edit_link').val(response.link);

                    var nav_main_value = "<option value=\"\">--Pilih Navigasi Utama--</option>";
                    $.each(response.nav_mains, function(index, value) {
                        nav_main_value += "<option value=\"" + value.id + "\"";
                        if (value.id == response.main_id) {
                            nav_main_value += "selected";
                        }
                        nav_main_value += ">" + value.title + "</option>";
                    });

                    var nav_sub_value = "<option value=\"\">--Pilih Navigasi Utama--</option>";
                    $.each(response.nav_subs, function(index, value) {
                        nav_sub_value += "<option value=\"" + value.id + "\"";
                        if (value.id == response.sub_id) {
                            nav_sub_value += "selected";
                        }
                        nav_sub_value += ">" + value.title + "</option>";
                    });

                    $('#tombol_edit_main_id').append(nav_main_value);
                    $('#tombol_edit_sub_id').append(nav_sub_value);
                    $('.tombol-modal-edit').modal('show');
                }
            })
        });

        $('#tombol_form_edit').submit(function(e) {
            e.preventDefault();

            $('.tombol_title_' + $('#tombol_edit_id').val()).empty();
            $('.tombol_link_' + $('#tombol_edit_id').val()).empty();
            $('.tombol_main_' + $('#tombol_edit_id').val()).empty();
            $('.tombol_aktif_' + $('#tombol_edit_id').val()).empty();

            var formData = {
                id: $('#tombol_edit_id').val(),
                title: $('#tombol_edit_title').val(),
                link: $('#tombol_edit_link').val(),
                main_id: $('#tombol_edit_main_id').val(),
                sub_id: $('#tombol_edit_sub_id').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.tombol_update') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.tombol-btn-edit-spinner').css("display", "block");
                    $('.tombol-btn-edit-save').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil diperbaharui.'
                    });

                    $('.tombol_title_' + response.id).append(response.title);
                    $('.tombol_link_' + response.id).append(response.link);
                    $('.tombol_main_' + response.id).append(response.main_title);
                    $('.tombol_aktif_' + response.id).append(response.aktif);

                    setTimeout(() => {
                        $('.tombol-modal-edit').modal('hide');
                        $('.tombol-btn-edit-spinner').css("display", "none");
                        $('.tombol-btn-edit-save').css("display", "block");
                        $('#tombol_edit_main_id').empty();
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    Toast.fire({
                        icon: 'error',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // main delete
        $('body').on('click', '.main-btn-delete', function(e) {
            e.preventDefault();
            $('.main_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("navigasi.main_delete_btn", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.main_delete_title').append(response.title);
                    $('#main_delete_id').val(response.id);
                    $('.main-modal-delete').modal('show');
                }
            });
        });

        $('#main_form_delete').submit(function(e) {
            e.preventDefault();

            var formData = {
                id: $('#main_delete_id').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.main_delete') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.main-btn-delete-spinner').css("display", "block");
                    $('.main-btn-delete-yes').css("display", "none");
                },
                success: function(response) {
                    if (response.status == "false") {
                        alert('Navigasi utama \"' + response.title + '\" terdapat di navigasi sub, hapus navigasi sub yg terdapat navigasi utama \"' + response.title + '\" terlebih dahulu ');
                    } else {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus.'
                        });

                        setTimeout(() => {
                            window.location.reload(1);
                        }, 1000);
                    }
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'danger',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // sub delete
        $('body').on('click', '.sub-btn-delete', function(e) {
            e.preventDefault();
            $('.sub_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("navigasi.sub_delete_btn", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.sub_delete_title').append(response.title);
                    $('#sub_delete_id').val(response.id);
                    $('.sub-modal-delete').modal('show');
                }
            });
        });

        $('#sub_form_delete').submit(function(e) {
            e.preventDefault();

            $('.sub-modal-delete').modal('hide');

            var formData = {
                id: $('#sub_delete_id').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.sub_delete') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.sub-btn-delete-spinner').css("display", "block");
                    $('.sub-btn-delete-yes').css("display", "none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + xhr.statusText
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'danger',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });

        // tombol delete
        $('body').on('click', '.tombol-btn-delete', function(e) {
            e.preventDefault();
            $('.tombol_delete_title').empty();

            var id = $(this).attr('data-id');
            var url = '{{ route("navigasi.tombol_delete_btn", ":id") }}';
            url = url.replace(':id', id );

            var formData = {
                id: id
            }

            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.tombol_delete_title').append(response.title);
                    $('#tombol_delete_id').val(response.id);
                    $('.tombol-modal-delete').modal('show');
                }
            });
        });

        $('#tombol_form_delete').submit(function(e) {
            e.preventDefault();

            $('.tombol-modal-delete').modal('hide');

            var formData = {
                id: $('#tombol_delete_id').val()
            }

            $.ajax({
                url: '{{ URL::route('navigasi.tombol_delete') }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.tombol-btn-delete-spinner').removeClass("d-none");
                    $('.tombol-btn-delete-yes').addClass("d-none");
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Data berhasil dihapus.'
                    });

                    setTimeout(() => {
                        window.location.reload(1);
                    }, 1000);
                },
                error: function(xhr, status, error){
                    var errorMessage = xhr.status + ': ' + error
                    alert('Error - ' + errorMessage);
                    Toast.fire({
                        icon: 'danger',
                        title: 'Error - ' + errorMessage
                    });
                }
            });
        });
    });
</script>

@endsection
