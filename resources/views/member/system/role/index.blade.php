@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            角色管理
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">角色管理</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" v-on:click="create()">新增</button>
                            </div>
                            <div class="col-md-10 text-right">
                                <form method="get" class="form-inline">
                                    <div class="input-group">
                                        <select id="type" name="type" class="form-control" style="width: auto;">
                                            <option value="">所有类型</option>
                                            <option value="0">系统帐户</option>
                                            <option value="1">普通帐户</option>
                                            <option value="2">供应商</option>
                                            <option value="3">分销商</option>
                                            <option value="4">会员</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="关键字"
                                               name="key" v-model="params.key">
                                        <span class="input-group-btn">
                                     <button class="btn btn-default" type="button" v-on:click="search()">搜索</button>
                                         <button type="button" class="btn btn-default"
                                                 v-on:click="params={};init();">重置</button>
                                        </span>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <form method="Post" class="form-inline">
                            <table class="table table-bordered table-hover  table-condensed">
                                <thead>
                                <tr style="text-align: center" class="text-center">
                                    <th style="width: 20px"><input type="checkbox"
                                                                   name="CheckAll" value="Checkid"
                                                                   v-on:click="ids=!ids"/>
                                    </th>
                                    <th style="width: 60px;"><a href="">编号</a></th>
                                    <th><a href="">角色名称</a></th>
                                    <th><a href="">描述</a></th>
                                    <th style="width: 100px;">状态</th>
                                    <th style="width: 100px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in lists.data">
                                    <td><input type="checkbox"
                                               name="id" v-bind:value="item.id" v-model="ids"/></td>
                                    <td style="text-align: center" v-text="item.id"></td>
                                    <td v-text="item.name"></td>

                                    <td v-text="item.remark">
                                    </td>

                                    <td style="text-align: center"><a
                                                v-text="item.state==0?'正常':'禁用'"
                                                v-bind:class="{'text-warning':item.state==1 }"
                                                v-on:click="state(item);"></a>
                                    </td>

                                    <td style="text-align: center">
                                        <a v-on:click="edit(item);">编辑</a>
                                        |
                                        <a v-on:click="delete(item.id)">删除</a>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                        <div class="box-footer no-padding">
                            <div class="mailbox-controls">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"
                                                                                            v-on:click="delete(ids)"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"
                                                                                            v-on:click="btnBank()"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i>
                                    </button>
                                </div>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>
                                </button>
                                <div class="pull-right">
                                    @include("common.page")
                                </div>
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
        //sidebar.menu = {type: 'system', item: 'role'};
        var vue = new Vue({
            el: '.content',
            data: {
                lists: [],
                role: {},
                ids: [],
                params: {page: null, state: null},
            },
            watch: {
                'params.state': function () {
                    this.init();
                },
                'params.page': function () {
                    this.init();
                }
            },
            created: function () {
                this.init();
            },

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/role?json')}}",
                        data: _self.params,
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.lists = _obj.data;
                            } else {
                                alert(_obj.msg);

                            }

                        }
                    });
                },
                search: function () {
                    this.init();
                },
                create: function () {
                    openUrl('{{url('/manage/system/role/create')}}', '新增角色');
                },
                edit: function (item) {
                    this.role = item;
                    openUrl('{{url('/manage/system/role/edit')}}?id=' + item.id, '编辑"' + item.name + '"角色');
                },
                state: function (item) {
                    var _self = this;
                    this.role = item;
                    this.role.state = this.role.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/system/role/edit')}}',
                        data: _self.role,
                        headers: {
                            'X-CSRF-TOKEN': Laravel.csrfToken
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.init();
                                layer.msg('状态修改成功！', {icon: 6, time: 1000});
                            } else {
                                layer.alert(_obj.msg, {icon: 1});
                            }

                        }
                    });
                },
                delete: function (ids) {
                    var _self = this;
                    layer.confirm('确认删除吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        $.ajax({
                            type: 'POST',
                            url: '{{url('/manage/system/role/delete')}}',
                            data: {ids: ids},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (_obj) {
                                if (_obj.code == 0) {
                                    _self.init();
                                    layer.msg('成功删除' + _obj.data + '条记录！', {icon: 6, time: 1000});
                                } else {
                                    layer.alert(_obj.msg, {icon: 1});
                                }

                            }
                        });
                    }, function () {
                        layer.closeAll();
                    });
                }


            }
        });

    </script>
@endsection
