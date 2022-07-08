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
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // dev
        // var pusher = new Pusher('07d3c75f0970790e45c6', {
        //     cluster: 'ap1'
        // });

        // prod
        var pusher = new Pusher('2f72f827ef95c4adf968', {
            cluster: 'ap1'
        });

        // customer ke total desain display
		var customer_display = pusher.subscribe('customer-display');
		customer_display.bind('customer-display-event', function(data) {

			$('.antrian_total_desain').empty();

			var queryNomorAntrian = data.antrian_menunggu;

			$('.antrian_total_desain').append(queryNomorAntrian);

		});

        // desain ke display ketika klik panggil
        var desain_panggil = pusher.subscribe('desain-panggil');
        desain_panggil.bind('desain-panggil-event', function(data) {

            $('.antrian_desain').empty();
            var queryNomorAntrian = data.antrian_nomor;
            $('.antrian_desain').append(queryNomorAntrian);

            if (data.desain_nomor == 1) {
                $('.desain .number-1').empty();
                var queryNomorAntrian = data.antrian_nomor;
                $('.desain .number-1').append(queryNomorAntrian);

                antrianDesain(data.antrian_nomor, 1);
            }
            if (data.desain_nomor == 2) {
                $('.desain .number-2').empty();
                var queryNomorAntrian = data.antrian_nomor;
                $('.desain .number-2').append(queryNomorAntrian);

                antrianDesain(data.antrian_nomor, 2);
            }
            if (data.desain_nomor == 3) {
                $('.desain .number-3').empty();
                var queryNomorAntrian = data.antrian_nomor;
                $('.desain .number-3').append(queryNomorAntrian);

                antrianDesain(data.antrian_nomor, 3);
            }
            if (data.desain_nomor == 4) {
                $('.desain .number-4').empty();
                var queryNomorAntrian = data.antrian_nomor;
                $('.desain .number-4').append(queryNomorAntrian);

                antrianDesain(data.antrian_nomor, 4);
            }

            $('.antrian_total_desain').empty();

			var queryNomorAntrian = data.antrian_menunggu;

			$('.antrian_total_desain').append(queryNomorAntrian);
        });

        // update ketika desainer klik selesai
        var desain_selesai = pusher.subscribe('desain-selesai');
        desain_selesai.bind('desain-selesai-event', function(data) {
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
        });

        // desain on / off
        var desain_status = pusher.subscribe('desain-status');
        desain_status.bind('desain-status-event', function(data) {

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
        .cs .card-footer .title {
            text-align: center;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
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
      <div class="">
        <div class="row cs">
          <div class="col-lg-8">
            <div class="card">
                <iframe width="100%" height="640px" src="https://www.youtube.com/embed/KFEI6xyhYpI?playlist=KFEI6xyhYpI&loop=1"></iframe>
            </div>
          </div>
          <div class="col-lg-4" style="height: 640px;">
            <div class="card" style="height: 640px;">
              <div class="card-header">
                <h5 class="title">Nomor Antrian Sekarang</h5>
              </div>
              <div class="card-body">
                    <p class="number" style="margin-top: 150px; font-size: 150px;">
                        <span class="antrian_desain">
                            @if ($antrian_terakhir)
                                {{ $antrian_terakhir->nomor_antrian }}
                            @endif
                        </span>
                    </p>
                </div>
                <div class="card-footer">
                    <h5 class="title">Menunggu <span class="antrian_total_desain text-danger">{{ $antrian_menunggu }}</span>  Antrian</h5>
                </div>
            </div>
          </div>
        </div>
        <div class="row desain">
          @foreach ($antrian_users as $key => $item)
            <div class="col-lg-3 desain-{{ $key + 1 }}">
              <div class="card">
                <div class="card-header header-desain-{{ $key + 1 }}">
                  <h5 class="title desain-{{ $key + 1 }}">Desain {{ $key + 1 }}</h5>
                </div>
                <div class="card-body" style="height: 100px;">
                    <p class="number-{{ $key + 1 }}">
                        @foreach ($antrian_sementaras as $antrian_sementara)
                            @if ($antrian_sementara->karyawan_id == $item->karyawan_id)
                                {{ $antrian_sementara->nomor_antrian }}
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
          @endforeach
					{{-- <div class="col-lg-3 desain-1">
						<div class="card">
							<div class="card-header header-desain-satu">
								<h5 class="title desain-satu">Desain 1</h5>
							</div>
							<div class="card-body">
								<p class="number-satu">-</p>
							</div>
							<div class="card-footer" style="height: 50px;">
								<p></p>
							</div>
            </div>
					</div>
					<div class="col-lg-3 desain-2">
						<div class="card">
              <div class="card-header header-desain-dua">
                <h5 class="title desain-dua">Desain 2</h5>
              </div>
              <div class="card-body">
                <p class="number-dua">-</p>
							</div>
							<div class="card-footer" style="height: 50px;">
								<p></p>
							</div>
            </div>
					</div>
					<div class="col-lg-3 desain-34">
						<div class="card">
              <div class="card-header header-desain-tiga">
                <h5 class="title desain-tiga">Desain 3</h5>
              </div>
              <div class="card-body">
                <p class="number-tiga">-</p>
							</div>
							<div class="card-footer" style="height: 50px;">
								<p></p>
							</div>
            </div>
					</div>
					<div class="col-lg-3 desain-4">
						<div class="card">
              <div class="card-header header-desain-empat">
                <h5 class="title desain-empat">Desain 4</h5>
              </div>
              <div class="card-body">
                <p class="number-empat">-</p>
							</div>
							<div class="card-footer" style="height: 50px;">
								<p></p>
							</div>
            </div>
					</div> --}}
				</div>
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
                    myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 5000);
                } else if (merge_angka == angka && angka > 20) {
                        myVar = setTimeout(function(){ document.getElementById("angka-" + index).play(); }, 5000);
                        myVar = setTimeout(function(){ document.getElementById("angka-" + index1).play(); }, 6000);
                } else{
                    myVar = setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 5000);
                }
            }
        }

        myVar = setTimeout(function(){ document.getElementById("kedesign").play(); }, 7000);
        myVar = setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 9000);
    }
    </script>
</body>
</html>
