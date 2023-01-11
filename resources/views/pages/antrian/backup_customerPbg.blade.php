<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Abata Customer</title>
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
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ asset('public/assets/dist/img/logo-bg-blue.png') }}" alt="">
  </div>
	<div class="social-auth-links text-center mb-3">
		<a href="{{ url('antrian/page_customer_pbg/1/form') }}" class="btn-siap btn btn-block btn-primary pt-3 pb-3 pr-5 pl-5" style="font-size: 2em; font-weight: bold;">
			SIAP CETAK
		</a>
		<a href="{{ url('antrian/page_customer_pbg/2/form') }}" class="btn-desain btn btn-block btn-primary pt-3 pb-3 pr-5 pl-5" style="font-size: 2em; font-weight: bold;">
			DESAIN / EDIT
		</a>
		<a href="{{ url('antrian/page_customer_pbg/3/form') }}" class="btn-konsultasi btn btn-block btn-primary pt-3 pb-3 pr-5 pl-5" style="font-size: 2em; font-weight: bold;">
			KONSULTASI CS
		</a>
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
