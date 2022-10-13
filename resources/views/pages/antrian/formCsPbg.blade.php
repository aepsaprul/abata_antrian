<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Abata Form Customer</title>
  <!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('public/themes/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('public/themes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('public/themes/plugins/sweetalert2/sweetalert2.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">

	<style>
		.telepon .telepon-data {
			display: none;
			list-style: none;
			padding: 0;
			text-align: left;
			position: absolute;
			background-color: aliceblue;
		}
		.telepon .telepon-data li {
			padding-right: 10px;
			padding-left: 10px;
			margin-bottom: 10px;
		}

		.btn-data-customer {
			border: none;
			background-color: aliceblue;
		}

		.nomor-antrian {
			width: 800px;
		}
		.nomor-antrian .cv {
			margin-top: 50px;
		}
		.nomor-antrian p {
			text-align: center;
			font-size: 2em;
			font-family: sans-serif;
			text-transform: uppercase;
		}
		.nomor-antrian .nomor {
			font-size: 250px;
			font-weight: bold;
		}

	</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ asset('assets/dist/img/logo-bg-blue.png') }}" alt="">
  </div>
	<div class="social-auth-links text-center mb-3">
		<div class="card">
			<form role="form" action="{{ route('antrian.customer.store') }}" method="POST">
				@csrf
				<div class="card-body">
					<div class="form-group">
						<input type="hidden" class="form-control" id="customer_filter_id" name="customer_filter_id" value="{{ $customer_filter_id }}">
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control" id="nomor_antrian" name="nomor_antrian" value="@if (is_null($nomors)){{ 0 + 1 }}@else{{ $nomors->nomor_antrian + 1 }}@endif">
					</div>
					<div class="form-group">
						<input type="hidden" class="form-control" id="sisa_antrian" name="sisa_antrian" value="{{ $count_nomor_all - $count_nomor_panggil }}">
					</div>
					<div class="form-group">
						<input type="tel" class="form-control" id="telepon" name="telepon" maxlength="13" autocomplete="off" required placeholder="Masukkan nomor telepon">
						<div class="telepon">
							<ul class="telepon-data">
								{{-- data  --}}
							</ul>
						</div>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" id="nama" name="nama_customer" required placeholder="Masukkan nama">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Cetak</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="{{ asset('public/themes/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('public/themes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('public/themes/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/themes/dist/js/adminlte.js') }}"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var btnVal = $('#customer_filter_id').val();

        $("#telepon").on("keyup", function() {
            $('.telepon .telepon-data').empty();
            var value = $(this).val();
            if (value.length >= 10) {
                $.ajax({
                    url: "{{ URL::route('antrian_customer.search') }}",
                    type: 'POST',
                    data: {
                        value: value
                    },
                    success: function(response) {
                        $.each(response.customers, function (i, value) {
                            var data_customers = "<li><button class=\"btn-data-customer\" data-value=\"" + value.telepon + "-" + value.nama_customer + "\">" + value.telepon + " | " + value.nama_customer + "</button></li>";
                            $('.telepon .telepon-data').append(data_customers);
                        });
                        $('.telepon .telepon-data').css('display', 'block');
                    }
                });
            }
        });

        $('.telepon').on('click', '.btn-data-customer', function (e) {
            e.preventDefault();
            var a = $(this).attr('data-value');
            var b = a.split("-");
            $("#telepon").val(b[0]);
            $("#nama").val(b[1]);
            $('.telepon .telepon-data').css('display', 'none');
        });
    });
</script>

</body>
</html>
