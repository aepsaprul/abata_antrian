@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-4 text-center">
                    <h1 class="text-uppercase">Selamat Datang</h1>
                    <h1 class="text-uppercase">{{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('script')
<script>
  $(document).ready(function () {
    tampil();
    function tampil() {
      setTimeout(() => {
        tanggalAntrianSementara();
        tampil();
      }, 1000);
    }

    // reset
    function reset() {
      $.ajax({
        url: "{{ URL::route('antrian_reset_antrian') }}",
        type: "get"
      })    
    }

    let tanggal = new Date();
    let tanggal_sekarang = tanggal.getDate();

    function tanggalAntrianSementara() {
      $.ajax({
        url: "{{ URL::route('antrian.tanggal') }}",
        type: "get",
        success: function (response) {
          if (tanggal_sekarang != response.status) {
            reset();
          }
        }
      })
    }
  })
</script>
@endsection

