<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset(env('APP_PUBLIC') . 'assets/logo-daun.png') }}" rel="icon" type="image/x-icon">
    <title>{{ config('app.name', 'Antrian') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset(env('APP_PUBLIC') . 'themes/dist/css/adminlte.min.css') }}">

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
  
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>
    let user = {!! Auth::user()->karyawan !!};

    var pusher = new Pusher('706037a308be51409f57', {
      cluster: 'ap1'
    });

    // desain panggil
    var desain_panggil = pusher.subscribe('desain-panggil');
    desain_panggil.bind('desain-panggil-event', function(data) {
      if (user.master_cabang_id == data.cabang_id) {          
        if (data.cabang_id == 5) {
          antrianDesainPbg(data.antrian_nomor, data.desain_nomor);
        } else {
          antrianDesain(data.antrian_nomor, data.desain_nomor);
        }
      }
    });

    // cs to desain
    var cs_panggil = pusher.subscribe('cs-to-desain-panggil');
    cs_panggil.bind('cs-to-desain-panggil-event', function(data) {
      if (user.master_cabang_id == data.cabang_id) {
        antrianCsToDesainPbg(data.antrian_nomor, data.desain_nomor);
      }
    });

    // cs panggil
    var cs_panggil = pusher.subscribe('cs-panggil');
    cs_panggil.bind('cs-panggil-event', function(data) {
      if (user.master_cabang_id == data.cabang_id) {
        antrianCs(data.antrian_nomor);
      }
    });
  </script>
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
              <div class="card display-media" style="background-color: white;">
                <div id="media_dasar" style="width: 100%; height: 770px; display:flex; justify-content: center; align-items: center;">
                  <img src="{{ asset(env('APP_PUBLIC') . 'assets/logo-biru.png') }}" alt="logo" style="width: 40%;">
                </div>
                <!-- dzikir pagi -->
                <div id="dzikir_pagi" class="d-none">
                  <video width="100%" height="770px" id="video_dzikir_pagi" controls>
                    <source src="{{ asset(env('APP_PUBLIC') . 'assets/dzikir-pagi.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>                  
                </div>
                <!-- dzikir petang -->
                <div id="dzikir_petang" class="d-none">
                  <video width="100%" height="770px" id="video_dzikir_petang" controls>
                    <source src="{{ asset(env('APP_PUBLIC') . 'assets/dzikir-petang.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>                  
                </div>
                <!-- adzan ---> 
                <div id="adzan" class="d-none">
                  <video width="100%" height="770px" id="video_adzan" controls>
                    <source src="{{ asset(env('APP_PUBLIC') . 'assets/adzan2.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>                  
                </div>
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

  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/suara_antrian.mp3') }}" id="notif"  allow="autoplay" style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/nomor-antrian.wav') }}" id="nomor_antrian" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/c.mp3') }}" id="c" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/d.mp3') }}" id="d" controls style="display: none;"></audio>

  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/1.mp3') }}" id="angka-desain-1" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/2.mp3') }}" id="angka-desain-2" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/3.mp3') }}" id="angka-desain-3" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/4.mp3') }}" id="angka-desain-4" controls style="display: none;"></audio>

  {{-- nomor antrian --}}
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/1.mp3') }}" id="angka-1" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/2.mp3') }}" id="angka-2" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/3.mp3') }}" id="angka-3" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/4.mp3') }}" id="angka-4" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/5.mp3') }}" id="angka-5" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/6.mp3') }}" id="angka-6" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/7.mp3') }}" id="angka-7" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/8.mp3') }}" id="angka-8" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/9.mp3') }}" id="angka-9" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/10.mp3') }}" id="angka-10" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/11.mp3') }}" id="angka-11" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/12.mp3') }}" id="angka-12" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/13.mp3') }}" id="angka-13" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/14.mp3') }}" id="angka-14" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/15.mp3') }}" id="angka-15" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/16.mp3') }}" id="angka-16" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/17.mp3') }}" id="angka-17" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/18.mp3') }}" id="angka-18" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/19.mp3') }}" id="angka-19" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/20.mp3') }}" id="angka-20" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/21.wav') }}" id="angka-21" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/22.wav') }}" id="angka-22" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/23.wav') }}" id="angka-23" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/24.wav') }}" id="angka-24" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/25.wav') }}" id="angka-25" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/26.wav') }}" id="angka-26" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/27.wav') }}" id="angka-27" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/28.wav') }}" id="angka-28" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/29.wav') }}" id="angka-29" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/30.mp3') }}" id="angka-30" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/31.wav') }}" id="angka-31" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/32.wav') }}" id="angka-32" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/33.wav') }}" id="angka-33" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/34.wav') }}" id="angka-34" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/35.wav') }}" id="angka-35" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/36.wav') }}" id="angka-36" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/37.wav') }}" id="angka-37" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/38.wav') }}" id="angka-38" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/39.wav') }}" id="angka-39" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/40.mp3') }}" id="angka-40" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/41.wav') }}" id="angka-41" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/42.wav') }}" id="angka-42" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/43.wav') }}" id="angka-43" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/44.wav') }}" id="angka-44" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/45.wav') }}" id="angka-45" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/46.wav') }}" id="angka-46" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/47.wav') }}" id="angka-47" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/48.wav') }}" id="angka-48" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/49.wav') }}" id="angka-49" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/50.mp3') }}" id="angka-50" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/51.wav') }}" id="angka-51" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/52.wav') }}" id="angka-52" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/53.wav') }}" id="angka-53" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/54.wav') }}" id="angka-54" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/55.wav') }}" id="angka-55" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/56.wav') }}" id="angka-56" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/57.wav') }}" id="angka-57" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/58.wav') }}" id="angka-58" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/59.wav') }}" id="angka-59" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/60.mp3') }}" id="angka-60" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/61.wav') }}" id="angka-61" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/62.wav') }}" id="angka-62" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/63.wav') }}" id="angka-63" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/64.wav') }}" id="angka-64" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/65.wav') }}" id="angka-65" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/66.wav') }}" id="angka-66" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/67.wav') }}" id="angka-67" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/68.wav') }}" id="angka-68" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/69.wav') }}" id="angka-69" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/70.mp3') }}" id="angka-70" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/71.wav') }}" id="angka-71" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/72.wav') }}" id="angka-72" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/73.wav') }}" id="angka-73" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/74.wav') }}" id="angka-74" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/75.wav') }}" id="angka-75" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/76.wav') }}" id="angka-76" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/77.wav') }}" id="angka-77" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/78.wav') }}" id="angka-78" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/79.wav') }}" id="angka-70" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/80.mp3') }}" id="angka-80" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/81.wav') }}" id="angka-81" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/82.wav') }}" id="angka-82" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/83.wav') }}" id="angka-83" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/84.wav') }}" id="angka-84" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/85.wav') }}" id="angka-85" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/86.wav') }}" id="angka-86" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/87.wav') }}" id="angka-87" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/88.wav') }}" id="angka-88" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/89.wav') }}" id="angka-89" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/90.mp3') }}" id="angka-90" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/91.wav') }}" id="angka-91" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/92.wav') }}" id="angka-92" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/93.wav') }}" id="angka-93" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/94.wav') }}" id="angka-94" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/95.wav') }}" id="angka-95" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/96.wav') }}" id="angka-96" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/97.wav') }}" id="angka-97" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/98.wav') }}" id="angka-98" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/99.wav') }}" id="angka-99" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/100.mp3') }}" id="angka-100" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/101.wav') }}" id="angka-101" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/102.wav') }}" id="angka-102" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/103.wav') }}" id="angka-103" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/104.wav') }}" id="angka-104" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/105.wav') }}" id="angka-105" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/106.wav') }}" id="angka-106" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/107.wav') }}" id="angka-107" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/108.wav') }}" id="angka-108" controls style="display: none;"></audio>

  {{-- @for ($i = 1; $i < 20; $i++)
      <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/'.$i.'.mp3') }}" id="angka-@php echo $i @endphp" controls style="display: none;"></audio>
  @endfor

  @for ($j = 20; $j < 100; $j+=10)
      <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/'.$j.'.mp3') }}" id="angka-@php echo $j @endphp" controls style="display: none;"></audio>
  @endfor

  @for ($k = 100; $k <= 500; $k+=100)
      <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/'.$k.'.mp3') }}" id="angka-@php echo $k @endphp" controls style="display: none;"></audio>
  @endfor --}}

  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/ke-cs.wav') }}" id="kecs" controls style="display: none;"></audio>
  <audio src="{{ asset(env('APP_PUBLIC') . 'assets/ringtone/ke-desain.wav') }}" id="kedesign" controls style="display: none;"></audio>

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="{{ asset(env('APP_PUBLIC') . 'themes/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset(env('APP_PUBLIC') . 'themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset(env('APP_PUBLIC') . 'themes/dist/js/adminlte.min.js') }}"></script>

  <script>
    const notif = "{{ URL::asset(env('APP_PUBLIC') . 'assets/ringtone/suara_antrian.mp3') }}";
    const nomor_antrian = "{{ URL::asset(env('APP_PUBLIC') . 'assets/ringtone/nomor-antrian.wav') }}";
    const c = "{{ URL::asset(env('APP_PUBLIC') . 'assets/ringtone/c.mp3') }}";
    const d = "{{ URL::asset(env('APP_PUBLIC') . 'assets/ringtone/d.mp3') }}";
    const kecs = "{{ URL::asset(env('APP_PUBLIC') . 'assets/ringtone/ke-cs.wav') }}";
    const kedesain = "{{ URL::asset(env('APP_PUBLIC') . 'assets/ringtone/kedesign.mp3') }}";

    function antrianDesain(angka, desain) {
      const audio_notif = new Audio(notif);
      const audio_nomor = new Audio(nomor_antrian);
      const audio_kedesain = new Audio(kedesain);

      const audio_file = document.getElementById("angka-" + angka);
      const audio_desain = document.getElementById("angka-desain-" + desain);

      audio_notif.play();
      audio_notif.addEventListener("ended", () => {
        audio_nomor.play();
      })
      audio_nomor.addEventListener("ended", () => {
        audio_file.play();
      })
      audio_file.addEventListener("ended", () => {
        audio_kedesain.play();
      })
      audio_kedesain.addEventListener("ended", () => {
        audio_desain.play();
      })
    }
    
    function antrianDesainPbg(angka, desain) {
      const audio_notif = new Audio(notif);
      const audio_nomor = new Audio(nomor_antrian);
      const audio_d = new Audio(d);
      const audio_kedesain = new Audio(kedesain);

      const audio_file = document.getElementById("angka-" + angka);
      const audio_desain = document.getElementById("angka-desain-" + desain);

      audio_notif.play();
      audio_notif.addEventListener("ended", () => {
        audio_nomor.play();
      })
      audio_nomor.addEventListener("ended", () => {
        audio_d.play();
      })
      audio_d.addEventListener("ended", () => {
        audio_file.play();
      })
      audio_file.addEventListener("ended", () => {
        audio_kedesain.play();
      })
      audio_kedesain.addEventListener("ended", () => {
        audio_desain.play();
      })
    }

    function antrianCsToDesainPbg(angka, desain) {
      const audio_notif = new Audio(notif);
      const audio_nomor = new Audio(nomor_antrian);
      const audio_c = new Audio(c);
      const audio_kedesain = new Audio(kedesain);
      
      const audio_file = document.getElementById("angka-" + angka);
      const audio_desain = document.getElementById("angka-desain-" + desain);

      audio_notif.play();
      audio_notif.addEventListener("ended", () => {
        audio_nomor.play();
      })
      audio_nomor.addEventListener("ended", () => {
        audio_c.play();
      })
      audio_c.addEventListener("ended", () => {
        audio_file.play();
      })
      audio_file.addEventListener("ended", () => {
        audio_kedesain.play();
      })
      audio_kedesain.addEventListener("ended", () => {
        audio_desain.play();
      })
    }
    
    function antrianCs(angka) {
      const audio_notif = new Audio(notif);
      const audio_nomor = new Audio(nomor_antrian);
      const audio_c = new Audio(c);
      const audio_kecs = new Audio(kecs);

      const audio_file = document.getElementById("angka-" + angka);

      audio_notif.play();
      audio_notif.addEventListener("ended", () => {
        audio_nomor.play();
      })
      audio_nomor.addEventListener("ended", () => {
        audio_c.play();
      })
      audio_c.addEventListener("ended", () => {
        audio_file.play();
      })
      audio_file.addEventListener("ended", () => {
        audio_kecs.play();
      })
    }
  </script>

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
      
      displayList();
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

      const waktuDzikirPagi = '8:40';
      const wakutDzikirPetang = '15:45';
      const wakutDzuhur = '11:56';
      const waktuAshar = '15:12';
      const waktuMaghrib = '17:58';
      const waktuIsya = '19:5';

      runMediaPlay();
      function runMediaPlay() {
        setTimeout(() => {
          const date = new Date;
          const minutes = date.getMinutes();
          const hour = date.getHours();
          const waktuSekarang = `${hour}:${minutes}`;

          if (waktuSekarang === waktuDzikirPagi) {
            $('#dzikir_pagi').removeClass('d-none');
            // $('#video_dzikir_pagi').autoplay = true;
            // $('#video_dzikir_pagi').load();
            document.getElementById("video_dzikir_pagi").autoplay = true;
            document.getElementById("video_dzikir_pagi").load();
            $('#media_dasar').addClass('d-none');
            
            document.getElementById('video_dzikir_pagi').addEventListener("ended", () => {
              $('#dzikir_pagi').addClass('d-none');
              // $('#video_dzikir_pagi').prop('autoplay', false);
              $('#media_dasar').removeClass('d-none');
              runMediaPlay();
            })
          } else if (waktuSekarang === wakutDzikirPetang) {
            $('#dzikir_petang').removeClass('d-none');
            // $('#video_dzikir_petang').prop('autoplay', true);
            document.getElementById("video_dzikir_petang").autoplay = true;
            document.getElementById("video_dzikir_petang").load();
            $('#media_dasar').addClass('d-none');

            document.getElementById('video_dzikir_petang').addEventListener("ended", () => {
              $('#dzikir_petang').addClass('d-none');
              // $('#video_dzikir_petang').prop('autoplay', false);
              $('#media_dasar').removeClass('d-none');
              runMediaPlay();
            })
          } else if (waktuSekarang === wakutDzuhur || waktuSekarang === waktuAshar || waktuSekarang === waktuMaghrib || waktuSekarang === waktuIsya) {
            $('#adzan').removeClass('d-none');
            // $('#video_adzan').prop('autoplay', true);
            document.getElementById("video_adzan").autoplay = true;
            document.getElementById("video_adzan").load();
            $('#media_dasar').addClass('d-none');
            
            document.getElementById('video_adzan').addEventListener("ended", () => {
              $('#adzan').addClass('d-none');
              // $('#video_adzan').prop('autoplay', false);
              $('#media_dasar').removeClass('d-none');
              runMediaPlay();
            })
          } else {
            runMediaPlay();
          }
        }, 1000);
      }

      // function mediaPlay() {
      //   const waktuSekarang = `${hour}:${minutes}`;
      //   let val = ``;
      //   if (waktuSekarang === waktuDzikirPagi) {
      //     val += `
      //       <div>
      //         <video width="100%" height="770px" autoplay controls>
      //           <source src="{{ asset(env('APP_PUBLIC') . 'assets/dzikir-pagi.mp4') }}" type="video/mp4">
      //           Your browser does not support the video tag.
      //         </video>                  
      //       </div>
      //     `;
      //   } else if (waktuSekarang === wakutDzikirPetang) {
      //     val += `
      //       <div>
      //         <video width="100%" height="770px" autoplay controls>
      //           <source src="{{ asset(env('APP_PUBLIC') . 'assets/dzikir-petang.mp4') }}" type="video/mp4">
      //           Your browser does not support the video tag.
      //         </video>                  
      //       </div>
      //     `;
      //     console.log(wakutDzikirPetang);
      //   } else if (waktuSekarang === wakutDzuhur || waktuSekarang === waktuAshar || waktuSekarang === waktuMaghrib || waktuSekarang === waktuIsya) {
      //     val += `
      //       <div>
      //         <video width="100%" height="770px" autoplay controls>
      //           <source src="{{ asset(env('APP_PUBLIC') . 'assets/adzan.mp4') }}" type="video/mp4">
      //           Your browser does not support the video tag.
      //         </video>                  
      //       </div>
      //     `;
      //   } else {
      //     val += `
      //       <div>
      //         <iframe width="100%" height="770px" src="https://www.youtube.com/embed/videoseries?list=PLUmr4_LW9HnOp4yQP-d5K-kZ1rJ0nI7yG&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      //       </div>
      //     `;
      //   }

      //   $('.display-media').html(val);
      // }
    })
  </script>
</body>
</html>
