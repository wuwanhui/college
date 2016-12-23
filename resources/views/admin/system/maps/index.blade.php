@extends('layouts.admin')
@section('content')
    <section class="content-header">
        <h1>
            参数定义
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">参数定义</li>
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
                                    <option value="" selected>用户状态</option>
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

        <div class="row">
            <div class="col-md-2">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">参数分类</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked ">

                            <li v-for="(code,name) in baseMapsList.type" v-bind:class="{active:params.type==code}">
                                <a
                                        v-on:click="params.type=code" v-text="name"><span
                                            class="pull-right-container" v-if="item.children_count>0">
              <small class="label pull-right bg-blue" v-text="item.children_count"></small>
            </span></a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="box box-primary">
                    <form method="Post" class="form-inline">
                        <table class="table table-bordered table-hover  table-condensed">
                            <thead>
                            <tr style="text-align: center" class="text-center">
                                <th style="width: 20px"><input type="checkbox"
                                                               name="CheckAll" value="Checkid"/></th>
                                <th style="width: 60px;">序号</th>
                                <th>名称
                                </th>
                                <th>标识
                                </th>
                                <th><a href="">参数类型</a></th>
                                <th><a href="">控件类型</a></th>
                                <th><a href="">默认值</a></th>
                                <th style="width: 100px;">状态</th>
                                <th style="width: 120px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in baseMapsList.data.data">
                                <td><input type="checkbox" v-model="ids" v-bind:value="item.id"/></td>
                                <td style="text-align: center" v-text="$index+1"></td>
                                <td v-text="item.name"></td>
                                <td v-text="item.code"></td>

                                <td style="text-align: center" v-text="item.type_cn">
                                </td>
                                <td style="text-align: center" v-text="item.control_cn">
                                </td>
                                <td v-text="item.default"></td>
                                <td style="text-align: center" v-text="item.state_cn">
                                </td>
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
                                <page v-bind:lists="baseMapsList.data"></page>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'baseMaps'};
        var vm = new Vue({
            el: '.content',
            data: {
                ids: [],
                params: {page: null, state: null, type: null},
                baseMapsList: [],
                baseMapsItem: {},
            },
            watch: {
                'params.state': function () {
                    this.init();
                },
                'params.type': function () {
                    this.init();
                },
//                'params.page': function () {
//                    this.init();
//                }
            },
            created: function () {
                this.init();
            },

            methods: {
                init: function () {
                    var _self = this;
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/admin/system/basemaps?json')}}",
                        data: _self.params,
                        success: function (_obj) {
                            _self.baseMapsList = _obj.data;

                        }
                    });

                },
                search: function () {
                    this.init();
                },
                create: function () {
                    openUrl('{{url('/admin/system/basemaps/create')}}', '新增参数', 800, 500);
                },
                edit: function (item) {
                    this.baseMapsItem = item;
                    openUrl('{{url('/admin/system/basemaps/edit')}}', '编辑"' + item.name + '"参数', 800, 500);
                },
                delete: function (item) {
                    var _self = this;
                    layer.confirm('您确认要删除“' + item.name + '”吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        $.ajax({
                            type: 'POST',
                            url: "{{url('/admin/system/basemaps/delete')}}",
                            data: item,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (_obj) {
                                if (_obj.code == 0) {
                                    _self.init();
                                    layer.msg(_obj.msg, {icon: 6});
                                    return;
                                }
                                layer.alert(_obj.msg, {icon: 5});

                            }
                        });
                    });
                },

            }
        });
    </script>
@endsection
