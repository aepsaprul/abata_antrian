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
  <audio src="{{ asset('public/assets/ringtone/nomor-antrian.wav') }}" id="nomor_antrian" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/c.mp3') }}" id="c" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/d.mp3') }}" id="d" controls style="display: none;"></audio>

  {{-- nomor antrian --}}
  <audio src="{{ asset('public/assets/ringtone/1.mp3') }}" id="angka-1" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/2.mp3') }}" id="angka-2" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/3.mp3') }}" id="angka-3" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/4.mp3') }}" id="angka-4" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/5.mp3') }}" id="angka-5" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/6.mp3') }}" id="angka-6" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/7.mp3') }}" id="angka-7" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/8.mp3') }}" id="angka-8" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/9.mp3') }}" id="angka-9" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/10.mp3') }}" id="angka-10" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/11.mp3') }}" id="angka-11" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/12.mp3') }}" id="angka-12" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/13.mp3') }}" id="angka-13" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/14.mp3') }}" id="angka-14" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/15.mp3') }}" id="angka-15" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/16.mp3') }}" id="angka-16" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/17.mp3') }}" id="angka-17" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/18.mp3') }}" id="angka-18" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/19.mp3') }}" id="angka-19" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/20.mp3') }}" id="angka-20" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/21.wav') }}" id="angka-21" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/22.wav') }}" id="angka-22" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/23.wav') }}" id="angka-23" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/24.wav') }}" id="angka-24" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/25.wav') }}" id="angka-25" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/26.wav') }}" id="angka-26" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/27.wav') }}" id="angka-27" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/28.wav') }}" id="angka-28" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/29.wav') }}" id="angka-29" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/30.mp3') }}" id="angka-30" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/31.wav') }}" id="angka-31" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/32.wav') }}" id="angka-32" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/33.wav') }}" id="angka-33" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/34.wav') }}" id="angka-34" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/35.wav') }}" id="angka-35" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/36.wav') }}" id="angka-36" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/37.wav') }}" id="angka-37" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/38.wav') }}" id="angka-38" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/39.wav') }}" id="angka-39" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/40.mp3') }}" id="angka-40" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/41.wav') }}" id="angka-41" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/42.wav') }}" id="angka-42" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/43.wav') }}" id="angka-43" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/44.wav') }}" id="angka-44" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/45.wav') }}" id="angka-45" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/46.wav') }}" id="angka-46" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/47.wav') }}" id="angka-47" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/48.wav') }}" id="angka-48" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/49.wav') }}" id="angka-49" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/50.mp3') }}" id="angka-50" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/51.wav') }}" id="angka-51" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/52.wav') }}" id="angka-52" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/53.wav') }}" id="angka-53" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/54.wav') }}" id="angka-54" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/55.wav') }}" id="angka-55" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/56.wav') }}" id="angka-56" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/57.wav') }}" id="angka-57" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/58.wav') }}" id="angka-58" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/59.wav') }}" id="angka-59" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/60.mp3') }}" id="angka-60" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/61.wav') }}" id="angka-61" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/62.wav') }}" id="angka-62" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/63.wav') }}" id="angka-63" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/64.wav') }}" id="angka-64" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/65.wav') }}" id="angka-65" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/66.wav') }}" id="angka-66" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/67.wav') }}" id="angka-67" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/68.wav') }}" id="angka-68" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/69.wav') }}" id="angka-69" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/70.mp3') }}" id="angka-70" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/71.wav') }}" id="angka-71" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/72.wav') }}" id="angka-72" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/73.wav') }}" id="angka-73" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/74.wav') }}" id="angka-74" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/75.wav') }}" id="angka-75" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/76.wav') }}" id="angka-76" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/77.wav') }}" id="angka-77" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/78.wav') }}" id="angka-78" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/79.wav') }}" id="angka-70" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/80.mp3') }}" id="angka-80" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/81.wav') }}" id="angka-81" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/82.wav') }}" id="angka-82" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/83.wav') }}" id="angka-83" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/84.wav') }}" id="angka-84" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/85.wav') }}" id="angka-85" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/86.wav') }}" id="angka-86" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/87.wav') }}" id="angka-87" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/88.wav') }}" id="angka-88" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/89.wav') }}" id="angka-89" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/90.mp3') }}" id="angka-90" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/91.wav') }}" id="angka-91" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/92.wav') }}" id="angka-92" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/93.wav') }}" id="angka-93" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/94.wav') }}" id="angka-94" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/95.wav') }}" id="angka-95" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/96.wav') }}" id="angka-96" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/97.wav') }}" id="angka-97" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/98.wav') }}" id="angka-98" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/99.wav') }}" id="angka-99" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/100.mp3') }}" id="angka-100" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/101.wav') }}" id="angka-101" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/102.wav') }}" id="angka-102" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/103.wav') }}" id="angka-103" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/104.wav') }}" id="angka-104" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/105.wav') }}" id="angka-105" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/106.wav') }}" id="angka-106" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/107.wav') }}" id="angka-107" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/108.wav') }}" id="angka-108" controls style="display: none;"></audio>

  {{-- @for ($i = 1; $i < 20; $i++)
      <audio src="{{ asset('public/assets/ringtone/'.$i.'.mp3') }}" id="angka-@php echo $i @endphp" controls style="display: none;"></audio>
  @endfor

  @for ($j = 20; $j < 100; $j+=10)
      <audio src="{{ asset('public/assets/ringtone/'.$j.'.mp3') }}" id="angka-@php echo $j @endphp" controls style="display: none;"></audio>
  @endfor

  @for ($k = 100; $k <= 500; $k+=100)
      <audio src="{{ asset('public/assets/ringtone/'.$k.'.mp3') }}" id="angka-@php echo $k @endphp" controls style="display: none;"></audio>
  @endfor --}}

  <audio src="{{ asset('public/assets/ringtone/ke-cs.wav') }}" id="kecs" controls style="display: none;"></audio>
  <audio src="{{ asset('public/assets/ringtone/ke-desain.wav') }}" id="kedesign" controls style="display: none;"></audio>

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
                  if (item.cabang_id == 5) {
                    antrianDesainPbg(item.antrian, item.nomor); 
                  } else {
                    antrianDesain(item.antrian, item.nomor);                    
                  }
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

    function antrianDesain(angka, desain) {
      setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
      setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
      setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 4300);
      setTimeout(function(){ document.getElementById("kedesign").play(); }, 5000);
      setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 6100);
    }

    function antrianDesainPbg(angka, desain) {
      setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
      setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
      setTimeout(function(){ document.getElementById("d").play(); }, 4500);
      setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 5000);
      setTimeout(function(){ document.getElementById("kedesign").play(); }, 6000);
      setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 7000);
    }

    function antrianCsToDesainPbg(angka, desain) {
      setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
      setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
      setTimeout(function(){ document.getElementById("c").play(); }, 5000);
      setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
      setTimeout(function(){ document.getElementById("kedesign").play(); }, 8000);
      setTimeout(function(){ document.getElementById("angka-" + desain).play(); }, 10000);
    }

    function antrianCs(angka) {
      setTimeout(function(){ document.getElementById("notif").play(); }, 1000);
      setTimeout(function(){ document.getElementById("nomor_antrian").play(); }, 3000);
      setTimeout(function(){ document.getElementById("c").play(); }, 5000);
      setTimeout(function(){ document.getElementById("angka-" + angka).play(); }, 6000);
      setTimeout(function(){ document.getElementById("kecs").play(); }, 8000);
    }
  </script>
</body>
</html>
