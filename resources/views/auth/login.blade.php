<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset(env('APP_PUBLIC') . 'assets/logo-daun.png') }}" rel="icon" type="image/x-icon">
  <title>{{ config('app.name', 'Abata') }}</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset(env('APP_PUBLIC') . 'themes/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset(env('APP_PUBLIC') . 'themes/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset(env('APP_PUBLIC') . 'themes/dist/css/adminlte.min.css') }}">
  <style>
    .login-page {
      background-image: url('https://bing.biturl.top/?resolution=1920&format=image&index=0&mkt=zh-CN');
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }
    .h2 {
      font-style: normal;
      font-variant-ligatures: normal;
      font-variant-caps: normal;
      font-variant-numeric: normal;
      font-variant-east-asian: normal;
      font-weight: normal;
      font-stretch: normal;
      font-size: 25px;
      font-family: Arial, Helvetica, sans-serif;
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center mt-3">
        <a href="#" class="h2 text-uppercase"><strong>Login</strong></a>
      </div>
      <div class="card-body">
        <form action="{{ route('login') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="E-Mail" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="fas fa-eye fa-eye-slash" id="togglePassword"></i>
              </div>
            </div>
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Ingat saya</label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>

        <div class="social-auth-links text-center mt-4 mb-3">
          <img src="{{ asset(env('APP_PUBLIC') . 'assets/logo-biru.png') }}" alt="logo-abata" style="max-width: 100px;">
          <span class="text-info text-uppercase font-weight-bold">Antrian</span>
        </div>

        <div class="mt-5">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="font-size: 14px;">
              {{ __('Lupa password?') }}
            </a>
          @endif
        </div>
        <hr>
        <div class="text-center mb-2 text-secondary text-danger" style="font-size: 14px;">*kendala aplikasi bisa laporkan ke bagian IT</div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset(env('APP_PUBLIC') . 'themes/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset(env('APP_PUBLIC') . 'themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset(env('APP_PUBLIC') . 'themes/dist/js/adminlte.min.js') }}"></script>

  <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
      // toggle the type attribute
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      // toggle the icon
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
