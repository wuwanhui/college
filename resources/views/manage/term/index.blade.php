@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            学期
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage')}}"><i class="fa fa-dashboard"></i> 客户关系</a></li>
            <li class="active">学期</li>
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
                                    <th style="width: 60px;">序号</th>
                                    <th><a href="">名称</a></th>
                                    <th style="width: 120px;"><a href="">课程</a></th>
                                    <th style="width: 120px;"><a href="">学生</a></th>
                                    <th><a href="">备注</a></th>
                                    <th style="width: 60px;">状态</th>
                                    <th style="width: 100px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in list.data">
                                    <td style="text-align: center" v-text="$index+1"></td>
                                    <td><a v-on:click="detail(item)" v-text="item.name"></a></td>
                                    <td style="text-align: center"><a
                                                v-text="'绑定课程('+item.agendas.length+')'"></a>
                                    </td>
                                    <td style="text-align: center"><a
                                                v-text="'绑定学生('+item.students.length+')'"></a>
                                    </td>
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

                                </div>
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
        //sidebar.menu = {type: 'crm', item: 'customerLinkman'};
        var vm = new Vue({
            el: '.content',
            data: {
                list: eval({!!json_encode($list)!!}),
                term: {},
                ids: [],
                agendaIds: [],
                studentIds: [],
                params: {state: -1, page: 1},
            },
            watch: {
                'params.state': function () {
                    // this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'term': function () {
                    var _self = this;
                    this.agendaIds = [];
                    this.term.agendas.forEach(function (item) {
                        _self.agendaIds.push(item.id)
                    });
                    this.studentIds = [];
                    this.term.students.forEach(function (item) {
                        _self.studentIds.push(item.id)
                    });
                }

            },
            ready: function () {
                if (this.customer) {
                    this.params.id = this.customer.id;
                }

                //this.init();
            },

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/term?json')}}", {params: this.params})
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
                    openUrl('{{url('/manage/term/create')}}', '新增学期', 800, 300);
                },
                edit: function (item) {
                    this.term = item;
                    openUrl('{{url('/manage/term/edit')}}' + '?id=' + item.id, '编辑"' + item.name + '"学期', 800, 300);
                },
                detail: function (item) {
                    window.location.href = "{{url('/manage/term/detail')}}?id=" + item.id;
                },
                bindAgenda: function (item) {
                    this.term = item;
                    openUrl('{{url('/manage/term/bind/agenda')}}', '绑定课程', 800, 400);
                },
                bindStudent: function (item) {
                    this.term = item;
                    openUrl('{{url('/manage/term/bind/student')}}', '绑定学生', 800, 400);
                },
                state: function (item) {
                    var _self = this;
                    this.term = item;
                    this.term.state = this.term.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/term/edit')}}',
                        data: _self.term,
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
                        _self.$http.post("{{url('/manage/term/delete')}}", {ids: ids})
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
                sexCN: function (id) {
                    switch (parseInt(id)) {
                        case 0:
                            return '男';
                        case 1:
                            return '女';
                        default:
                            return '未知';

                    }
                },

            }
        });

    </script>
@endsection
