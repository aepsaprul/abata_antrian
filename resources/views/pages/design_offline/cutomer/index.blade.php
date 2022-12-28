@extends('layouts.app')

@section('style')
<style>
  #list_konsumen ul li:hover {
    background-color: #f1f1f1;
  }
</style>
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
        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <form action="">
                <div class="mb-3">
                  <input type="hidden" name="konsumen_id" id="konsumen_id">
                  <label for="nama_konsumen">Nama Konsumen</label>
                  <input type="text" name="nama_konsumen" id="nama_konsumen" class="form-control" required autocomplete="off">
                  <div id="list_konsumen" class="d-none" style="position: absolute; background-color: white; width: 93%; height: 250px; overflow: auto; padding: 10px"></div>
                </div>
                <div class="mb-3">
                  <label for="harga_desain">Harga Desain</label>
                  <input type="text" name="harga_desain" id="harga_desain" class="form-control" required>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary btn-block btn-spinner-input d-none" disabled><span class="spinner-grow spinner-grow-sm"></span></button>
                  <button type="button" class="btn btn-primary btn-block btn-input">Input</button>
                </div>
              </form>
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

    let harga_desain_rupiah = document.getElementById("harga_desain");
    harga_desain_rupiah.addEventListener("keyup", function(e) {
        harga_desain_rupiah.value = formatRupiah(this.value, "");
    });

    $(document).on('keyup', '#nama_konsumen', function () {
      $('#list_konsumen').removeClass('d-none');
      $('#list_konsumen').empty();
      
      let formData = {
        nama_konsumen: $('#nama_konsumen').val()
      }

      $.ajax({
        url: "{{ URL::route('design_offline.customer.search') }}",
        type: "post",
        data: formData,
        success: function (response) {
          let data_konsumen = '<ul style="list-style: none; margin: 0; padding: 0;">';
          $.each(response.customers, function (index, item) {
            data_konsumen += '<li><button type="button" class="list_konten" data-id="' + item.id + '" style="border: none; background: none;" value="' + item.nama_customer + '">' + item.nama_customer + ' - ' + item.telepon + '</button></li>';
          })
          data_konsumen += '</ul>';

          $('#list_konsumen').append(data_konsumen);
        }
      })
    })

    $(document).on('click', '.list_konten', function (index, item) {
      let id = $(this).attr("data-id");
      let val = $(this).val();
      
      $('#nama_konsumen').val(val);
      $('#konsumen_id').val(id);
    })

    $(document).on('click', function () {
      $('#list_konsumen').addClass('d-none');
    })

    $(document).on('click', '.btn-input', function(e) {
      e.preventDefault();
      let konsumen_id = $('#konsumen_id').val();
      let harga_desain = $('#harga_desain').val().replace('.', '');

      if (konsumen_id == "") {
        alert("Pilih Konsumen Yang Tersedia");
      } else if (harga_desain == "") {
        alert("Harga Desain Harus Diisi");
      } else {
        let formData = {
          konsumen_id: konsumen_id,
          harga_desain: harga_desain
        }
  
        $.ajax({
          url: "{{ URL::route('design_offline.customer.store') }}",
          type: "post",
          data: formData,
          beforeSend: function () {
            $('.btn-spinner-input').removeClass('d-none');
            $('.btn-input').addClass('d-none');
          },
          success: function (response) {
            Toast.fire({
              icon: 'success',
              title: 'Data berhasil disimpan'
            })

            setTimeout(() => {
              $('.btn-spinner-input').addClass('d-none');
              $('.btn-input').removeClass('d-none');
              $('#konsumen_id').val("");
              $('#nama_konsumen').val("");
              $('#harga_desain').val("");
            }, 1000);
          }
        })
      }
    })
  })
</script>
@endsection
