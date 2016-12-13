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
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- 右侧信息显示框-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">内部信息</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="/js/AdminLTE/img/user2-160x160.jpg" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="/js/AdminLTE/img/user3-128x128.jpg" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                AdminLTE Design Team
                                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="/js/AdminLTE/img/user4-128x128.jpg" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                Developers
                                                <small><i class="fa fa-clock-o"></i> Today</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="/js/AdminLTE/img/user3-128x128.jpg" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                Sales Department
                                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="/js/AdminLTE/img/user4-128x128.jpg" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <h4>
                                                Reviewers
                                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">全部已阅</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">公告通知</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> Very long description here that
                                            may not fit into the
                                            page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">查看全部</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">任务提醒</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Create a nice theme
                                                <small class="pull-right">40%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-green" style="width: 40%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Some task I need to do
                                                <small class="pull-right">60%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-red" style="width: 60%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Make beautiful transitions
                                                <small class="pull-right">80%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-yellow" style="width: 80%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
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
                                    <div class="col-xs-4 text-center">
                                        <a v-on:click="clearCache()">清除缓存</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
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
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
                <li class="header">业务操作角色</li>
                <li class="treeview" v-bind:class="{active:menu.type=='business'}">
                    <a>
                        <i class="fa fa-dashboard"></i> <span>业务操作</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li v-bind:class="{active:menu.item=='sanping'}">
                            <a onclick="url('{{url('/manage/business/group/createsan')}}')"><i class="fa fa-circle-o"></i>发布散拼</a>
                        </li>
                        <li>
                            <a onclick="url('{{url('/manage/resources/lineclass')}}')"><i class="fa fa-circle-o text-yellow"></i>发布包团</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='tourline'}">
                            <a onclick="url('{{url('/manage/business/group/tourline')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>团期线路</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='group'}">
                            <a onclick="url('{{url('/manage/business/group')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>团期列表</a>
                        </li>
                        <li>
                            <a onclick="url('{{url('/manage/business/order')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>订单列表</a>
                        </li>
                        <li>
                            <a onclick="url('{{url('/manage/business/cost')}}')"><i class="fa fa-circle-o"></i>成本管理</a>
                        </li>
                    </ul>
                </li>
                <li class="treeview" v-bind:class="{active:menu.type=='crm'}">
                    <a>
                        <i class="fa fa-th"></i> <span>客户关系</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li v-bind:class="{active:menu.item=='customer'}">
                            <a onclick="url('{{url('/manage/crm/customer')}}')"><i class="fa fa-circle-o"></i>客户档案</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='customerLinkman'}">
                            <a onclick="url('{{url('/manage/crm/customer/linkman')}}')"><i class="fa fa-circle-o text-yellow"></i>联系人</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='customerFollow'}">
                            <a onclick="url('{{url('/manage/crm/customer/follow')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>联系记录</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='customerIntegral'}">
                            <a onclick="url('{{url('/manage/crm/customer/integral')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>积分管理</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='customerTask'}">
                            <a onclick="url('{{url('/manage/crm/customer/task')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>任务管理</a>
                        </li>

                    </ul>
                </li>
                <li class="treeview" v-bind:class="{active:menu.type=='weixin'}">
                    <a>
                        <i class="fa fa-th"></i> <span>微信营销</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li v-bind:class="{active:menu.item=='user'}">
                            <a href="##"><i class="fa fa-bars text-blue"></i>微信关注<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span></a>
                            <ul class="treeview-menu">
                                <li v-bind:class="{active:menu.item=='user'}">
                                    <a onclick="url('{{url('/manage/weixin/user')}}')"><i class="fa fa-circle-o"></i>关注者</a>
                                </li>
                                <li v-bind:class="{active:menu.item=='tags'}">
                                    <a onclick="url('{{url('/manage/weixin/user/tags')}}')"><i class="fa fa-circle-o"></i>用户标签</a>
                                </li>
                            </ul>
                        </li>
                        <li v-bind:class="{active:menu.item=='qrcode'}">
                            <a onclick="url('{{url('/manage/weixin/qrcode')}}')"><i class="fa fa-circle-o"></i>二维码</a>
                        </li>

                    </ul>
                </li>
                <li class="treeview" v-bind:class="{active:menu.type=='resources'}">
                    <a href="#">
                        <i class="fa fa-ioxhost"></i>
                        <span>资源管理</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li v-bind:class="{active:menu.item=='supplier'}">
                            <a onclick="url('{{url('/manage/resources/supplier')}}')"><i class="fa fa-circle-o"></i>供应商</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='lineclass'}">
                            <a onclick="url('{{url('/manage/resources/lineclass')}}')"><i class="fa fa-circle-o text-yellow"></i>线路类别</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='line'}">
                            <a onclick="url('{{url('/manage/resources/line')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>线路行程</a>
                        </li>
                        <li>
                            <a href="##"><i class="fa fa-bars text-blue"></i>常用信息<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span></a>
                            <ul class="treeview-menu">
                                <li v-bind:class="{active:menu.item=='gatherplace'}">
                                    <a onclick="url('{{url('/manage/resources/gatherplace')}}')"><i class="fa fa-circle-o"></i>常用集合地</a>
                                </li>
                                <li>
                                    <a onclick="url('{{url('/manage/resources/bigtraffic')}}')"><i class="fa fa-circle-o"></i>常用大交通</a>
                                </li>
                                <li>
                                    <a onclick="url('{{url('/manage/resources/hotel')}}')"><i class="fa fa-circle-o"></i>常用酒店</a>
                                </li>
                                <li>
                                    <a onclick="url('{{url('/manage/resources/scenicspot')}}')"><i class="fa fa-circle-o"></i>常用景点</a>
                                </li>
                                <li>
                                    <a onclick="url('{{url('/manage/resources/recommend')}}')"><i class="fa fa-circle-o"></i>团期推荐</a>
                                </li>
                                <li>
                                    <a onclick="url('{{url('/manage/resources/letterhead')}}')"><i class="fa fa-circle-o"></i>公司抬头</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a onclick="url('{{url('/manage/resources/guide')}}')"><i class="fa fa-circle-o"></i>领队/导游</a>
                        </li>
                        <li>
                            <a onclick="url('{{url('/manage/resources/blacklist')}}')"><i class="fa fa-circle-o"></i>游客黑名单</a>
                        </li>
                    </ul>


                </li>
                <li class="treeview" v-bind:class="{active:menu.type=='finance'}">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span>财务中心</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a onclick="url('{{url('/manage/finance/bank') }}')">银行账号</a></li>
                        <li><a onclick="url('{{url('/manage/business') }}')">业务操作</a></li>
                        <li><a onclick="url('{{url('/manage/customer') }}')">客户中心</a></li>
                        <li><a onclick="url('{{url('/manage/resources') }}')">资源管理</a></li>
                        <li><a onclick="url('{{url('/manage/finance') }}')">财务中心</a></li>
                        <li><a onclick="url('{{url('/manage/system') }}')">系统配置</a></li>
                        <li class="active"><a onclick="url('{{url('/manage/open') }}')">开放平台</a></li>
                    </ul>
                </li>
                <li class="treeview  " v-bind:class="{active:menu.type=='system'}">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>系统配置</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>

                    <ul class="treeview-menu">
                        @if(Base::user()->can('system_config'))
                            <li v-bind:class="{active:menu.item=='config'}">
                                <a onclick="url('{{url('/manage/system/config')}}')"><i class="fa fa-cogs"></i>系统参数</a>
                            </li>
                        @endif
                        <li v-bind:class="{active:menu.item=='area'}">
                            <a onclick="url('{{url('/manage/system/area')}}')"><i class="fa fa-cogs"></i>区域设置</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='enterprise'}">
                            <a onclick="url('{{url('/manage/system/enterprise')}}')"><i class="fa fa-circle-o"></i>企业信息</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='dept'}">
                            <a onclick="url('{{url('/manage/system/dept')}}')"><i class="fa fa-circle-o"></i>部门机构</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='user'}">
                            <a onclick="url('{{url('/manage/system/user')}}')"><i class="fa fa-circle-o"></i>用户管理</a>
                        </li>

                        <li v-bind:class="{active:menu.item=='permission'}')">
                            <a onclick="url('{{url('/manage/system/permission')}}')"><i
                                        class="fa fa-circle-o text-red"></i>模块权限</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='role'}">
                            <a onclick="url('{{url('/manage/system/role')}}')"><i class="fa fa-circle-o text-red"></i>角色管理</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='authorization'}')">
                            <a onclick="url('{{url('/manage/system/authorization')}}')"><i
                                        class="fa fa-circle-o text-red"></i>用户授权</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='attachment'}')">
                            <a onclick="url('{{url('/manage/system/attachment')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>附件资源</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='basedata'}')">
                            <a onclick="url('{{url('/manage/system/basedata')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>基础数据</a>
                        </li>
                        <li v-bind:class="{active:menu.item=='notices'}')">
                            <a onclick="url('{{url('/manage/system/notices')}}')"><i
                                        class="fa fa-circle-o text-yellow"></i>公告信息</a>
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
                        <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                        <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
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
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->

            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            {{Auth::guard('manage')->user()->name}}
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Other sets of options are available
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
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