@extends('layouts.app')

@section('style')

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">

                    {{-- flash message --}}
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="mt-5">
                        <center>
                            <img src="{{ asset('public/assets/logo-biru.png') }}" alt="logo" style="width: 50%;">
                        </center>
                        <a href="{{ url('antrian/page_customer/1/form') }}" class="btn-siap btn btn-block btn-primary pt-3 pb-3 pr-5 pl-5 mt-5" style="font-size: 2em; font-weight: bold;">
                            SIAP CETAK
                        </a>
                        <a href="{{ url('antrian/page_customer/2/form') }}" class="btn-desain btn btn-block btn-primary pt-3 pb-3 pr-5 pl-5" style="font-size: 2em; font-weight: bold;">
                            DESAIN / EDIT
                        </a>

                        @if (Auth::user()->master_karyawan_id == 0 || Auth::user()->karyawan->master_cabang_id == 5)
                            <a href="{{ url('antrian/page_customer/3/form') }}" class="btn-konsultasi btn btn-block btn-primary pt-3 pb-3 pr-5 pl-5" style="font-size: 2em; font-weight: bold;">
                                KONSULTASI CS
                            </a>
                        @endif

                        <div class="d-flex justify-content-center mt-5">
                            <a href="{{ route('antrian_reset_antrian') }}" class="btn btn-danger" onclick="confirm('Yakin akan di reset?')">Reset Antrian</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

<script>

</script>

@endsection
