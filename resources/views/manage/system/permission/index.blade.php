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
                <ul id="nav">
                    <li><a href="#">主页</a></li>
                    <li><a href="#">产品</a>
                        <ul>
                            <li><a href="#">大类别一</a>
                                <ul>
                                    <li><a href="#">小类别一</a>
                                        <ul>
                                            <li><a href="#">次类别一</a></li>
                                            <li><a href="#">次类别二</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">小类别二</a></li>
                                </ul>
                            </li>
                            <li><a href="#">大类别二</a></li>
                            <li><a href="#">大类别三</a>
                                <ul>
                                    <li><a href="#">小类别一</a></li>
                                    <li><a href="#">小类别二</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">服务</a>
                        <ul>
                            <li><a href="#">大类别一</a></li>
                            <li><a href="#">大类别二</a></li>
                            <li><a href="#">大类别三</a></li>
                        </ul>
                    </li>
                    <li><a href="#">合作</a></li>
                    <li><a href="#">关于我们</a>
                        <ul>
                            <li><a href="#">大类别一</a>
                                <ul>
                                    <li><a href="#">小类别一</a></li>
                                    <li><a href="#">小类别二</a></li>
                                </ul>
                            </li>
                            <li><a href="#">大类别二</a>
                                <ul>
                                    <li><a href="#">小类别一</a></li>
                                    <li><a href="#">小类别二</a></li>
                                </ul>
                            </li>
                            <li><a href="#">大类别三</a>
                                <ul>
                                    <li><a href="#">小类别一</a></li>
                                    <li><a href="#">小类别二</a></li>
                                </ul>
                            </li>
                            <li><a href="#">大类别四</a></li>
                        </ul>
                    </li>
                    <li><a href="#">联系我们</a>
                        <ul>
                            <li><a href="#">大类别一</a></li>
                            <li><a href="#">大类别二</a></li>
                        </ul>
                    </li>
                </ul>
                <div id="tree1"></div>
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

                        <tree-template v-bind:data="parentList" v-bind:parent="parent"></tree-template>
                        <ul class="nav nav-pills nav-stacked ">
                            <li v-bind:class="{active:parent.id==0}"><a
                                        v-on:click="parent={id:0}"><i class="fa fa-inbox"></i>顶级</a></li>
                            <li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" v-on:click="isCreate=true;">新增</button>
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
                                    <tr v-for="item in list.data">
                                        <td><input type="checkbox"
                                                   name="id"/></td>
                                        <td style="text-align: center" v-text="item.id"></td>
                                        <td v-text="item.display_name"></td>
                                        <td v-text="item.name"></td>
                                        <td v-text="item.parent.display_name"></td>
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
        <script type="text/x-template" id="tree">
            <ul class="nav nav-pills nav-stacked ">

                <li v-for="item in data" v-bind:class="{active:parent.id==item.id}"><a
                            v-text="item.display_name"
                            v-on:click="parent=item" v-if="item.isShow==0"></a>

                    <tree-template v-if="item.children.length>0" v-bind:data="item.children"></tree-template>
                </li>
            </ul>
        </script>

        <permission-create v-if="isCreate" v-bind:parent="parent" title="新增权限"
                           v-on:close="isCreate = false"></permission-create>
        <script type="text/x-template" id="create">
            <transition name="modal" mode="out-in" appear>
                <validator name="validator">
                    <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                        <div class="modal-mask">
                            <div class="modal-wrapper">
                                <div class="modal-container">

                                    <div class="modal-header">
                                        <div class="modal-title" v-text="title"></div>
                                        <div class="modal-close">关闭</div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name" class="col-md-3 control-label">名称：</label>

                                            <div class="col-md-9">
                                                <input id="name" type="text" class="form-control" name="name"
                                                       v-model="permission.parent_name" v-bind:value="parent.id"
                                                       :class="{ 'error': $validator.name.invalid && trySubmit }"
                                                       v-validate:name="{ required: true}" placeholder="不能为空">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="col-md-3 control-label">名称：</label>

                                            <div class="col-md-9">
                                                <input id="name" type="text" class="form-control" name="name"
                                                       v-model="permission.name"
                                                       :class="{ 'error': $validator.name.invalid && trySubmit }"
                                                       v-validate:name="{ required: true}" placeholder="不能为空">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="code" class="col-md-3 control-label">标识：</label>

                                            <div class="col-md-9">
                                                <input id="code" type="text" class="form-control" name="code"
                                                       v-model="permission.code"
                                                       :class="{ 'error': $validator.code.invalid && trySubmit }"
                                                       v-validate:code="{ required: true}" placeholder="不能为空">

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


                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                                v-on:click="$emit('close')">返回
                                        </button>
                                        <button type="button" class="btn  btn-primary"
                                                v-on:click="save($validator)">保存
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </validator>
            </transition>
        </script>

    </section>
@endsection
@section('script')
    <script src="/js/bootstrap/js/bootstrap-treeview.min.js"></script>
    <script type="application/javascript">

        $('#tree1').treeview({
            data: [
                {
                    text: "Parent 1",
                    nodes: [
                        {
                            text: "Child 1",
                            nodes: [
                                {
                                    text: "Grandchild 1"
                                },
                                {
                                    text: "Grandchild 2"
                                }
                            ]
                        },
                        {
                            text: "Child 2"
                        }
                    ]
                },
                {
                    text: "Parent 2"
                },
                {
                    text: "Parent 3"
                },
                {
                    text: "Parent 4"
                },
                {
                    text: "Parent 5"
                }
            ]
        });
        ////sidebar.menu = {type: 'system', item: 'permission'};
        // 注册
        Vue.component('tree-template', {
            template: '#tree',
            props: ['data', 'parent'],
            data: function () {
                return {parent: {id: 0}}
            },
            watch: {
                'parent': function () {
                    vm.parent = this.parent;
                }

            },
            methods: {},
        });
        // 新增
        Vue.component('permission-create', {
            template: '#create',
            props: ['parent', 'title'],
            data: function () {
                return {permission: {}}
            },
            watch: {},
            methods: {
                save: function (form) {

                    var _self = this;

                    if (form.invalid) {
                        this.trySubmit = true;
                        return;
                    }
                    this.permission.parent_name = this.parent.id;

                    this.$http.post("{{url('/manage/system/permission/create')}}", this.permission)
                            .then(function (response) {
                                        if (response.data.code == 0) {

                                            msg('新增成功');
                                            _self.$emit('close');
                                            vm.init();
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );
                }

            },
        });


        // 创建根实例
        var vm = new Vue({
            el: '.content',
            data: {
                isCreate: false,
                params: {},
                parentList: jsonFilter('{{json_encode($list)}}'),
                parent: {id: 0},
                list: []
            },
            watch: {
                'parent.id': function () {
                    this.init();
                }

            },
            ready: function () {
                //this.init();
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/system/permission?json')}}", {params: {pid: _self.parent.id}})
                            .then(function (response) {
                                        if (response.data.code == 0) {

                                            _self.list = response.data.data;
                                            return;
                                        }
                                        alert(response.data.msg);

                                    }
                            );
                },
                create: function () {
                    var _self = this;
                    openUrl("{{url('/manage/system/permission/create')}}", '新增模块权限')
                }, save: function () {
                    var _self = this;
                    _self.permission.parent_name = _self.parent.id;
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
