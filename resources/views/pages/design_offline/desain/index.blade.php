@extends('layouts.app')

@section('style')

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header"></section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div id="data_tampil" class="row"></div>
    </div>
  </section>
</div>

@endsection

@section('script')
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

    tampil();

    function tampil() {
      setTimeout(() => {
          perbaharui();
          tampil();
      }, 500);
    }

    // perbaharui();

    function perbaharui() {
      $.ajax({
        url: "{{ URL::route('design_offline.desain.data') }}", 
        success: function(result) {
          $("#data_tampil").html(result);
      }});
    }

    // btn ambil
    $(document).on('click', '.btn-ambil', function (e) {
      e.preventDefault();

      let url = "{{ URL::route('design_offline.desain.update', [':id']) }}";
      url = url.replace(':id', $(this).attr('data-id'));

      let formData = {
        id: $(this).attr('data-id'),
        status: "ambil"
      }

      $.ajax({
        url: url,
        type: "put",
        data: formData,
        beforeSend: function () {
          $('.btn-ambil').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Konsep Diambil'
          })
        }
      })
    })

    // btn approv
    $(document).on('click', '.btn-approv', function (e) {
      e.preventDefault();

      let url = "{{ URL::route('design_offline.desain.update', [':id']) }}";
      url = url.replace(':id', $(this).attr('data-id'));

      let formData = {
        id: $(this).attr('data-id'),
        status: "approv"
      }

      $.ajax({
        url: url,
        type: "put",
        data: formData,
        beforeSend: function () {
          $('.btn-approv').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Konsep Proses Approv'
          })
        }
      })
    })

    // btn revisi
    $(document).on('click', '.btn-revisi', function (e) {
      e.preventDefault();

      let url = "{{ URL::route('design_offline.desain.update', [':id']) }}";
      url = url.replace(':id', $(this).attr('data-id'));

      let formData = {
        id: $(this).attr('data-id'),
        status: "revisi"
      }

      $.ajax({
        url: url,
        type: "put",
        data: formData,
        beforeSend: function () {
          $('.btn-revisi').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Konsep Proses Revisi'
          })
        }
      })
    })

    // btn selesai
    $(document).on('click', '.btn-selesai', function (e) {
      e.preventDefault();

      let id = $(this).attr('data-id');

      let url = "{{ URL::route('design_offline.desain.update', [':id']) }}";
      url = url.replace(':id', id);

      let formData = {
        id: id,
        status: "selesai"
      }

      $.ajax({
        url: url,
        type: "put",
        data: formData,
        beforeSend: function () {
          $('.btn-revisi').attr('disabled', true);
        },
        success: function (response) {
          let url_redirect = "{{ URL::route('design_offline.desain.upload', [':id']) }}";
          url_redirect = url_redirect.replace(':id', id);

          window.location.href = url_redirect;
        }
      })
    })
  })
</script>
@endsection
