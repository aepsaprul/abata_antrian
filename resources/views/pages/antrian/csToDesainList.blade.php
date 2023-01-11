@foreach ($nomors as $item)
  <div class="col-3">
    <div class="card">
      <div class="card-header">
        <h6 class="text-uppercase text-center">antrian</h6>
      </div>
      <div class="card-body text-center">
        <span class="text-uppercase font-weight-bold" style="font-size: 50px;">C {{ $item->nomor_antrian }}</span><br>
        <span class="text-uppercase">{{ $item->nama_customer }}</span>
        @if ($item->status == 1 || $item->status == 2)
          @if ($item->karyawan == null)
            <br><span class="text-uppercase text-danger">admin</span>
          @else
            <br><span class="text-uppercase text-danger font-weight-bold">{{ $item->karyawan->nama_panggilan }}</span>
          @endif      
        @else
          <br><span class="text-uppercase text-danger">-</span>
        @endif
      </div>
      <div class="card-footer">
        @if ($item->status == 0)
          <div class="d-flex justify-content-center">
            <button class="btn btn-primary btn-panggil-cstodesain" style="width: 50px;" title="Panggil" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-phone"></i></button>
          </div>
        @endif
            
        @if ($item->status == 1)
          @if ($item->customer_filter_id == 2)
            <div class="d-flex justify-content-center">
              <button class="btn btn-primary btn-panggil-cstodesain" style="width: 50px;" title="Panggil" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-phone"></i></button>
            </div>
          @else
          <div class="d-flex justify-content-between">
            <button class="btn btn-primary btn-panggil-cstodesain" style="width: 50px;" title="Panggil" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-phone"></i></button>
            <button class="btn btn-success btn-mulai-cstodesain" style="width: 50px;" title="Mulai" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-play"></i></button>
            <button class="btn btn-danger btn-batal-cstodesain" style="width: 50px;" title="Batal" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-times"></i></button>
          </div>
          @endif
        @endif
            
        @if ($item->status == 2)
          <div class="d-flex justify-content-center">
            <button class="btn btn-success btn-selesai-cstodesain" style="width: 50px;" title="Selesai" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-check"></i></button>
          </div>
        @endif          
      </div>
    </div>
  </div>    
@endforeach
