@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2 leftMenu">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">演示系统</div>

                            <div class="panel-body">
                                这个是模型说明
                            </div>
                            <ul class="list-group subMenu">
                                <li class="list-group-item active"><a href="{{url('/manage/demo')}}">列表页</a></li>
                                <li class="list-group-item"><a href="{{url('/manage/demo/create')}}"
                                    >新增</a></li>
                            </ul>
                        </div>
                        <div class="panel panel-warning">
                            <div class="panel-heading">子菜单分区</div>

                            <ul class="list-group subMenu">
                                <li class="list-group-item active"><a href="{{url('/manage/demo')}}">报表</a></li>
                                <li class="list-group-item"><a href="{{url('/manage/demo/create')}}"
                                    >新增</a></li>
                                <li class="list-group-item"><a href="{{url('/manage/demo')}}"
                                    >企业管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <ol class="breadcrumb">
                    <li><a href="#">供应商系统</a></li>
                    <li class="active">演示模型</li>
                </ol>

                <div>
                    <ul class="list">
                        <li v-for="info in data">
                            <i>
                                <img v-bind:src="info.author.avatar_url" v-bind:alt="info.author.loginname"/>
                                <span v-text="info.author.loginname"></span>
                            </i>
                            <time v-text="info.create_at | time"></time>
                            <a target="_blank" href="http://cnodejs.org/topic/@{{info.id}}" v-text="info.title"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="page"></div>


    <script type="text/javascript">
        function getJson(url, func) {
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        func(data);
                    } else {
                        alert('接口调用失败！');
                    }
                }, error: function (data) {
                    alert(JSON.stringify(data));
                }
            });
        }

        //获取地址栏上的参数ID
        function getUrlId() {
            var host = window.location.href;
            var id = host.substring(host.indexOf("?") + 1, host.length);
            return id;
        }

        $(function () {

            var id = getUrlId();
            var url = "http://cnodejs.org/api/v1/topics?page=" + id;
            getJson(url, pushDom);

//            //分页
//            layui.laypage({
//                cont: $(".page") //分页容器的id
//                , pages: 10 //总页数
//                , skin: '#5FB878' //自定义选中色值
//                , skip: true //开启跳页
//                , jump: function (obj, first) {
//                    if (!first) {
//                        location.href = '?' + obj.curr;
//                    }
//                }
//            });

        });

        function pushDom(data) {
            // 使用vue自定义过滤器把接口中传过来的时间进行整形
            Vue.filter('time', function (value) {
                return goodTime(value);
            });
            var vm = new Vue({
                el: '.list',
                data: data
            });
        }

        function goodTime(str) {
            var now = new Date().getTime(),
                    oldTime = new Date(str).getTime(),
                    difference = now - oldTime,
                    result = '',
                    minute = 1000 * 60,
                    hour = minute * 60,
                    day = hour * 24,
                    halfamonth = day * 15,
                    month = day * 30,
                    year = month * 12,

                    _year = difference / year,
                    _month = difference / month,
                    _week = difference / (7 * day),
                    _day = difference / day,
                    _hour = difference / hour,
                    _min = difference / minute;
            if (_year >= 1) {
                result = "发表于 " + ~~(_year) + " 年前"
            }
            else if (_month >= 1) {
                result = "发表于 " + ~~(_month) + " 个月前"
            }
            else if (_week >= 1) {
                result = "发表于 " + ~~(_week) + " 周前"
            }
            else if (_day >= 1) {
                result = "发表于 " + ~~(_day) + " 天前"
            }
            else if (_hour >= 1) {
                result = "发表于 " + ~~(_hour) + " 个小时前"
            }
            else if (_min >= 1) {
                result = "发表于 " + ~~(_min) + " 分钟前"
            }
            else result = "刚刚";
            return result;
        }

    </script>

@endsection
