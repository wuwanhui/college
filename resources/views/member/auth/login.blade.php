<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>会员-{{ config('app.name', 'Laravel') }}</title>

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
<body class="hold-transition login-page">
<div id="app">
    <div class="login-box">
        <div class="login-logo">
            <a><b>Travel</b>-v1.0</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg h4"><i class="icon-desktop"></i> 智慧旅游-管理平台</p>
            <form role="form" method="POST" action="{{ url('/member/login') }}">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input id="email" name="email" type="email" class="form-control" placeholder="邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="password" name="password" type="password" class="form-control" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="checkbox ">
                            <label>
                                <input type="checkbox"> 记住我
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-6 text-right">
                        <button type="submit" class="btn btn-primary  ">登录</button>
                    </div>
                </div>
            </form>
            <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#">忘记密码</a>
                <a href="/member/register"> 注册</a>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $("#email").focus();
</script>
</body>
</html>