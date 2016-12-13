@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            资源管理
            <small>线路类别</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">资源管理</li>
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
                            <th style="width: 180px;">名称</th>
                            <th>标签</th>
                            <th>内容</th>
                            <th style="width: 100px;">创建人</th>
                            <th style="width: 150px;">创建时间</th>
                            <th style="width: 100px;">状态</th>
                            <th style="width: 60px;">排序</th>
                            <th style="width: 180px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list.data">
                            <td style="text-align: center"><input type="checkbox" v-bind:value="item.id"
                                                                  name="id" v-model="ids"/></td>
                            <td style="text-align: center" v-text="$index+1"></td>
                            <td style="text-align: center" v-text="item.name"></td>
                            <td style="text-align: center" v-text="item.tag"></td>
                            <td v-text="item.content"></td>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" v-on:click="delete(ids)"><i
                                    class="fa fa-trash-o"></i>批量删除
                        </button>
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
        //sidebar.menu = {type: 'resources', item: 'lineclass'};
        var vm = new Vue({
            el: '.content',
            data: {
                params: {page: 1, state: -1},
                list: jsonFilter('{{json_encode($list)}}'),
                ids: []
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
                    //加载线路分类数据
                    this.$http.get("{{url('/manage/resources/lineclass?json')}}", {params: this.params})
                            .then(function (response) {
                                var _obj=response.data;
                                        if (_obj.code == 0) {
                                            _self.list = _obj.data;
                                            return
                                        }
                                        layer.alert(_obj.msg);
                                    }
                            );
                },
                create: function () {
                    openUrl('{{url('/manage/resources/lineclass/create')}}', '新增线路分类', 600, 600);
                },
                edit: function (item) {
                    //编辑
                    openUrl('{{url('/manage/resources/lineclass/edit')}}?id=' + item.id, '修改线路分类', 600, 600);
                },
                delete: function (ids) {
                    if (ids == "") {
                        layer.msg('请选择要删除的线路分类！');
                        return;
                    }

                    var _self = this;
                    //删除方法
                    layer.confirm('您确认要删除该线路分类？', {
                        btn: ['确认', '取消']
                    }, function () {
                        //提交修改保存
                        _self.$http.post("{{url('/manage/resources/lineclass/delete')}}", {ids: ids}).then(function (resspose) {
                            var _obj = resspose.data;
                            layer.closeAll();
                            if (_obj.code == 0) {
                                //删除成功
                                _self.init();
                            } else {
                                layer.alert(_obj.msg);
                            }
                        }, function (erro) {
                            layer.alert(erro, {icon: 5});
                        });
                    });
                },
                search: function () {
                    //搜索方法
                    this.init();
                }
            }
        });
    </script>
@endsection
