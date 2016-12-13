@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            模块权限
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">模块权限</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">模块权限</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked ">
                            <li v-bind:class="{active:parent.id==0}"><a

                                        v-on:click="parent.id=0"><i class="fa fa-inbox"></i>顶级</a></li>

                            <li v-for="item in lists.data" v-bind:class="{active:parent==item}"><a
                                        v-text="item.name"
                                        v-on:click="parent=item"></a>
                                <ul>
                                    <li><a

                                                v-on:click="parent.id=0"> 二级 </a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
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
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-bordered table-hover  table-condensed">
                                    <thead>
                                    <tr style="text-align: center" class="text-center">
                                        <th style="width: 20px"><input type="checkbox"
                                                                       name="CheckAll" value="Checkid"/></th>
                                        <th style="width: 60px;"><a href="">编号</a></th>
                                        <th><a href="">名称</a></th>
                                        <th><a href="">标识</a></th>
                                        <th><a href="">父级</a></th>
                                        <th><a href="">地址</a></th>
                                        <th><a href="">显示</a></th>
                                        <th><a href="">描述</a></th>
                                        <th style="width: 100px;">状态</th>
                                        <th style="width: 100px;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in childrenList.data">
                                        <td><input type="checkbox"
                                                   name="id"/></td>
                                        <td style="text-align: center" v-text="item.id"></td>
                                        <td v-text="item.name"></td>
                                        <td v-text="item.code"></td>
                                        <td v-text="item.parent.name"></td>
                                        <td v-text="item.url"></td>
                                        <td v-text="item.isShow==0?'显示':'隐藏'"></td>
                                        <td v-text="item.remark">
                                        </td>

                                        <td style="text-align: center" v-text="item.state==0?'正常':'禁用'">
                                        </td>

                                        <td style="text-align: center"><a
                                                    href="{{url('/manage/system/permission/edit/' )}}">编辑</a>
                                            |
                                            <a href="{{url('/manage/system/permission/delete/' )}}">删除</a>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
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
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay">
            <i class="fa fa-refresh fa-spin"></i>
        </div>
        @{{ childrenList|json }}
    </section>

    <!-- 新增 -->
    <div class="modal fade" id="createPermission" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增模块权限</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="permission.name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">标识：</label>

                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control" name="code"
                                       v-model="permission.code">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">URL地址：</label>

                            <div class="col-md-9">
                                <input id="url" type="text" class="form-control" name="url"
                                       v-model="permission.url">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isShow" class="col-md-3 control-label">是否显示：</label>

                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" v-model="permission.isShow" value="0">显示
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="permission.isShow" value="1">不显示
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remark" class="col-md-3 control-label">描述：</label>

                            <div class="col-md-9">
                                <textarea id="remark" class="form-control"
                                          style="width: 100%;height: 50px;"
                                          v-model="permission.remark"></textarea>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="create()">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'permission'};
        var vue = new Vue({
            el: '.content',
            data: {
                params: {},
                lists: [],
                permission: {},
                parent: {id: 0},
                childrenList: [],
            },
            watch: {
                'parent.id': function () {
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
                    this.$http.get("{{url('/manage/system/permission?json')}}" + "&pid=" + _self.parent.id)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            if (_self.parent.id == 0) {
                                                _self.lists = response.body.data;
                                            } else {
                                                //layer.alert(JSON.stringify(response.data.data));
                                                _self.childrenList = response.body.data;
                                            }
                                        } else {
                                            alert(response.data.msg);
                                        }
                                    }
                            );
                },
                create: function () {
                    var _self = this;
                    _self.permission.parent_id = _self.parent.id;
                    this.$http.post("{{url('/manage/system/permission/create')}}", _self.permission)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.init();
                                        }

                                        alert(response.data.msg);
                                    }
                            );
                }

            }
        });
    </script>
@endsection
