@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            微信标签
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage/weixin')}}"><i class="fa fa-dashboard"></i> 微信营销</a></li>
            <li class="active">微信标签</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box search">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" v-on:click="create()">新增</button>
                                <button type="button" class="btn btn-success" v-on:click="sync()">同步</button>
                            </div>
                            <div class="col-md-10 text-right">
                                <form method="get" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="关键字"
                                               name="key" v-model="params.key">
                                        <span class="input-group-btn">
                                     <button class="btn btn-default" type="button" v-on:click="search()">搜索</button>
                                         <button type="button" class="btn btn-default"
                                                 v-on:click="search(true);">重置</button>
                                        </span>

                                    </div>
                                    <button type="button" class="btn btn-default"
                                            v-on:click="moreServch=!moreServch">更多查询
                                    </button>

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
                                    <th><a href="">标签名称</a></th>
                                    <th style="width: 100px;"><a href="">粉丝数</a></th>
                                    <th style="width: 160px;"><a href="">同步时间</a></th>
                                    <th><a href="">备注</a></th>
                                    <th style="width: 120px;"><a href="">状态</a></th>
                                    <th style="width: 180px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in list.data">
                                    <td><input type="checkbox"
                                               name="id" v-bind:value="item.id" v-model="ids"/></td>
                                    <td v-bind:title="item.id" style="text-align: center"><a v-on:click="detail(item)"
                                                                                             v-text="item.id"></a></td>

                                    <td style="text-align: center" v-text="item.name"></td>
                                    <td style="text-align: center" v-text="item.count"></td>
                                    <td style="text-align: center" v-text="item.updated_at"></td>
                                    <td style="text-align: center" v-text="item.remark"></td>
                                    <td style="text-align: center"><a
                                                v-text="item.state==0?'正常':'禁用'"
                                                v-bind:class="{'text-warning':item.state==0 }"
                                        ></a>
                                    </td>
                                    <td style="text-align: center">
                                        <a v-on:click="update(item)">更新</a>
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
        //sidebar.menu = {type: 'weixin', item: 'attention'};
        var vm = new Vue({
            el: '.content',
            data: {
                moreServch: true,
                list: jsonFilter('{{json_encode($list)}}'),
                ids: [],
                params: {state: -1, page: 1},
            },
            watch: {
                'params.state': function () {
                    // this.init();
                },
                'params.page': function () {
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
                    this.$http.get("{{url('/manage/weixin/user/tags?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
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
                    window.location.href = '{{url('/manage/weixin/user/tags/create')}}';
                },
                edit: function (item) {
                    this.customer = item;
                    window.location.href = '{{url('/manage/weixin/user/tags/edit')}}' + '?id=' + item.id;
                },
                detail: function (item) {
                    this.customer = item;
                    window.location.href = '{{url('/manage/weixin/user/tags/detail')}}' + '?id=' + item.id;
                },
                update: function (item) {
                    var _self = this;
                    //加载数据
                    this.$http.post("{{url('/manage/weixin/user/tags/update')}}", item)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            msg('更新成功！');
                                            _self.init();
                                            return
                                        }
                                        layer.alert(JSON.stringify(response));
                                    }
                            );
                },

                sync: function () {
                    var _self = this;
                    //加载数据
                    this.$http.post("{{url('/manage/weixin/user/tags/sync')}}")
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );
                },
                remark: function (item) {
                    item.remark = 'test';
                    var _self = this;
                    //加载数据
                    this.$http.post("{{url('/manage/weixin/user/tags/remark')}}", item)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );
                },


                state: function (item) {
                    var _self = this;
                    this.role = item;
                    this.role.state = this.role.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/weixin/user/tags/edit')}}',
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
                            url: '{{url('/manage/weixin/user/tags/delete')}}',
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
