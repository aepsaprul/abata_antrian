@foreach ($nomors as $item)
  <div class="col-3">
    <div class="card">
      <div class="card-header">
        <h6 class="text-uppercase text-center">antrian</h6>
      </div>
      <div class="card-body text-center">
        <span class="text-uppercase font-weight-bold" style="font-size: 50px;">
          @if ($item->cabang_id == 5)
            D
          @endif
          {{ $item->nomor_antrian }}
        </span><br>
        <span class="text-uppercase">{{ $item->nama_customer }}</span><br>
        <span class="text-uppercase">
          @if ($item->customer_filter_id == 1)
            Siap Cetak
          @elseif ($item->customer_filter_id == 4)
            Desain
          @elseif ($item->customer_filter_id == 5)
            Edit
          @else
            <a href="#" class="btn-desain" data-id="{{ $item->nomor_antrian }}" style="width: 100px;">Desain</a>
            / 
            <a href="#" class="btn-edit" data-id="{{ $item->nomor_antrian }}" style="width: 100px;">Edit</a>
          @endif
        </span>

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
            <div class="btn-panggil" style="width: 50px; background-color: blue; color: white; border-radius: 3px; text-align:center; padding: 5px 0; cursor: pointer;" title="Panggil" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-phone"></i></div>
          </div>
        @endif
        
        @if ($item->status == 1)
          @if ($item->customer_filter_id == 2)
            <div class="d-flex justify-content-center">
              <div class="btn-panggil" style="width: 50px; background-color: blue; color: white; border-radius: 3px; text-align:center; padding: 5px 0; cursor: pointer;" title="Panggil" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-phone"></i></div>
            </div>
          @else
            <div class="d-flex justify-content-between">
              <div class="btn-panggil" style="width: 50px; background-color: blue; color: white; border-radius: 3px; text-align:center; padding: 5px 0; cursor: pointer;" title="Panggil" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-phone"></i></div>
              <div class="btn-mulai" style="width: 50px; background-color: green;; color: white; border-radius: 3px; text-align:center; padding: 5px 0; cursor: pointer;" title="Mulai" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-play"></i></div>
              <div class="btn-batal" style="width: 50px; background-color: red;; color: white; border-radius: 3px; text-align:center; padding: 5px 0; cursor: pointer;" title="Batal" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-times"></i></div>
            </div>
          @endif
        @endif
        
        @if ($item->status == 2)
          <div class="d-flex justify-content-center">
            <div class="btn-selesai" style="width: 50px; background-color: green;; color: white; border-radius: 3px; text-align:center; padding: 5px 0; cursor: pointer;" title="Selesai" data-id="{{ $item->nomor_antrian }}"><i class="fas fa-check"></i></div>
          </div>
        @endif
                
      </div>
    </div>
  </div>    
@endforeach
