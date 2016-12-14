<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Base::config('name') }}</title>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <link href="/css/student.css" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="/js/app.js"></script>
    <script src="/js/layer/layer.js"></script>
    <script src="/js/common.js"></script>


</head>
<body>
<div id="app">
    <div class="container">
        @yield('content')</div>
</div>
<script type="application/javascript">
    $(document).ready(function () {
        var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
        $('#main').css('min-height', $(window).height() - neg);
    });

    function url(url) {
        $('#main').attr('src', url);
//        alert($('.content-wrapper').height());
    }
    var header = new Vue({
        el: '.main-header',
        data: {
            url: '{{url('/student/home')}}'
        },
        watch: {},

        methods: {
            url: function (url) {

            },
            logout: function () {
                var _self = this;
                layer.confirm('确认退出吗？', {
                    btn: ['确认', '取消']
                }, function () {
                    _self.$http.post("{{url('/student/logout')}}").then(function (response) {
                        if (response.data.code == 0) {
                            msg('退出成功');
                            window.location.href = "/student/login";
                            return
                        }
                        layer.alert(JSON.stringify(response));
                    });
                }, function () {
                    layer.closeAll();
                });


            },
            //清除换存
            clearCache: function () {
                var _self = this;
                this.$http.post("{{url('/student/clear/cache')}}").then(function (response) {
                    if (response.data.code == 0) {
                        msg('清除换存成功');
                        return
                    }
                    layer.alert(JSON.stringify(response));
                });


            }
        }
    });

    var sidebar = new Vue({
        el: '.main-sidebar',
        data: {menu: {type: ''}},
        watch: {},

        methods: {}
    });

</script>
@yield('script')
</body>
</html>