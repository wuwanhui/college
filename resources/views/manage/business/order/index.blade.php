@extends('layouts.app')

@section('content')

    <section class="content-header" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <h1>
            订单管理
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 业务中心</a></li>
            <li class="active">订单管理</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
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
                <fieldset>
                    <table class="table table-bordered table-hover  table-condensed">
                        <thead>
                        <tr style="text-align: center" class="text-center">
                            <th style="width: 20px"><input type="checkbox"
                                                           name="CheckAll" value="Checkid"/></th>
                            <th style="width: 40px;">序号</th>
                            <th style="width: 150px;">订单号</th>
                            <th style="width:150px;">往返日期</th>
                            <th style="text-align: left">团号/线路名称</th>
                            <th>客户</th>
                            <th style="width:80px;">人数</th>
                            <th style="width:80px;">应收</th>
                            <th style="width:80px;">已收</th>
                            <th style="width:80px;">未收</th>
                            <th style="width:80px;">资料</th>
                            <th style="width:80px;">状态</th>
                            <th style="width:80px;">名单</th>
                            <th style="width: 150px;">创建人</th>
                            <th style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list.data">
                            <td style="text-align: center"><input type="checkbox" v-bind:value="item.id"
                                                                  name="id" v-model="ids"/></td>
                            <td style="text-align: center" v-text="$index+1"></td>
                            <td style="text-align: center;" v-text="item.number"></td>
                            <td style="text-align: center;">@{{ item.group.departureDate }} [@{{ item.group.go_week }}]<br/><span style="color:red">@{{ item.group.backDate }} [@{{ item.group.back_week }}]</span></td>
                            <td style="text-align: left">
                                @{{ item.group.number }}<br/>
                                @{{ item.group.name }}
                            </td>
                            <td style="text-align: center" v-text="item.cusname"></td>
                            <td style="text-align: center;">@{{ item.totalCount }} <sup>@{{ item.adultCount }}大@{{ item.childCount }}小</sup></td>
                            <td style="text-align: center">@{{ item.total_amount }}</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">未齐</td>
                            <td style="text-align: center">
                                <span v-if="item.orderstatus==0" class="text-success">已确认</span>
                                <span v-else class="text-danger">待确认</span>
                            </td>
                            <td style="text-align: center">录入名单</td>
                            <td style="text-align: center">@{{ item.createName }}<br>@{{ item.created_at }}</td>
                            <td style="text-align: center">
                                <a
                                        v-on:click="signUp(item.id)">操作</a>

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
                    //加载数据
                    this.$http.get("{{url('/manage/business/group?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );
                },
                create: function () {
                    location.href = '/manage/resources/line/create';
                },
                edit: function (item) {
                    //编辑
                    location.href = '/manage/resources/line/edit?id=' + item.id;
                },
                delete: function (ids) {
                    if (ids == "") {
                        layer.msg('请选择要删除的线路！');
                        return;
                    }
                    var _self = this;
                    //删除方法
                    layer.confirm('您确认要删除选择的线路？', {
                        btn: ['确认', '取消']
                    }, function () {

                        _self.$http.post("{{url('/manage/resources/line/delete')}}", {ids: ids})
                                .then(function (response) {
                                    layer.closeAll();
                                    var _obj = response.data;
                                    if (_obj.code == 0) {
                                        //删除成功
                                        layer.msg('删除线路成功！', {offset: '2px', time: 2000});
                                        _self.init();
                                    } else {
                                        layer.alert(_obj.msg);
                                    }
                                });
                    });
                },
                search: function () {
                    this.init();
                },
                signUp: function (gid) {
                    //报名
                    location.href='{{url('/manage/business/order/signup?gid=')}}'+gid;
                }
            }
        });
    </script>
@endsection
