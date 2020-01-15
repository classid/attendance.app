<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <meta name="authorizeToken" content="{{ $authUser->api_token }}">
  <title>{{ $pageTitle }} | {{ config('cid.app.name') }}</title>
  <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon"/>

  <!-- Fonts and icons -->
  <script src="{{ vendor('webfont/webfont.min.js') }}"></script>
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
  <link rel="stylesheet" href="{{ vendor('bootstrap-table/dist/bootstrap-table.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  @stack('css')
</head>
<body>
  <div class="wrapper">
    <div class="main-header">
      @includeIf('layouts.app-header')
    </div>
    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2">
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        @includeIf('layouts.app-sidebar')
      </div>
    </div>
    <div class="main-panel">
      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title">{{ $pageTitle }}</h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="{{ route('home') }}"><i class="flaticon-home"></i></a>
              </li>
              @forelse($breadCrumbs as $crumb)
                <li class="separator">/</li>
                <li class="nav-item">
                  @if(is_array($crumb))
                    <a href="{{ $crumb['href'] ?: 'javascript:void(0);' }}">{{ $crumb['title'] }}</a>
                  @else
                    <a href="javascript:void(0);">{{ $crumb }}</a>
                  @endif
                </li>
              @empty
              @endforelse
            </ul>
          </div>
          <div id="mainContent">
            @yield('content', '')
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="pull-left">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="https://mumtaz.app">
                  Mumtaz
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  Help
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  Licenses
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright ml-auto">
            {{ date("Y") }}, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://mumtaz.app">Mumtaz App</a>
          </div>
        </div>
      </footer>
    </div>
{{--    @includeIf('layouts.app-quick-sidebar')--}}
  </div>
  <script src="{{ vendor('jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ vendor('jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
  <script src="{{ vendor('popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ vendor('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ vendor('jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
  <script src="{{ vendor('jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
  <script src="{{ vendor('jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ vendor('bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
  <script src="{{ vendor('bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
  <script src="{{ vendor('bootstrap-table/dist/locale/bootstrap-table-id-ID.min.js') }}"></script>
  <script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
  <script>
    $(document).ready(function () {
      $('.btn-quick-href').on('click', function() {
        _method = $(this).data('method') ? $(this).data('method').toLowerCase() : 'get';
        _href = $(this).data('href') ? $(this).data('href') : '#';
        _confirm = true;
        console.log(_method);

        if (_method == 'get') {
          document.location.href = _href;
        }
        else {
          if (_method == 'delete') {
            _confirm = confirm('Apakah yakin ingin menghapus ?');
          }

          if (_confirm) {
            $.post(_href, {
              '_token': '{{ csrf_token() }}',
              '_method': _method.toUpperCase(),
            }, function (_resp) {
              if (_resp.redirect) location.href = _resp.redirect;
            });
          }
        }
      });
    });
  </script>
  @stack('js')
</body>
</html>
