<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>系统维护后台</title>
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
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper" id="app">
    <!-- 头部信息 -->
    <header class="main-header">
        <!-- 标志 -->
        <a href="/admin" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">Tour</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Travel</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- 左侧菜单切换按键-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- 用户信息 -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">{{Auth::guard('admin')->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/js/AdminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::guard('admin')->user()->name}}
                                    <small>{{Auth::guard('admin')->user()->email}}</small>
                                </p>
                            </li>
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
            <ul class="sidebar-menu">
                <li class="header">系统运营管理平台</li>
                <li class="treeview  " v-bind:class="{active:menu.type=='system'}">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>系统配置</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li v-bind:class="{active:menu.item=='maps'}">
                            <a href="{{url('/admin/system/maps')}}"><i class="fa fa-circle-o"></i>参数定义</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='area'}">
                            <a href="{{url('/admin/system/area')}}"><i class="fa fa-circle-o"></i>区域设置</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='enterprise'}">
                            <a href="{{url('/admin/system/enterprise')}}"><i class="fa fa-circle-o"></i>企业信息</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='permission'}">
                            <a href="{{url('/admin/system/permission')}}"><i
                                        class="fa fa-circle-o text-red"></i>模块权限</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='basedata'}">
                            <a href="{{url('/admin/system/basedata')}}"><i
                                        class="fa fa-circle-o text-yellow"></i>基础数据</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='user'}">
                            <a href="{{url('/admin/system/user')}}"><i class="fa fa-circle-o"></i>系统用户</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>开放平台</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> 海外百事通</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> 渝之旅游</a></li>
                    </ul>
                </li>

            </ul>
        </section>
    </aside>
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- 页脚-->
    <footer class="main-footer hide">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>易游通 Copyright &copy; 2016-2019 <a href="http://www.4255.cn">4255.cn</a>.</strong>
        reserved.
    </footer>
</div>
<script type="application/javascript">
    var header = new Vue({
        el: '.main-header',
        methods: {
            logout: function () {
                var _self = this;
                //加载数据
                $.ajax({
                    type: 'POST',
                    url: "{{url('/admin/logout')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (_obj) {
                        layer.msg("欢迎再次光临！");
                        window.location.href = "/admin/login";
                    }
                });
            }
        }
    });

    var sidebar = new Vue({
        el: '.main-sidebar',
        data: {menu: {type: 'system'}},
        watch: {},

        methods: {}
    });

</script>
@yield('script')
</body>
</html>