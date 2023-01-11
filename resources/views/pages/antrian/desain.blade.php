@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between">
        <h4 class="text-center text-uppercase">DESAIN {{ Auth::user()->name }}</h4>
        <p style="text-align: center;">
          {{-- <span class="stopwatch h3">00:00:00</span> --}}
        </p>
        <p style="text-align: center;">
          @if (Auth::user()->roles == "admin")
            <a href="#" class="btn btn-danger btn-sm">Komputer OFF</a>
          @else
            @if ($antrian_user->status == "off")
              <a href="{{ url('antrian/page_desain/' . Auth::user()->master_karyawan_id . '/status/on') }}" class="btn btn-danger">Komputer OFF</a>
            @else
              <a href="{{ url('antrian/page_desain/' . Auth::user()->master_karyawan_id . '/status/off') }}" class="btn btn-success">Komputer ON</a>
            @endif
          @endif
        </p>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      {{-- cabang id --}}
      <input type="hidden" name="cabang_id" id="cabang_id"
        @if (Auth::user()->master_karyawan_id == 0)
          value="1"
        @else
          value="{{ Auth::user()->karyawan->master_cabang_id }}"
        @endif
      >
      @if (Auth::user()->karyawan)
        @if (Auth::user()->karyawan->master_cabang_id == 5)
          {{-- cs to desain --}}
          <div class="row">
            <div class="col-12">
              <div class="layer-1">
                <div class="row data-cs"></div>
              </div>
            </div>
          </div>
          <hr>                  
        @endif
      @endif
      {{-- desain page --}}
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
        desainList();
        csToDesainList();
        tanggalAntrianSementara();
        tampil();
      }, 1000);
    }

    // desainList();
    function desainList() {
      $.ajax({
        url: "{{ URL::route('antrian_desain.list') }}",
        success: function (result) {
          $('.data-nomor').html(result);
        }
      })
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
        url: "{{ URL::route('antrian_desain.aksi') }}",
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
        url: "{{ URL::route('antrian_desain.aksi') }}",
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
        url: "{{ URL::route('antrian_desain.aksi') }}",
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
        url: "{{ URL::route('antrian_desain.aksi') }}",
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

    // desain
    $(document).on('click', '.btn-desain', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "desain"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_desain.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-desain').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Desain dipilih'
          })
        }
      })
    })

    // edit
    $(document).on('click', '.btn-edit', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "edit"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_desain.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-edit').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Edit dipilih'
          })
        }
      })
    })

    // cs to desain
    // csToDesainList();
    function csToDesainList() {
      $.ajax({
        url: "{{ URL::route('antrian_cs_to_desain.list') }}",
        success: function (result) {
          $('.data-cs').html(result);
        }
      })
    }

    // cs to desain panggil
    $(document).on('click', '.btn-panggil-cstodesain', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "panggil"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs_to_desain.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-panggil-cstodesain').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Sedang dipanggil'
          })
        }
      })
    })

    // cs to desain mulai
    $(document).on('click', '.btn-mulai-cstodesain', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "mulai"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs_to_desain.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-mulai-cstodesain').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Mulai'
          })
        }
      })
    })

    // cs to desain selesai
    $(document).on('click', '.btn-selesai-cstodesain', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "selesai"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs_to_desain.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-selesai-cstodesain').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Selesai'
          })
        }
      })
    })

    // cs to desain batal
    $(document).on('click', '.btn-batal-cstodesain', function (e) {
      e.preventDefault();
      let nomor = $(this).attr('data-id');

      let formData = {
        nomor: nomor,
        aksi: "batal"
      }
      
      $.ajax({
        url: "{{ URL::route('antrian_cs_to_desain.aksi') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('.btn-batal-cstodesain').attr('disabled', true);
        },
        success: function (response) {
          Toast.fire({
            icon: 'success',
            title: 'Batal'
          })
        }
      })
    })

    // reset
    function reset() {
      $.ajax({
        url: "{{ URL::route('antrian_reset_antrian') }}",
        type: "get",
        success: function (response) {}
      })    
    }

    let tanggal = new Date();
    let tanggal_sekarang = tanggal.getDate();

    function tanggalAntrianSementara() {
      $.ajax({
        url: "{{ URL::route('antrian.tanggal') }}",
        type: "get",
        success: function (response) {
          if (response.status != null) {
            if (tanggal_sekarang != response.status) {
              reset();
            }            
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
                      body: "Buka Halaman Desain"
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
