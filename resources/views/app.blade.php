<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" type="image/png" href="img/koperasi-icon.png">
    <title>{{env('APP_NAME')}}</title>
    <link href=" {{mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="{{ mix('css/nucleo-icons.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="{{ mix('css/reader/material-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ mix('css/reader/vue-multiselect.css') }}" rel="stylesheet" />
</head>
<body class="g-sidenav-show  bg-gray-200">
    @if (Auth::check())
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedin' => true,
            'user' => Auth::user()
        ])!!}
    </script>
    @else
        <script>
            window.Laravel = {!!json_encode([
                'isLoggedin' => false
            ])!!}
        </script>
    @endif
    <div id="app"></div>
    <script src="{{ mix('js/pooper.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/perfect-scrollbar.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/smooth-scrollbar.js') }}" type="text/javascript"></script>
    <script src="{{ mix('js/chartjs.js') }}" type="text/javascript"></script>

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
<!--<script async defer src="https://buttons.github.io/buttons.js"></script>-->

<script src="{{ mix('js/material-dashboard.js') }}" type="text/javascript"></script>

</body>
</html>
