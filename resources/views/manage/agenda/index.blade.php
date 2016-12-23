@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            课程
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage/crm')}}"><i class="fa fa-dashboard"></i> 客户关系</a></li>
            <li class="active">课程</li>
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
                                    <th><a href="">课程名称</a></th>
                                    <th style="width: 80px;"><a href="">任课教师</a></th>
                                    <th><a href="">备注</a></th>
                                    <th style="width: 60px;">状态</th>
                                    <th style="width: 100px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in list.data">
                                    <td><input type="checkbox"
                                               name="id" v-bind:value="item.id" v-model="ids"/></td>
                                    <td style="text-align: center" v-text="item.id"></td>
                                    <td v-text="item.name"></td>
                                    <td style="text-align: center" v-text="item.teacher"></td>

                                    <td v-text="item.remark">
                                    </td>

                                    <td style="text-align: center"><a
                                                v-bind:class="{'text-warning':item.state==1 }"
                                                v-on:click="state(item);" v-text="stateCN(item.state)"></a>
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
        var vm = new Vue({
            el: '.content',
            data: {
                list: jsonFilter('{{json_encode($list)}}'),
                agenda: {},
                ids: [],
                params: {state: -1, page: 1},
            },
            watch: {
                'params.state': function () {
                },
                'params.page': function () {
                    this.init();
                }
            },
            ready: function () {

            },

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/agenda?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response));
                                    }
                            );
                },
                search: function (reset) {
                    if (reset) {
                        this.params = {state: -1, page: 1, key: ''};
                        this.init();
                        return
                    }
                    this.init();
                },
                create: function () {
                    openUrl('{{url('/manage/agenda/create')}}', '新增课程', 800, 400);
                },
                edit: function (item) {
                    this.agenda = item;
                    openUrl('{{url('/manage/agenda/edit')}}', '编辑"' + item.name + '"课程', 800, 400);
                },
                state: function (item) {
                    var _self = this;
                    this.agenda = item;
                    this.agenda.state = this.agenda.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/agenda/edit')}}',
                        data: _self.agenda,
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
                        _self.$http.post("{{url('/manage/agenda/delete')}}", {ids: ids})
                                .then(function (response) {
                                            if (response.data.code == 0) {
                                                _self.init();
                                                layer.closeAll();
                                                msg('成功删除' + response.data.data + '条记录！');
                                                return
                                            }
                                            layer.alert(JSON.stringify(response));
                                        }
                                );
                    }, function () {
                        layer.closeAll();
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

            }
        });

    </script>
@endsection
