@php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
@endphp
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link href="{{ asset('public/assets/logo-daun.png') }}" rel="icon" type="image/x-icon">
  <title>Abata Display</title>

  <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>

    <script>
        let user = {!! Auth::user() !!};

        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // dev
        var pusher = new Pusher('07d3c75f0970790e45c6', {
            cluster: 'ap1'
        });

        // prod
        // var pusher = new Pusher('2f72f827ef95c4adf968', {
        //     cluster: 'ap1'
        // });

        // customer ke total antrian
		var customer_display = pusher.subscribe('customer-display');
		customer_display.bind('customer-display-event', function(data) {
            if (data.cabang_id == 5) {
                if (data.customer_filter_id == 3) {
                    $('.antrian_total_pbg_cs').empty();
                    var queryNomorAntrian = data.total_antrian;
                    $('.antrian_total_pbg_cs').append(queryNomorAntrian);
                } else {
                    $('.antrian_total_pbg_desain').empty();
                    var queryNomorAntrian = data.total_antrian;
                    $('.antrian_total_pbg_desain').append(queryNomorAntrian);
                }
            } else {
                if (user.karyawan.master_cabang_id == data.cabang_id) {
                    $('.antrian_total_desain').empty();
                    var queryNomorAntrian = data.total_antrian;
                    $('.antrian_total_desain').append(queryNomorAntrian);
                }
            }
		});

        // desain klik panggil
        var desain_panggil = pusher.subscribe('desain-panggil');
        desain_panggil.bind('desain-panggil-event', function(data) {
            if (user.karyawan.master_cabang_id == data.cabang_id) {
                $('.antrian_desain').empty();

                var queryNomorAntrian = "";

                if (data.cabang_id == 5) {
                    queryNomorAntrian += 'D' + data.antrian_nomor;
                    antrianDesainPbg(data.antrian_nomor, data.desain_nomor);
                } else {
                    queryNomorAntrian += data.antrian_nomor;
                    antrianDesain(data.antrian_nomor, data.desain_nomor);
                }

                $('.antrian_desain').append(queryNomorAntrian);

                if (data.desain_nomor == 1) {
                    $('.desain .number-1').empty();
                    $('.desain .number-1').append(queryNomorAntrian);
                }
                if (data.desain_nomor == 2) {
                    $('.desain .number-2').empty();
                    $('.desain .number-2').append(queryNomorAntrian);
                }
                if (data.desain_nomor == 3) {
                    $('.desain .number-3').empty();
                    $('.desain .number-3').append(queryNomorAntrian);
                }
                if (data.desain_nomor == 4) {
                    $('.desain .number-4').empty();
                    $('.desain .number-4').append(queryNomorAntrian);
                }
            }
        });

        // desain klik selesai
        var desain_selesai = pusher.subscribe('desain-selesai');
        desain_selesai.bind('desain-selesai-event', function(data) {
            if (user.karyawan.master_cabang_id == data.cabang_id) {
                if (data.desain_nomor == 1) {
                    $('.desain .number-1').empty();
                    var keterangan = data.keterangan;
                    $('.desain .number-1').append(keterangan);
                }
                if (data.desain_nomor == 2) {
                    $('.desain .number-2').empty();
                    var keterangan = data.keterangan;
                    $('.desain .number-2').append(keterangan);
                }
                if (data.desain_nomor == 3) {
                    $('.desain .number-3').empty();
                    var keterangan = data.keterangan;
                    $('.desain .number-3').append(keterangan);
                }
                if (data.desain_nomor == 4) {
                    $('.desain .number-4').empty();
                    var keterangan = data.keterangan;
                    $('.desain .number-4').append(keterangan);
                }
            }
        });

        // desain on / off
        var desain_status = pusher.subscribe('desain-status');
        desain_status.bind('desain-status-event', function(data) {
            if (user.karyawan.master_cabang_id == data.cabang_id) {
                if (data.desain_nomor == 1) {
                    if (data.status == "on") {
                        $(".desain .desain-1 .card-footer p").append(data.nama_desain);
                    } else {
                        $(".desain .desain-1 .card-footer p").empty();
                    }
                }
                if (data.desain_nomor == 2) {
                    if (data.status == "on") {
                        $(".desain .desain-2 .card-footer p").append(data.nama_desain);
                    } else {
                        $(".desain .desain-2 .card-footer p").empty();
                    }
                }
                if (data.desain_nomor == 3) {
                    if (data.status == "on") {
                        $(".desain .desain-3 .card-footer p").append(data.nama_desain);
                    } else {
                        $(".desain .desain-3 .card-footer p").empty();
                    }
                }
                if (data.desain_nomor == 4) {
                    if (data.status == "on") {
                        $(".desain .desain-4 .card-footer p").append(data.nama_desain);
                    } else {
                        $(".desain .desain-4 .card-footer p").empty();
                    }
                }
            }
        });

        // cs on / off
        var cs_status = pusher.subscribe('cs-status');
        cs_status.bind('cs-status-event', function(data) {
            if (user.karyawan.master_cabang_id == data.cabang_id) {
                if (data.status == "on") {
                    $(".cs .card-footer p").append(data.nama_cs);
                } else {
                    $(".cs .card-footer p").empty();
                }
            }
        });

        // cs klik panggil
        var cs_panggil = pusher.subscribe('cs-panggil');
		cs_panggil.bind('cs-panggil-event', function(data) {

			$('.antrian_cs').empty();
			$('.number-cs').empty();

			var queryNomorAntrian = "C" + data.antrian_nomor;

			$('.antrian_cs').append(queryNomorAntrian);
			$('.number-cs').append(queryNomorAntrian);

            if (user.karyawan.master_cabang_id == data.cabang_id) {
                antrianCs(data.antrian_nomor);
            }
		});

        // cs klik selesai
        var cs_selesai = pusher.subscribe('cs-selesai');
		cs_selesai.bind('cs-selesai-event', function(data) {

			$('.cs .number-cs').empty();

			var keterangan = data.keterangan;

			$('.cs .number-cs').append(keterangan);

		});

        // cs to desain panggil
        var cs_to_desain_panggil = pusher.subscribe('cs-to-desain-panggil');
        cs_to_desain_panggil.bind('cs-to-desain-panggil-event', function(data) {
            if (user.karyawan.master_cabang_id == data.cabang_id) {
                $('.antrian_desain').empty();

                var queryNomorAntrian = "C" + data.antrian_nomor;
                antrianCsToDesainPbg(data.antrian_nomor, data.desain_nomor);

                $('.antrian_desain').append(queryNomorAntrian);

                if (data.desain_nomor == 1) {
                    $('.desain .number-1').empty();
                    $('.desain .number-1').append(queryNomorAntrian);
                }
                if (data.desain_nomor == 2) {
                    $('.desain .number-2').empty();
                    $('.desain .number-2').append(queryNomorAntrian);
                }
                if (data.desain_nomor == 3) {
                    $('.desain .number-3').empty();
                    $('.desain .number-3').append(queryNomorAntrian);
                }
                if (data.desain_nomor == 4) {
                    $('.desain .number-4').empty();
                    $('.desain .number-4').append(queryNomorAntrian);
                }
            }
        });

    </script>
    <style>
        .cs .card-header {
            background-color: #fbdd23;
            text-align: center;
        }
        .cs .card-header .title {
            text-align: center;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .cs .card-body .number {
            font-size: 5em;
            font-family: 'arial';
            font-weight: bold;
            text-align: center;
        }
        .cs .card-body p {
            font-size: 3em;
            font-family: 'arial';
            font-weight: bold;
            text-align: center;
        }
        .cs .card-footer .title {
            text-align: center;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .cs .card-footer p {
            text-align: center;
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 1.5em;
        }

        .desain .col-lg-2 .card {
            height: 250px;
        }
        .desain .card-header {
            background-color: #fbdd23;
            text-align: center;
        }
        .desain .card-header .title {
            text-align: center;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            color: black;
        }
        .desain .card-body p {
            font-size: 3em;
            font-family: 'arial';
            font-weight: bold;
            text-align: center;
        }
        .desain .card-footer p {
            text-align: center;
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 1.5em;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <div class="content-wrapper" style="background-color: #176BB3;">
        <div class="content-header">
            <div class="container">
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div>
                <div class="row cs">
                    <div class="col-lg-8">
                        <div class="card">
                            <iframe width="100%" height="770px" src="https://www.youtube.com/embed/videoseries?list=PLUmr4_LW9HnOp4yQP-d5K-kZ1rJ0nI7yG&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-lg-4" style="height: 770px;">
                        @if (Auth::user()->karyawan && Auth::user()->karyawan->master_cabang_id == 5)
                            <div class="card" style="height: 375px;">
                                <div class="card-header">
                                    <h2 class="text-uppercase">Nomor Antrian cs</h2>
                                </div>
                                <div class="card-body">
                                    <p class="number" style="margin-top: 10px; font-size: 130px;">
                                        <span class="antrian_cs">
                                            C{{ $antrian_terakhir_cs }}
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
                                            D{{ $antrian_terakhir }}
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
                                    <h2 class="text-uppercase">Nomor Antrian Sekarang</h2>
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
                    </div>
                </div>
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
                                      @foreach ($antrian_sementara_cs as $antrian_sementara)
                                          @if ($antrian_sementara->karyawan_id == $antrian_user_cs->karyawan_id)
                                              {{ $antrian_sementara->nomor_antrian }}
                                          @endif
                                      @endforeach
                                  </p>
                              </div>
                              <div class="card-footer" style="height: 50px;">
                                  <p>
                                      @if ($antrian_user_cs->status == "on")
                                          {{ $antrian_user_cs->karyawan->nama_panggilan }}
                                      @endif
                                  </p>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-10 col-md-10 desain">
                          <div class="row">                    
                @endif
                @else
                            <div class="d-flex justify-content-center desain">
                @endif
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
                                            <div class="col-lg-3 desain-{{ $item->nomor }}">
                                                <div class="card">
                                                    <div class="card-header header-desain-{{ $item->nomor }}">
                                                        <h5 class="title desain-{{ $item->nomor }}">Desain {{ $item->nomor }}</h5>
                                                    </div>
                                                    <div class="card-body" style="height: 150px;">
                                                        <p class="number-{{ $item->nomor }}">
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
                @if (Auth::user()->karyawan)
                  @if (Auth::user()->karyawan->master_cabang_id == 5)
                            </div>
                        </div>
                    </div>                      
                  @endif
                @endif
            </div>
        </div>
    </div>
</div>

<audio src="{{ asset('public/assets/ringtone/suara_antrian.mp3') }}" id="notif" controls style="display: none;"></audio>
<audio src="{{ asset('public/assets/ringtone/antrian.mp3') }}" id="nomor_antrian" controls style="display: none;"></audio>
<audio src="{{ asset('public/assets/ringtone/c.wav') }}" id="c" controls style="display: none;"></audio>
<audio src="{{ asset('public/assets/ringtone/d.wav') }}" id="d" controls style="display: none;"></audio>

@for ($i = 1; $i < 20; $i++)
    <audio src="{{ asset('public/assets/ringtone/'.$i.'.mp3') }}" id="angka-@php echo $i @endphp" controls style="display: none;"></audio>
@endfor

@for ($j = 20; $j < 100; $j+=10)
    <audio src="{{ asset('public/assets/ringtone/'.$j.'.mp3') }}" id="angka-@php echo $j @endphp" controls style="display: none;"></audio>
@endfor

@for ($k = 100; $k <= 500; $k+=100)
    <audio src="{{ asset('public/assets/ringtone/'.$k.'.mp3') }}" id="angka-@php echo $k @endphp" controls style="display: none;"></audio>
@endfor

<audio src="{{ asset('public/assets/ringtone/kecs.mp3') }}" id="kecs" controls style="display: none;"></audio>
<audio src="{{ asset('public/assets/ringtone/kedesign.mp3') }}" id="kedesign" controls style="display: none;"></audio>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('public/themes/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/themes/dist/js/adminlte.min.js') }}"></script>

<script>
    var myVar;

    function antrianDesain(angka, desain) {
        myVar = setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
        myVar = setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);

        for (let index = 0; index < 100; index+=10) {
            for (let index1 = 1; index1 <= 10; index1++) {
                var merge_angka = index + index1;
                if (angka == 30 || angka == 40 || angka == 50 || angka == 60 || angka == 70 || angka == 80 || angka == 90) {
                    myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 4300);
                } else if (merge_angka == angka && angka > 20) {
                        myVar = setTimeout(function(){ document.getElementById("angka-" + index).play(); }, 4300);
                        myVar = setTimeout(function(){ document.getElementById("angka-" + index1).play(); }, 4300);
                } else{
                    myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 4300);
                }
            }
        }

        myVar = setTimeout(function(){ document.getElementById("kedesign").play(); }, 5000);
        myVar = setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 6100);
    }

    function antrianDesainPbg(angka, desain) {
		myVar = setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
		myVar = setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
		myVar = setTimeout(function(){ document.getElementById("d").play(); }, 5000);

		for (let index = 0; index < 100; index+=10) {
			for (let index1 = 1; index1 <= 10; index1++) {
				var merge_angka = index + index1;
				if (angka == 30 || angka == 40 || angka == 50 || angka == 60 || angka == 70 || angka == 80 || angka == 90) {
					myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
				} else if (merge_angka == angka && angka > 20) {
						myVar = setTimeout(function(){ document.getElementById("angka-" + index).play(); }, 6000);
						myVar = setTimeout(function(){ document.getElementById("angka-" + index1).play(); }, 7000);
				} else{
					myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
				}
			}
		}

		myVar = setTimeout(function(){ document.getElementById("kedesign").play(); }, 8000);
		myVar = setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 10000);
	}

    function antrianCsToDesainPbg(angka, desain) {
		myVar = setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
		myVar = setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
		myVar = setTimeout(function(){ document.getElementById("c").play(); }, 5000);

		for (let index = 0; index < 100; index+=10) {
			for (let index1 = 1; index1 <= 10; index1++) {
				var merge_angka = index + index1;
				if (angka == 30 || angka == 40 || angka == 50 || angka == 60 || angka == 70 || angka == 80 || angka == 90) {
					myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
				} else if (merge_angka == angka && angka > 20) {
						myVar = setTimeout(function(){ document.getElementById("angka-" + index).play(); }, 6000);
						myVar = setTimeout(function(){ document.getElementById("angka-" + index1).play(); }, 7000);
				} else{
					myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
				}
			}
		}

		myVar = setTimeout(function(){ document.getElementById("kedesign").play(); }, 8000);
		myVar = setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 10000);
	}

    function antrianCs(angka) {
		myVar = setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
		myVar = setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
		myVar = setTimeout(function(){ document.getElementById("c").play(); }, 5000);

		for (let index = 0; index < 100; index+=10) {
			for (let index1 = 1; index1 <= 10; index1++) {
				var merge_angka = index + index1;
				if (angka == 30 || angka == 40 || angka == 50 || angka == 60 || angka == 70 || angka == 80 || angka == 90) {
					myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
				} else if (merge_angka == angka && angka > 20) {
						myVar = setTimeout(function(){ document.getElementById("angka-" + index).play(); }, 6000);
						myVar = setTimeout(function(){ document.getElementById("angka-" + index1).play(); }, 7000);
				} else{
					myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
				}
			}
		}

		myVar = setTimeout(function(){ document.getElementById("kecs").play(); }, 8000);
	}
    </script>
</body>
</html>
