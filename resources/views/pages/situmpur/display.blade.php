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

  <title>Abata Display</title>

  <!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">
	<script src="https://js.pusher.com/7.1/pusher.min.js"></script>

	<script>
		// Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('07d3c75f0970790e45c6', {
        cluster: 'ap1'
        });

		// desain ke display ketika klik panggil
		var desain_display = pusher.subscribe('desain-panggil');
		desain_display.bind('desain-panggil-event', function(data) {

			$('.antrian_desain').empty();
			var queryNomorAntrian = data.antrian_nomor;
			$('.antrian_desain').append(queryNomorAntrian);

			if (data.desain_nomor == 1) {
				$('.desain .number-satu').empty();
				var queryNomorAntrian = data.antrian_nomor;
				$('.desain .number-satu').append(queryNomorAntrian);

				antrianDesain(data.antrian_nomor, 1);
			}
			if (data.desain_nomor == 2) {
				$('.desain .number-dua').empty();
				var queryNomorAntrian = data.antrian_nomor;
				$('.desain .number-dua').append(queryNomorAntrian);

				antrianDesain(data.antrian_nomor, 2);
			}
			if (data.desain_nomor == 3) {
				$('.desain .number-tiga').empty();
				var queryNomorAntrian = data.antrian_nomor;
				$('.desain .number-tiga').append(queryNomorAntrian);

				antrianDesain(data.antrian_nomor, 3);
			}
			if (data.desain_nomor == 4) {
				$('.desain .number-empat').empty();
				var queryNomorAntrian = data.antrian_nomor;
				$('.desain .number-empat').append(queryNomorAntrian);

				antrianDesain(data.antrian_nomor, 4);
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #176BB3;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="">
        <div class="row cs">
          <div class="col-lg-8">
            <div class="card">
                <iframe width="100%" height="640px" src="https://www.youtube.com/embed/KFEI6xyhYpI?playlist=KFEI6xyhYpI&loop=1"></iframe>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-4" style="height: 640px;">
            <div class="card" style="height: 640px;">
              <div class="card-header">
                <h5 class="title">Nomor Antrian</h5>
              </div>
              <div class="card-body">
                <p class="number" style="margin-top: 150px; font-size: 150px;"><span class="antrian_desain">0</span></p>
            </div>
            <div class="card-footer">
                <h5 class="title">Total Antrian <span class="antrian_total_desain">0</span></h5>
            </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
				<!-- /.row -->
				<div class="row desain">
					<div class="col-lg-3 desain-1">
						<div class="card">
              <div class="card-header header-desain-satu">
                <h5 class="title desain-satu">Desain 1</h5>
              </div>
              <div class="card-body">
                <p class="number-satu">-</p>
							</div>
							<div class="card-footer">
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
							<div class="card-footer">
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
							<div class="card-footer">
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
							<div class="card-footer">
								<p></p>
							</div>
            </div>
					</div>
				</div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

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
