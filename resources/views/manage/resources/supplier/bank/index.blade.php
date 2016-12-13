@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            {{$supplier->name}}
            <small>银行账户列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li><a href="/manage/resources/supplier">供应商管理</a></li>
            <li class="active">银行账户管理</li>
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
                                <select id="state" name="state" class="form-control" style="width: auto;"
                                        v-model="params.state">
                                    <option value="-1" selected>所有状态</option>
                                    <option v-bind:value="0">正常</option>
                                    <option v-bind:value="1">禁用</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="关键字"
                                       name="key" v-model="params.key">
                                        <span class="input-group-btn">
                                     <button class="btn btn-default" type="button" v-on:click="search()">搜索</button>
                                         <button type="button" class="btn btn-default"
                                                 v-on:click="search(true);">重置</button>
                                        </span>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <form method="Post" class="form-inline">
                <fieldset>
                    <table class="table table-bordered table-hover  table-condensed">
                        <thead>
                        <tr style="text-align: center" class="text-center">
                            <th style="width: 20px"><input type="checkbox"
                                                           name="CheckAll" value="Checkid"/></th>
                            <th style="width: 40px;">序号</th>
                            <th>账户名</th>
                            <th>卡号</th>
                            <th>银行代码</th>
                            <th>银行名称</th>
                            <th style="width: 100px;">创建人</th>
                            <th style="width: 150px;">创建时间</th>
                            <th style="width: 60px;">状态</th>
                            <th style="width: 60px;">排序</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list.data">
                            <td style="text-align: center"><input type="checkbox" v-bind:value="item.id"
                                                                  name="id" v-model="ids"/></td>
                            <td style="text-align: center" v-text="$index+1"></td>
                            <td style="text-align: center" v-text="item.accountName"></td>
                            <td style="text-align: center" v-text="item.cardNumer"></td>
                            <td style="text-align: center" v-text="item.bankCode"></td>
                            <td style="text-align: center" v-text="item.bankName"></td>
                            <td style="text-align: center" v-text="item.createName"></td>
                            <td style="text-align: center" v-text="item.created_at"></td>
                            <td style="text-align: center">
                                <span v-if="item.state==0" class="text-success">正常</span>
                                <span v-else class="text-danger">禁用</span>
                            </td>
                            <td style="text-align: center" v-text="item.sort"></td>
                            <td style="text-align: center">
                                <a
                                        v-on:click="edit(item)">编辑</a>
                                |
                                <a v-on:click="delete(item.id)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </fieldset>
            </form>
            <div class="box-footer no-padding">
                <div class="mailbox-controls">
                        <button type="button" class="btn btn-default btn-sm" v-on:click="delete(ids)"><i
                                    class="fa fa-trash-o"></i>批量删除
                        </button>
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
        //sidebar.menu = {type: 'resources', item: 'supplier'};
        var vm = new Vue({
            el: '.content',
            data: {
                params: {page: 1, state: -1,id:'{{$supplier->id}}'},
                list: jsonFilter('{{json_encode($list)}}'),
                ids: [],
                sid:'{{$supplier->id}}' //供应商ID
            },
            watch: {
                //监听参数变化
                'params.page': function () {
                    this.init();
                }
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载供应商银行账户数据
                    this.$http.get("{{url('/manage/resources/supplier/bank?json')}}", {params: this.params})
                            .then(function (response) {
                                        var _obj = response.data;

                                        if (_obj.code == 0) {
                                            _self.list = _obj.data;
                                            return
                                        }
                                        layer.alert(_obj.msg);
                                    }
                            );
                },
                create: function () {
                    openUrl('{{url('/manage/resources/supplier/bank/create')}}', '新增银行账户', 600, 600);
                },
                edit: function (item) {
                    //编辑
                    openUrl('{{url('/manage/resources/supplier/bank/edit')}}?id=' + item.id, '编辑银行账户', 600, 600);
                },
                delete: function (ids) {
                    if (ids == "") {
                        layer.msg('请选择要删除的银行账户！');
                        return;
                    }

                    var _self = this;
                    //删除方法
                    layer.confirm('您确认要删除选择的银行账户？', {
                        btn: ['确认', '取消']
                    }, function () {
                        //提交修改保存
                        _self.$http.post("{{url('/manage/resources/supplier/bank/delete')}}", {ids: ids}).then(function (resspose) {
                            var _obj = resspose.data;
                            layer.closeAll();
                            if (_obj.code == 0) {
                                //删除
                                msg('删除操作成功!');
                                _self.init();
                            } else {
                                layer.alert(_obj.msg);
                            }
                        }, function (erro) {
                            layer.alert(erro, {icon: 5});
                        });
                    });
                },
                search: function (bg) {
                    if(bg)
                    {
                        this.params={page: 1, state: -1,id:'{{$supplier->id}}'};
                    }
                    //搜索方法
                    this.init();
                }
            }
        });
    </script>
@endsection
