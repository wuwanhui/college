<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/js/Awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/js/AdminLTE/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/js/AdminLTE/css/skins/_all-skins.min.css">
    <link href="/css/common.css" rel="stylesheet">

    <script src="/js/app.js"></script>
    <script src="/js/layer/layer.js"></script>
    <!-- AdminLTE App -->
    <script src="/js/AdminLTE/js/app.min.js"></script>
    <script src="/js/common.js"></script>
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div id="app">
    @yield('content')
    @yield('script')
</div>
</body>
</html>
