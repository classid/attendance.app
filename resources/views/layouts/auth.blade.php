<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <title>{{ $pageTitle }} | {{ config('cid.app.name') }}</title>
  <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon"/>

  <!-- Fonts and icons -->
  <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
  <script>
    WebFont.load({
      google: {"families":["Lato:300,400,700,900"]},
      custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("assets/css/fonts.min.css") }}']},
      active: function() {
        sessionStorage.fonts = true;
      }
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ vendor('bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">
</head>
<body class="login">
  <div class="wrapper wrapper-login">
    @yield('content', '')
  </div>
  <script src="{{ vendor('jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
  <script src="{{ vendor('popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ vendor('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
</body>
</html>
