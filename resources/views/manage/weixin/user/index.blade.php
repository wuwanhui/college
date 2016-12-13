@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            微信关注者
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage/crm')}}"><i class="fa fa-dashboard"></i> 微信营销</a></li>
            <li class="active">微信关注者</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box search">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
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
                    <div class="box-footer " v-show="moreServch">
                        <div class="row">
                            <div class="col-md-6">
                                状态：<a v-on:click="$set('params.state',null)">全部</a><a
                                        v-bind:class="{active:params.state==key}" v-on:click="$set('params.state',key)"
                                        v-for="(key,value) in initBase.stateList" v-text="value"></a>
                            </div>
                            <div class="col-md-6">
                                类型：<a v-on:click="$set('params.type',null)">全部</a><a
                                        v-bind:class="{active:params.type==key}" v-on:click="$set('params.type',key)"
                                        v-for="(key,value) in initBase.typeList" v-text="value"></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                来源：<a v-on:click="$set('params.source',null)">全部</a><a
                                        v-bind:class="{active:params.source==key}"
                                        v-on:click="$set('params.source',key)"
                                        v-for="(key,value) in initBase.sourceList" v-text="value"></a>
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
                                    <th style="width: 60px;"><a href="">序号</a></th>
                                    <th style="width: 160px;"><a href="">昵称</a></th>
                                    <th style="width: 60px;"><a href="">性别</a></th>
                                    <th><a href="">所在地</a></th>
                                    <th style="width: 160px;"><a href="">关注时间</a></th>
                                    <th style="width: 120px;"><a href="">用户备注</a></th>
                                    <th style="width: 120px;"><a href="">是否订阅</a></th>
                                    <th style="width: 160px;"><a href="">同步时间</a></th>
                                    <th style="width: 180px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in list.data">
                                    <td><input type="checkbox"
                                               name="id" v-bind:value="item.id" v-model="ids"/></td>
                                    <td style="text-align: center" v-text="item.id"></td>
                                    <td v-bind:title="item.openid"><a v-on:click="detail(item)"
                                                                      v-text="item.nickname"></a></td>
                                    <td style="text-align: center">
                                        <span v-if="item.sex==1">男</span>
                                        <template v-else>
                                            <span v-if="item.sex==2" v-else>女</span>
                                            <span v-else>未知</span>
                                        </template>
                                    </td>
                                    <td v-text="item.province+'-'+item.city"></td>
                                    <td style="text-align: center" v-text="item.subscribe_time"></td>
                                    <td style="text-align: center">
                                        <a v-on:click="remark(item)" v-text="item.remark==''?'备注':item.remark"></a>
                                    </td>
                                    <td style="text-align: center"><a
                                                v-text="item.subscribe==0?'未关注':'已关注'"
                                                v-bind:class="{'text-warning':item.subscribe==0 }"
                                        ></a>
                                    </td>
                                    <td style="text-align: center" v-text="item.updated_at"></td>
                                    <td style="text-align: center">
                                        <a v-on:click="update(item)">更新</a>
                                        |
                                        <a href="{{url('/manage/weixin/user/follow')}}?id=@{{ item.id }}">发送</a>
                                        |
                                        <a href="{{url('/manage/weixin/user/follow')}}?id=@{{ item.id }}">绑定</a>

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
        //sidebar.menu = {type: 'weixin', item: 'user'};
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
                    this.$http.get("{{url('/manage/weixin/user?json')}}", {params: this.params})
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
                    window.location.href = '{{url('/manage/weixin/user/create')}}';
                },
                edit: function (item) {
                    this.customer = item;
                    window.location.href = '{{url('/manage/weixin/user/edit')}}' + '?id=' + item.id;
                },
                detail: function (item) {
                    this.customer = item;
                    window.location.href = '{{url('/manage/weixin/user/detail')}}' + '?id=' + item.id;
                },
                update: function (item) {
                    var _self = this;
                    //加载数据
                    this.$http.post("{{url('/manage/weixin/user/update')}}", item)
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
                    this.$http.post("{{url('/manage/weixin/user/sync')}}")
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
                    var _self = this;
                    layer.prompt({title: '输入任何备注，最多30个字符', formType: 2}, function (remark, index) {
                        item.remark = remark;
                        layer.close(index);
                        //加载数据
                        _self.$http.post("{{url('/manage/weixin/user/remark')}}", item)
                                .then(function (response) {
                                            if (response.data.code == 0) {
                                                msg('备注成功');
                                                _self.init();
                                                return;
                                            }
                                            layer.alert(JSON.stringify(response.data.data));
                                        }
                                );
                    });
                },


                state: function (item) {
                    var _self = this;
                    this.role = item;
                    this.role.state = this.role.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/weixin/user/edit')}}',
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
                            url: '{{url('/manage/weixin/user/delete')}}',
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
