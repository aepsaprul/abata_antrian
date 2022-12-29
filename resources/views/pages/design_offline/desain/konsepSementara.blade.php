@foreach ($konsep_sementaras as $item)
  <div class="col-3 p-2">
    <div class="bg-white rounded shadow-sm">
      <div class="text-center p-2">{{ $item->created_at }}</div>
      <div class="text-center p-2 font-weight-bold text-uppercase">{{ $item->customer->nama_customer }}</div>
      <div class="text-center p-2">{{ $item->harga_desain }}</div>
      <div class="text-center p-2 text-danger">-</div>
      <div class="d-flex justify-content-between">
        @if ($item->status_id == 0)
          <button class="btn btn-primary btn-block btn-ambil" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 5px;">Ambil Konsep</button>
        @elseif ($item->status_id == 4)
          <button class="btn btn-warning btn-block btn-selesai" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 5px;">Selesai</button>
        @else
          @if ($item->status_id == 2)
            <button class="btn btn-warning btn-approv" data-id="{{ $item->id }}" style="border-radius: 0 0 0 5px; width: 30.33%;">Approv</button>               
          @else
            <button class="btn btn-primary btn-approv" data-id="{{ $item->id }}" style="border-radius: 0 0 0 5px; width: 30.33%;">Approv</button>              
          @endif

          @if ($item->status_id == 3)
            <button class="btn btn-warning btn-revisi" data-id="{{ $item->id }}" style="border-radius: 0 0 0 0; width: 30.33%;">Revisi</button>              
          @else
            <button class="btn btn-primary btn-revisi" data-id="{{ $item->id }}" style="border-radius: 0 0 0 0; width: 30.33%;">Revisi</button>              
          @endif

          <button class="btn btn-primary btn-selesai" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 0; width: 30.33%;">Selesai</button>
        @endif
      </div>
    </div>
  </div>
@endforeach