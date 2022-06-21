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
                    <h1>Karyawan Akses</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Karyawan Akses</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center text-indigo">Main</th>
                                        <th class="text-center text-indigo">Sub</th>
                                        <th class="text-center text-indigo">Button</th>
                                        <th class="text-center text-indigo">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($buttons as $key => $item)
                                        <tr>
                                            <td rowspan="{{ $item->total }}">{{ $item->navSub->title }}</td>
                                            @foreach ($subs as $item_sub)
                                                @if ($item_sub->sub_id == $item->sub_id)
                                                        <td> --}}
                                                            {{-- @if ($item_sub->navSub->link != '#')
                                                                {{ $item_sub->navSub->title }}
                                                            @endif --}}
                                                            {{-- {{ $item_sub->title }}
                                                        </td>
                                                        <td>#</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                    @endforeach --}}
                                    @foreach ($nav_mains as $iteme)
                                        <tr>
                                            <td rowspan="{{ count($iteme->navButton) }}">{{ $iteme->title }}</td>
                                            @foreach ($iteme->navSub as $key => $item)
                                                <td rowspan="{{ count($item->navButton) }}">
                                                    @if ($item->title != $iteme->title)
                                                        {{ $item->title }}
                                                    @endif
                                                </td>
                                                @foreach ($item->navButton as $item_nav_button)
                                                        <td>
                                                            {{ $item_nav_button->title }}
                                                        </td>
                                                        <td class="text-center"><input type="checkbox"></td>
                                                    </tr>
                                                @endforeach
                                            </tr>
                                            @endforeach
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
<!-- AdminLTE App -->
<script src="{{ asset('public/themes/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/themes/dist/js/demo.js') }}"></script>
<!-- Page specific script -->

<script>

</script>

@endsection
