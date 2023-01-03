@php
  function rupiah($angka){
    $hasil =  number_format($angka,0, ',' , '.');
    return $hasil;
  }
@endphp

@foreach ($konseps as $item)
  <div class="col-3 p-2">
    <div class="bg-white rounded shadow-sm">
      <div class="text-center p-2">{{ $item->created_at }}</div>
      <div class="text-center p-2 font-weight-bold text-uppercase">{{ $item->customer->nama_customer }}</div>
      <div class="text-center p-2">{{ rupiah($item->harga_desain) }}</div>
      <div class="text-center p-2 text-danger text-uppercase" style="height: 50px; font-size: 14px;">
        @foreach ($konsep_timers as $item_timer)
          @if ($item_timer->konsep_id == $item->id)
            @if ($item_timer->user)
              {{ $item_timer->user->name }},
            @endif
          @endif
        @endforeach
      </div>
      <div class="d-flex justify-content-between">
        @if ($item->status_id == 0)
          <button class="btn btn-primary btn-block btn-ambil" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 5px;">Ambil Konsep</button>
        @elseif ($item->status_id == 4)
          <button class="btn btn-warning btn-block btn-selesai" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 5px;">Selesai</button>
        @elseif ($item->status_id == 3)
          <button class="btn btn-primary btn-approv" data-id="{{ $item->id }}" style="border-radius: 0 0 0 5px; width: 45%;">Approv</button>
          <button class="btn btn-warning btn-revisi" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 0; width: 45%;" disabled>Revisi</button>
        @else
          @if ($item->status_id == 2)
            <button class="btn btn-warning btn-approv" data-id="{{ $item->id }}" style="border-radius: 0 0 0 5px; width: 30.33%;" disabled>Approv</button>
            <button class="btn btn-primary btn-revisi" data-id="{{ $item->id }}" style="border-radius: 0 0 0 0; width: 30.33%;">Revisi</button>
            <button class="btn btn-primary btn-selesai" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 0; width: 30.33%;">Selesai</button>               
          @else
            <button class="btn btn-primary btn-block btn-approv" data-id="{{ $item->id }}" style="border-radius: 0 0 5px 5px; color: yellow;">Approv</button> 
          @endif
        @endif
      </div>
    </div>
  </div>
@endforeach