@if (Auth::user()->karyawan)
  @if (Auth::user()->karyawan->master_cabang_id == 5)
    <div class="row">
      <div class="col-lg-2 col-md-2 cs">
        <div class="card">
          <div class="card-header header-cs">
            <h5 class="title cs">CS</h5>
          </div>
          <div class="card-body" style="height: 150px;">
            <p class="number-cs">
              @foreach ($antrian_sementara_cs as $antrian_sementara_cs)
                @if ($antrian_sementara_cs->status == 1)
                  C {{ $antrian_sementara_cs->nomor_antrian }}                    
                @elseif ($antrian_sementara_cs->status == 2)
                  C {{ $antrian_sementara_cs->nomor_antrian }}                    
                @else
                @endif
              @endforeach
            </p>
          </div>
          <div class="card-footer" style="height: 50px;">
            <p>
              @foreach ($antrian_user_cs as $item)
                @if ($item->karyawan)
                  @if ($item->karyawan->master_cabang_id == 5)
                    @foreach ($item->antrianUser as $item_user)
                      @if ($item_user->jabatan == "cs" && $item_user->status == "on")
                        {{ $item->karyawan->nama_panggilan }}                        
                      @endif
                    @endforeach                     
                  @endif
                @endif
              @endforeach
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-10 col-md-10 desain">
        <div class="row">
          @if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1)
            @php
              $cabang_id = 1;
            @endphp
          @else
            @php
              $cabang_id = Auth::user()->karyawan->master_cabang_id;
            @endphp
          @endif

          @foreach ($antrian_users as $key => $item)
            @if ($item->karyawan)
              @if ($item->karyawan->master_cabang_id == $cabang_id)
                <div class="col-lg-3 desain-">
                  <div class="card">
                    <div class="card-header header-desain-">
                      <h5 class="title desain-}">Desain {{ $item->nomor }}</h5>
                    </div>
                    <div class="card-body" style="height: 150px;">
                        <p class="number-">
                          @foreach ($antrian_sementaras as $antrian_sementara)
                            @if ($antrian_sementara->karyawan_id == $item->karyawan_id)
                              @if (Auth::user()->karyawan->master_cabang_id == 5)
                                D{{ $antrian_sementara->nomor_antrian }}
                              @else
                                {{ $antrian_sementara->nomor_antrian }}
                              @endif
                            @endif
                          @endforeach
                        </p>
                    </div>
                    <div class="card-footer" style="height: 50px;">
                      <p>
                        @if ($item->status == "on")
                          {{ $item->karyawan->nama_panggilan }}
                        @endif
                      </p>
                    </div>
                  </div>
                </div>
              @endif
            @endif
          @endforeach
        </div>
      </div>
    </div>
  @else
    <div class="d-flex justify-content-center desain">
      @if (Auth::user()->roles == "admin" || Auth::user()->karyawan->master_cabang_id == 1)
        @php
          $cabang_id = 1;
        @endphp
      @else
        @php
          $cabang_id = Auth::user()->karyawan->master_cabang_id;
        @endphp
      @endif
      @foreach ($antrian_users as $key => $item)
        @if ($item->karyawan)
          @if ($item->karyawan->master_cabang_id == $cabang_id)
            <div class="col-lg-3 desain-">
              <div class="card">
                <div class="card-header header-desain-">
                  <h5 class="title desain-}">Desain {{ $item->nomor }}</h5>
                </div>
                <div class="card-body" style="height: 150px;">
                    <p class="number-">
                      @foreach ($antrian_sementaras as $antrian_sementara)
                        @if ($antrian_sementara->karyawan_id == $item->karyawan_id)
                          @if (Auth::user()->karyawan->master_cabang_id == 5)
                            D{{ $antrian_sementara->nomor_antrian }}
                          @else
                            {{ $antrian_sementara->nomor_antrian }}
                          @endif
                        @endif
                      @endforeach
                    </p>
                </div>
                <div class="card-footer" style="height: 50px;">
                  <p>
                    @if ($item->status == "on")
                      {{ $item->karyawan->nama_panggilan }}
                    @endif
                  </p>
                </div>
              </div>
            </div>
          @endif
        @endif
      @endforeach
    </div>
  @endif
@endif