@if (Auth::user()->karyawan && Auth::user()->karyawan->master_cabang_id == 5)
  <div class="card" style="height: 375px;">
    <div class="card-header">
      <h2 class="text-uppercase">Nomor Antrian cs</h2>
    </div>
    <div class="card-body">
      <p class="number" style="margin-top: 10px; font-size: 130px;">
        <span class="antrian_cs">
          C {{ $antrian_terakhir_cs }}
        </span>
      </p>
    </div>
    <div class="card-footer">
      <h1 class="title">Total Antrian <span class="antrian_total_pbg_cs text-danger">{{ $total_antrian_cs }}</span></h1>
    </div>
  </div>
  <div class="card" style="height: 375px;">
    <div class="card-header">
      <h2 class="text-uppercase">Nomor Antrian desain</h2>
    </div>
    <div class="card-body">
      <p class="number" style="margin-top: 10px; font-size: 130px;">
        <span class="antrian_desain">
          D {{ $antrian_terakhir }}
        </span>
      </p>
    </div>
    <div class="card-footer">
      <h1 class="title">Total Antrian <span class="antrian_total_pbg_desain text-danger">{{ $total_antrian }}</span></h1>
    </div>
  </div>
@else
  <div class="card" style="height: 770px;">
    <div class="card-header">
      <h2 class="text-uppercase">Nomor Antrian Terakhir</h2>
    </div>
    <div class="card-body">
      <p class="number" style="margin-top: 150px; font-size: 150px;">
        <span class="antrian_desain">
          {{ $antrian_terakhir }}
        </span>
      </p>
    </div>
    <div class="card-footer">
      <h1 class="title">Total Antrian <span class="antrian_total_desain text-danger">{{ $total_antrian }}</span></h1>
    </div>
  </div>
@endif