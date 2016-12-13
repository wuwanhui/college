@extends('layouts.app')
@section('content')
    <section class="content-header" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <h1>
            银行账号
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 财务中心</a></li>
            <li class="active">银行账号</li>
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
                                    <option value="" selected>状态</option>
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
                        <th style="width: 60px;">编号</th>
                        <th><a href="">户名</a></th>
                        <th><a href="">开户银行</a></th>
                        <th><a href="">银行账号</a></th>
                        <th style="width: 100px;">状态</th>
                        <th style="width: 60px;">操作人</th>
                        <th style="width: 60px;">操作时间</th>
                        <th style="width: 160px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in bankList.data">
                        <td><input type="checkbox" v-model="ids" v-bind:value="item.id"/></td>
                        <td style="text-align: center" v-text="item.id"></td>
                        <td v-text="item.bankUserName"></td>

                        <td v-text="item.bankTitle">
                        </td>
                        <td>
                            <span v-text="item.bankNumber"></span>
                        </td>
                        <td style="text-align: center" v-text="item.state_cn"></td>
                        <td>
                            <span v-text="item.created_Name"></span>
                        </td>
                        <td>
                            <span v-text="item.created_at"></span>
                        </td>
                        <td style="text-align: center"> <a
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
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'finance', item: 'bank'};
        var vue = new Vue({
            el: '.content',
            data: {
                ids: [],
                params: {page: '', state: ''},
                bankList: [],

            },
            watch: {
                'params.state': function () {
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
                        url: "{{url('/manage/finance/bank?json')}}",
                        data: _self.params,
                        success: function (_obj) {
                            _self.bankList = _obj.data;

                        }
                    });

                },
                search: function () {
                    this.init();
                },
                create: function () {
                    openUrl('{{('/manage/finance/bank/create')}}','添加银行账户',900,500)
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



            }
        });
    </script>
@endsection
