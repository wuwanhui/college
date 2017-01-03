@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            班级管理
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">班级管理</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" v-on:click="create()">新增</button>
                    </div>
                    <div class="col-md-10 text-right">
                        <form method="get" class="form-inline">
                            <div class="input-group">
                                <select id="type" name="type" class="form-control" style="width: auto;"
                                        v-model="params.state">
                                    <option value="" selected>班级状态</option>
                                    <option v-bind:value="0">正常</option>
                                    <option v-bind:value="1">禁用</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="关键字"
                                       name="key" v-model="params.key">
                                <span class="input-group-btn">
								<button class="btn btn-default" type="button" v-on:click="search()">搜索</button>
                                     <button type="button" class="btn btn-default" v-on:click="params={};init();">
                                    重置
                                </button>
							</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <form method="Post" class="form-inline">
                <table class="table table-bordered table-hover  table-condensed">
                    <thead>
                    <tr style="text-align: center" class="text-center">
                        <th style="width: 60px;">序号</th>
                        <th>班级名称</th>
                        <th><a href="">学生</a></th>
                        <th style="width: 100px;">状态</th>
                        <th style="width: 100px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in list.data">
                        <td style="text-align: center" v-text="$index+1"></td>
                        <td style="text-align: center" v-text="item.name"></td>
                        <td style="text-align: center" v-text="item.students_count">
                        </td>
                        <td style="text-align: center" v-text="stateCN(item.state)"></td>

                        <td style="text-align: center"><a
                                    v-on:click="edit(item)">编辑</a>
                            |
                            <a v-on:click="delete(item)">删除</a>

                        </td>
                    </tr>

                    </tbody>
                </table>
            </form>
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                    <div class="btn-group">

                    </div>

                    <div class="pull-right">
                        @include("common.page")
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var vm = new Vue({
            el: '.content',
            data: {
                ids: [],
                params: {page: '', state: ''},
                list: eval({!! json_encode($list) !!}),
                classes: {},
            },
            watch: {
                'params.state': function () {
                    this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'classes': function () {
                    var _self = this;
                    this.ids = [];


                }
            },
            ready: function () {
                //this.init();
            },

            methods: {
                init: function () {
                    var _self = this;
                    this.$http.get("{{url('/manage/classes?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );

                },
                search: function () {
                    this.init();
                },

                create: function () {
                    openUrl('{{url('/manage/classes/create')}}', '新增班级', 800, 500);
                },
                edit: function (item) {
                    this.classes = item;
                    openUrl('{{url('/manage/classes/edit')}}?id=' + item.id, '编辑"' + item.name + '"班级', 800, 500);
                },
                delete: function (item) {
                    layer.confirm('您确认要删除“' + item.name + '”吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        layer.msg('的确很重要', {icon: 1});
                    }, function () {
                        layer.msg('也可以这样', {
                            time: 20000, //20s后自动关闭
                            btn: ['明白了', '知道了']
                        });
                    });
                },
                stateCN: function (id) {
                    switch (parseInt(id)) {
                        case 0:
                            return '正常';
                        case 1:
                            return '禁用';

                    }
                },
                sexCN: function (id) {
                    switch (parseInt(id)) {
                        case 0:
                            return '男';
                        case 1:
                            return '女';
                        default:
                            return '未知';

                    }
                },
            }
        });
    </script>
@endsection
