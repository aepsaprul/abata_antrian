<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('public/assets/logo-daun.png') }}" rel="icon" type="image/x-icon">
    <title>{{ config('app.name', 'Antrian') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/themes/dist/css/adminlte.min.css') }}">

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
        <div class="display-list">

          {{-- atas --}}
          <div class="row cs">
            <div class="col-lg-8">
              <div class="card">
                {{-- <iframe width="100%" height="770px" src="https://www.youtube.com/embed/videoseries?list=PLUmr4_LW9HnOp4yQP-d5K-kZ1rJ0nI7yG&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
              </div>
            </div>
            <div class="col-lg-4 display-list-total" style="height: 770px;"></div>
          </div>

          {{-- bawah --}}
          <div class="display-list-desain"></div>
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
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      tampil();
      function tampil() {
        setTimeout(() => {
          displayList();
          displayListDesain();
          tampil();
        }, 1000);
      }
      
      // displayList();
      function displayList() {
        $.ajax({
          url: "{{ URL::route('antrian_display.list') }}",
          success: function (result) {
            $('.display-list-total').html(result);
          }
        })
      }

      // displayListDesain();
      function displayListDesain() {
        $.ajax({
          url: "{{ URL::route('antrian_display.list.desain') }}",
          success: function (result) {
            $('.display-list-desain').html(result);
          }
        })
      }

      panggilAksi();
      function panggilAksi() {
        setTimeout(() => {
          panggil();
          panggilAksi();
        }, 1000);
      }
      
      // panggil();
      function panggil() {
        $.ajax({
          url: "{{ URL::route('antrian_display.panggil') }}",
          type: "get",
          success: function (response) {
            if (response.panggils.length > 0) {
              $.each(response.panggils, function (index, item) {
                if (item.cabang_id == response.cabang_id) {
                  antrianDesain(item.antrian, item.nomor);
                }
              })
            }
          }
        })
      }

      panggilDeleteAksi();
      function panggilDeleteAksi() {
        setTimeout(() => {
          panggilDelete();  
          panggilDeleteAksi();        
        }, 2000);
      }
      // panggilDelete();
      function panggilDelete() {
        $.ajax({
          url: "{{ URL::route('antrian_display.panggil.delete') }}",
          type: "get"
        })
      }
    })
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
