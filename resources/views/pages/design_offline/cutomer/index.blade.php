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
      <div class="row d-flex justify-content-center">
        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <form action="">
                <div class="mb-3">
                  <label for="nama_konsumen">Nama Konsumen</label>
                  <input type="text" name="nama_konsumen" id="nama_konsumen" class="form-control">
                </div>
                <div class="mb-3">
                  <label for="harga_desain">Harga Desain</label>
                  <input type="text" name="harga_desain" id="harga_desain" class="form-control">
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary btn-block">input</button>
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

@endsection
