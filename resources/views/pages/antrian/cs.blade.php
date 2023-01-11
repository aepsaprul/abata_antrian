@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between">
        <h4 class="text-center text-uppercase">cs {{ Auth::user()->name }}</h4>
        <p style="text-align: center;">
          @if (Auth::user()->roles == "admin")
            <a href="#" class="btn btn-danger btn-sm">Komputer OFF</a>
          @else
            @if ($antrian_user->status == "off")
              <a href="{{ url('antrian/page_cs/' . Auth::user()->master_karyawan_id . '/status/on') }}" class="btn btn-danger">Komputer OFF</a>
            @else
              <a href="{{ url('antrian/page_cs/' . Auth::user()->master_karyawan_id . '/status/off') }}" class="btn btn-success">Komputer ON</a>
            @endif
          @endif
        </p>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="layer-1">
            <div class="row data-nomor"></div>
          </div>
        </div>
      </div>
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
        csList();
        tanggalAntrianSementara();
        tampil();
      }, 1000);
    }

    // csList();
    
    function csList() {
      $.ajax({
        url: "{{ URL::route('antrian_cs.list') }}", 
        success: function(result) {
          $(".data-nomor").html(result);
        }
      });
    }

    // panggil
    $(document).on('click', '.btn-panggil', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "panggil"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-panggil').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Sedang dipanggil'
          })
        }
      })
    })

    // mulai
    $(document).on('click', '.btn-mulai', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "mulai"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-mulai').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Mulai'
          })
        }
      })
    })

    // selesai
    $(document).on('click', '.btn-selesai', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "selesai"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-selesai').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Selesai'
          })
        }
      })
    })

    // batal
    $(document).on('click', '.btn-batal', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "batal"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-batal').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Batal'
          })
        }
      })
    })

    // pindah
    $(document).on('click', '.btn-pindah', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "pindah"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-pindah').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Pindah ke desain'
          })
        }
      })
    })

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

    notifAksi();
    function notifAksi() {
      setTimeout(() => {
        notif();
        notifDelete();
        notifAksi();
      }, 3000);
    }
    
    // notif();
    function notif() {
      $.ajax({
        url: "{{ URL::route('antrian.notif') }}",
        type: "get",
        success: function (response) {
          if (response.notifs.length > 0) {
            $.each(response.notifs, function (index, item) {
              if (item.cabang_id == response.cabang_id) {
                Notification.requestPermission().then((permission => {
                  if (permission === "granted") {
                    const notification = new Notification("Ada Pengunjung Baru", {
                      body: "Buka Halaman CS"
                    })

                    notification.addEventListener("error", e => {
                      alert("error")
                    })
                  }
                }))
              }
            })
          }
        }
      })
    }

    // notifDelete();
    function notifDelete() {
      $.ajax({
        url: "{{ URL::route('antrian.notif.delete') }}",
        type: "get"
      })
    }
	});
</script>
@endsection
