@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            部门机构
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">部门机构</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2 parent">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">部门机构</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked ">
                            <li class="active"><a
                                        v-bind:class="{active:dept.id==0}"
                                        v-on:click="children(0)"><i class="fa fa-inbox"></i>顶级</a></li>
                            <li>

                            <li v-for="item in lists"><a
                                                         v-bind:class="{active:dept.id==item.id}"
                                                         v-on:click="children(item.id)">@{{ item.name }}<span
                                            class="pull-right-container" v-if="item.children_count>0">
              <small class="label pull-right bg-blue" v-text="item.children_count"></small>
            </span></a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-10  ">
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
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-bordered table-hover  table-condensed">
                                <thead>
                                <tr style="text-align: center" class="text-center">
                                    <th style="width: 20px"><input type="checkbox"
                                                                   name="CheckAll" value="Checkid"/></th>
                                    <th style="width: 60px;">序号</th>
                                    <th><a href="">部门名称</a></th>
                                    <th><a href="">所属上级</a></th>
                                    <th style="width: 100px;">状态</th>
                                    <th style="width: 100px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in childrenList">
                                    <td><input type="checkbox"
                                               name="id"/></td>
                                    <td style="text-align: center" v-text="$index+1"></td>
                                    <td v-text="item.name"></td>

                                    <td v-text="item.parent.name">
                                    </td>
                                    <td style="text-align: center"><a
                                                v-text="item.state_cn"
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
                        </div>
                    </div>
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"
                                                                                        v-on:click="delete(ids)"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i>
                                </button>
                            </div>

                            <div class="pull-right">
                                @include("common.page")
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        @{{ childrenList|json }}

        @{{ parent|json }}
    </section>
@endsection

@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'dept'};
        //父级
        var vue = new Vue({
            el: '.content',
            data: {
                lists: [],
                dept: {},
                ids: [],
                params: {page: null, state: null},
                parent: {},
                childrenList: []
            },
            watch: {
                'params.state': function () {
                    this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'parent': function (val) {
                    this.children(val.id);
                }
            },

            created: function() {
                this.init();
            },

            methods: {
                init : function () {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/dept?json')}}",
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.lists = _obj.data;
                            } else {
                                alert(_obj.msg);
                            }

                        }
                    });
                },



                children: function (_pid) {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/dept?json')}}",
                        data: {pid: _pid},
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.childrenList = _obj.data;
                            } else {
                                alert(_obj.msg);
                            }

                        }
                    });
                },

                create: function () {
                    openUrl('{{url('/manage/system/dept/create')}}', '新增部门');
                },
                edit: function (item) {
                    this.dept = item;
                    openUrl('{{url('/manage/system/dept/edit')}}?id=' + item.id, '编辑"' + item.name + '"部门');
                },
                delete: function (ids) {
                    var _self = this;
                    layer.confirm('确认删除吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        $.ajax({
                            type: 'POST',
                            url: '{{url('/manage/system/dept/delete')}}',
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

        //子级
        var childrenVue = new Vue({
            el: '.children',
            data: {
                lists: [],
                dept: {},
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

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/dept?json')}}",
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
                    openUrl('{{url('/manage/system/dept/create')}}', '新增部门');
                },
                edit: function (item) {
                    this.dept = item;
                    openUrl('{{url('/manage/system/dept/edit')}}?id=' + item.id, '编辑"' + item.name + '"部门');
                },
                state: function (item) {
                    var _self = this;
                    this.dept = item;
                    this.dept.state = this.dept.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/system/dept/edit')}}',
                        data: _self.dept,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                            url: '{{url('/manage/system/dept/delete')}}',
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
        childrenVue.init();

    </script>

@endsection