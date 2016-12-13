@extends('layouts.app')
@section('content')
    <section class="content-header" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <h1>
            用户管理
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">用户管理</li>
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
        <div class="box box-primary">
            <form method="Post" class="form-inline">
                <table class="table table-bordered table-hover  table-condensed">
                    <thead>
                    <tr style="text-align: center" class="text-center">
                        <th style="width: 20px"><input type="checkbox"
                                                       name="CheckAll" value="Checkid"/></th>
                        <th style="width: 60px;"><a href="">编号</a>
                        </th>
                        <th>姓名
                        </th>
                        <th><a href="">邮箱</a></th>
                        <th><a href="">角色</a></th>
                        <th style="width: 100px;">状态</th>
                        <th style="width: 160px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in userList.data">
                        <td><input type="checkbox" v-model="ids" v-bind:value="item.id"/></td>
                        <td style="text-align: center" v-text="item.id"></td>
                        <td v-text="item.name"></td>

                        <td v-text="item.email">
                        </td>
                        <td>
                            <span v-text="roleItem.display_name+','" v-for="roleItem in item.roles"></span>
                        </td>
                        <td style="text-align: center" v-text="item.state_cn"></td>

                        <td style="text-align: center"><a
                                    v-on:click="authorize(item)">授权</a>
                            |<a
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
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"
                                                                                v-on:click="delete(ids)"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"
                                                                                v-on:click="btnBank()"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                    <div class="pull-right">
                        <page v-bind:lists="userList"></page>
                    </div>
                </div>
            </div>
        </div>
        @{{ ids|json }}
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        ////sidebar.menu = {type: 'system', item: 'user'};
        var vm = new Vue({
            el: '.content',
            data: {
                ids: [],
                params: {page: '', state: ''},
                userList: [],
                roleList: [],
                user: {},
                role_user: {id: '', roles: {'id': []}},
            },
            watch: {
                'params.state': function () {
                    this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'user': function () {
                    var _self = this;
                    this.ids = [];
                    this.user.roles.forEach(function (item) {
                        _self.ids.push(item.id)
                    });

                }
            },
            ready: function () {
                this.init();
            },

            methods: {
                init: function () {
                    var _self = this;
                    this.$http.get("{{url('/manage/system/user?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.userList = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );

                },
                search: function () {
                    this.init();
                },
                authorize: function (item) {
                    this.user = item;
                    openUrl('{{url('/manage/system/user/authorize')}}', '用户授权', 800, 600);
                },
                create: function () {
                    openUrl('{{url('/manage/system/user/create')}}', '新增用户', 800, 600);
                },
                edit: function (item) {
                    this.user = item;
                    openUrl('{{url('/manage/system/user/edit')}}?id=' + item.id, '编辑"' + item.name + '"用户', 800, 600);
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


                initRole: function () {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/role?json')}}",
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.roleList = _obj.data;
                            } else {
                                alert(_obj.msg);

                            }

                        }
                    });
                },
                filterRole: function () {
                    var _self = this;
                    var arr = _self.roleList.data;

//                    for (var i = 0; i < _self.roleList.data.length; i++) {
//                        var item = _self.roleList.data[i];
//                        for (var j = 0; i < _self.roleList.data.length; i++) {
//                            var subItem = _self.user.roles[j];
//                            //alert(JSON.stringify(subItem.id+":"+item.id));
//                            if (subItem == item) {
//                                arr.splice(i, 1);
//                            }
//                        }
//                    }

                    return arr;

                },
                addRole: function () {
                    var _self = this;
                    _self.role_user.id = _self.user.id;
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/user/addrole')}}",
                        data: _self.role_user,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.init();
                            }

                            alert(_obj.msg);
                        }
                    });
                },
                removeRole: function () {
                    var _self = this;
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/user/role')}}",
                        data: _self.role_user,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.init();
                            }

                            alert(_obj.msg);
                        }
                    });
                }
            }
        });
    </script>
@endsection
