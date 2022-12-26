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
      <div class="row">
        <div class="col-3 p-2">
          <div class="bg-white rounded shadow-sm">
            <div class="text-center p-2">12-08-2022</div>
            <div class="text-center p-2 font-weight-bold text-uppercase">uyo</div>
            <div class="text-center p-2">35.000</div>
            <div class="text-center p-2 text-danger">-</div>
            <div class="d-flex justify-content-between">
              <button class="btn btn-warning" style="border-radius: 0 0 0 5px; width: 30.33%;">Approv</button>
              <button class="btn btn-primary" style="border-radius: 0 0 0 0; width: 30.33%;">Revisi</button>
              <button class="btn btn-primary" style="border-radius: 0 0 5px 0; width: 30.33%;">Selesai</button>
            </div>
          </div>
        </div>
        <div class="col-3 p-2">
          <div class="bg-white rounded shadow-sm">
            <div class="text-center p-2">12-08-2022</div>
            <div class="text-center p-2 font-weight-bold text-uppercase">uyo</div>
            <div class="text-center p-2">35.000</div>
            <div class="text-center p-2 text-danger">-</div>
            <div class="d-flex justify-content-between">
              <button class="btn btn-primary btn-block" style="border-radius: 0 0 5px 5px;">Ambil Konsep</button>
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
