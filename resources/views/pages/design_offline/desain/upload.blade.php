@extends('layouts.app')

@section('style')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"></section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center">
        <div class="col-8">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-6 pr-5">
                  <div class="d-flex justify-content-between">
                    <p class="g" style="width: 50%;">Nama Konsumen</p>
                    <p class="" style="width: 10%;">:</p>
                    <p class="text-uppercase text-right font-weight-bold" style="width: 40%;">uyo</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Harga Desain</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">35.000</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Lama Pengerjaan</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">00:45:00</p>
                  </div>
                </div>
                <div class="col-6 pl-5">
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Tanggal Masuk</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">11-08-2022</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Tanggal Selesai</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">12-08-2022</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p class="font-weight-bold">Hasil Desain:</p>
                </div>
                <div class="col-12">
                  <textarea id="summernote" name="gambar"></textarea>
                </div>
                <div class="col-12 text-right">
                  <button class="btn btn-primary">Upload</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection

@section('script')
<!-- Summernote -->
<script src="{{ asset('public/themes/plugins/summernote/summernote-bs4.js') }}"></script>

<script>
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

      // Summernote
      $('#summernote').summernote()

  });
</script>
@endsection
