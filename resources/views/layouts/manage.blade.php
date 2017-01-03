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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/js/AdminLTE/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/js/AdminLTE/css/skins/_all-skins.min.css">
    <link href="/css/common.css" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="/js/app.js"></script>
    <script src="/js/layer/layer.js"></script>
    {{--<!-- AdminLTE App -->--}}
    <script src="/js/AdminLTE/js/app.min.js"></script>
    <script src="/js/common.js"></script>


</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper" id="app">
    <!-- 头部信息 -->
    <header class="main-header">
        <!-- 标志 -->
        <a href="/home" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">EDU</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Teach</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- 左侧菜单切换按键-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- 用户信息 -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/js/AdminLTE/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Auth::guard('manage')->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/js/AdminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::guard('manage')->user()->name}}
                                    <small>{{Auth::guard('manage')->user()->email}}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <a v-on:click="clearCache()">清除缓存</a>
                                    </div>

                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">用户信息</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" v-on:click="logout()">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- 左侧菜单 -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel hide">
                <div class="pull-left image">
                    <img src="/js/AdminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::guard('manage')->user()->name}}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">在线选课系统</li>
                <li class="treeview">
                    <a>
                        <i class="fa fa-dashboard"></i> <span>系统设置</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a onclick="url('{{url('/manage/config')}}')"><i class="fa fa-circle-o"></i>平台参数</a>
                        </li>
                        <li>
                            <a onclick="url('{{url('/manage/user')}}')"><i class="fa fa-circle-o text-yellow"></i>用户管理</a>
                        </li>

                    </ul>
                </li>
                <li class="treeview active" >
                    <a>
                        <i class="fa fa-th"></i> <span>选课管理</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu ">
                        <li >
                            <a onclick="url('{{url('/manage/term')}}')"><i class="fa fa-circle-o"></i>学期信息</a>
                        </li>
                        <li >
                            <a onclick="url('{{url('/manage/agenda')}}')"><i class="fa fa-circle-o text-yellow"></i>课程设置</a>
                        </li>
                        <li class="hide">
                            <a onclick="url('{{url('/manage/teacher')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>教师管理</a>
                        </li>
                        <li >
                            <a onclick="url('{{url('/manage/classes')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>班级管理</a>
                        </li>
                        <li >
                            <a onclick="url('{{url('/manage/student')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>学生档案</a>
                        </li>
                        <li >
                            <a onclick="url('{{url('/manage/syllabus')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>选课记录</a>
                        </li>
                        <li >
                            <a onclick="url('{{url('/manage/syllabus/report')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>课程表</a>
                        </li>
                    </ul>
                </li>


            </ul>
        </section>
    </aside>
    <!-- 内容区-->
    <div class="content-wrapper">
        <iframe id="main" width="100%" min-height="600" frameborder="0" scrolling="auto"
                src="{{url('/manage/home')}}">
            <a href="included.html">你的浏览器不支持iframe页面嵌套，请点击这里访问页面内容。</a>
        </iframe>
    </div>
    <!-- /.内容区 -->
    <!-- 页脚-->
    <footer class="main-footer hide">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>易游通 Copyright &copy; 2016-2019 <a href="http://www.4255.cn">4255.cn</a>.</strong>
        reserved.
    </footer>
    <!-- 边栏 -->
    <div class="control-sidebar-bg"></div>

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
            url: '{{url('/manage/home')}}'
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
                    _self.$http.post("{{url('/manage/logout')}}").then(function (response) {
                        if (response.data.code == 0) {
                            msg('退出成功');
                            window.location.href = "/manage/login";
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
                this.$http.post("{{url('/manage/clear/cache')}}").then(function (response) {
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