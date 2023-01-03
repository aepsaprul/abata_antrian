@extends('layouts.app')

@section('style')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/themes/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')

@php
  function rupiah($angka){
    $hasil =  number_format($angka,0, ',' , '.');
    return $hasil;
  }
@endphp

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
              <input type="hidden" name="konsep_id" id="konsep_id" value="{{ $konsep->id }}">
              <div class="row">
                <div class="col-6 pr-5">
                  <div class="d-flex justify-content-between">
                    <p class="g" style="width: 50%;">Nama Konsumen</p>
                    <p class="" style="width: 10%;">:</p>
                    <p class="text-uppercase text-right font-weight-bold" style="width: 40%;">{{ $konsep->customer->nama_customer }}</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Harga Desain</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">{{ rupiah($konsep->harga_desain) }}</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Lama Pengerjaan</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">{{ $konsep->waktu }}</p>
                  </div>
                </div>
                <div class="col-6 pl-5">
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Tanggal Masuk</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">{{ $konsep->created_at }}</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <p style="width: 50%;">Tanggal Selesai</p>
                    <p style="width: 10%;">:</p>
                    <p class="text-right font-weight-bold" style="width: 40%;">{{ $konsep_timer->created_at }}</p>
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
                <div class="col-12">
                  <button class="btn btn-primary btn-block btn-spinner-upload d-none" disabled style="width: 150px;"><span class="spinner-grow spinner-grow-sm"></span></button>
                  <button class="btn btn-primary btn-upload" style="width: 150px;">Upload</button>
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
    
    $(document).on('click', '.btn-upload', function (e) {
      e.preventDefault();
      let gambar = $('#summernote').val();
      let id = $('#konsep_id').val();

      let url = "{{ URL::route('design_offline.desain.update', [':id']) }}";
      url = url.replace(':id', id);

      let formData = {
        id: id,
        status: "upload",
        gambar: gambar
      }

      $.ajax({
        url: url,
        type: "put",
        data: formData,
        beforeSend: function () {
          $('.btn-spinner-upload').removeClass('d-none');
          $('.btn-upload').addClass('d-none');
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Data berhasil diperbaharui'
          })

          setTimeout(() => {
            window.location.href = "{{ URL::route('design_offline.desain') }}";            
          }, 2000);
        }
      })
    })
  });
</script>
@endsection
