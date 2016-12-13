@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            团队详情
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>业务操作</a></li>
            <li><a href="/manage/business/cost">成本管理</a></li>
            <li class="active">成本详情</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="box box-primary">

                        <div class="box-body">
                            {{ csrf_field() }}
                            <div class="col-sm-9">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">团队信息</div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-3 control-label">团队名称：</label>
                                                    <div class="col-sm-9">
                                                        <div  class="form-control" v-text="pro.name"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--线路行程信息-->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">成本信息</div>
                                    <div class="panel-body">
                                        <fieldset>
                                            <legend>签证成本</legend>
                                            <table class="table table-bordered table-hover  table-condensed">
                                                <thead>
                                                    <th style="width: 40px;">序号</th>
                                                    <th>供应商名称</th>
                                                    <th>成本金额</th>
                                                    <th>费用摘要</th>
                                                    <th style="width: 100px;">状态</th>
                                                    <th style="width: 180px;">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(item,index) in lists.data">
                                                    <td style="text-align: center"><input type="checkbox" v-bind:value="item.id"
                                                                                          name="id" v-model="ids"/></td>
                                                    <td style="text-align: center" v-text="index+1"></td>
                                                    <td style="text-align: center" v-text="item.code"></td>
                                                    <td style="text-align: center" v-text="item.name"></td>
                                                    <td style="text-align: center" v-text="item.lineclass.name"></td>
                                                    <td style="text-align: center" v-text="item.days"></td>
                                                    <td style="text-align: center" v-text="item.createName"></td>
                                                    <td style="text-align: center" v-text="item.created_at"></td>
                                                    <td style="text-align: center"
                                                        v-text="item.state | state"></td>
                                                    <td style="text-align: center" v-text="item.sort"></td>
                                                    <td style="text-align: center">
                                                        <a
                                                                v-on:click="edit(item)">编辑</a>
                                                        |
                                                        <a v-on:click="delete(item.id)">删除</a>
                                                    </td>
                                                </tr>
                                                {{--@foreach($list as $item)--}}
                                                {{--<tr>--}}

                                                {{--</tr>--}}
                                                {{--@endforeach--}}
                                                </tbody>
                                            </table>
                                        </fieldset>
                                    </div>
                                </div>

                                </div>
                            <div class="col-sm-3">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">成本操作</div>
                                    <div class="panel-body">
                                        <a class="btn btn-app" href="javascript:addCost('1','签证成本');">
                                            <span class="badge bg-blue">3</span>
                                            <i class="fa fa-cc-visa"></i> 签证成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('2','机票成本');">
                                            <span class="badge bg-green">3</span>
                                            <i class="fa fa-plane"></i> 机票成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('3','地接成本');">
                                            <span class="badge bg-purple">3</span>
                                            <i class="fa fa-coffee"></i> 地接成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('4','领队成本');">
                                            <span class="badge bg-yellow">3</span>
                                            <i class="fa fa-map-o"></i> 领队成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('5','火车票成本');">
                                            <span class="badge bg-red">3</span>
                                            <i class="fa fa-train"></i> 火车票成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('6','餐费成本');">
                                            <span class="badge bg-pink">3</span>
                                            <i class="fa fa-cutlery"></i> 餐费成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('7','车费成本');">
                                            <span class="badge bg-blue">300</span>
                                            <i class="fa fa-car"></i> 车费成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('8','酒店成本');">
                                            <span class="badge bg-green">891</span>
                                            <i class="fa fa-hotel"></i> 酒店成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('9','订票成本');">
                                            <span class="badge bg-purple">67</span>
                                            <i class="fa fa-ticket"></i> 订票成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('10','名单成本');">
                                            <span class="badge bg-yellow">12</span>
                                            <i class="fa fa-list-alt"></i> 名单成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('11','口岸成本');">
                                            <span class="badge bg-red">531</span>
                                            <i class="fa fa-home"></i> 口岸成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('12','转交团成本');">
                                            <span class="badge bg-pink">531</span>
                                            <i class="fa fa-exchange"></i> 转交团成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('13','保险成本');">
                                            <span class="badge bg-blue">531</span>
                                            <i class="fa fa-building-o"></i> 保险成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('14','购物成本');">
                                            <span class="badge bg-green">531</span>
                                            <i class="fa fa-shopping-cart"></i> 购物成本
                                        </a>
                                        <a class="btn btn-app" href="javascript:addCost('15','附加成本');">
                                            <span class="badge bg-purple">531</span>
                                            <i class="fa fa-heart-o"></i> 附加成本
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">返回
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save">保存</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script type="application/javascript">

        var vm = new Vue({
            el: '.content',
            data: {
                lrfs: false,
                loading: true,
                costs: [],
                pro:{},
            },
            watch: {},
            methods: {
                init: function () {
                    var _self = this;
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/business/cost?json')}}",
                        data: _self.params,
                        success: function (_obj){

                            layer.closeAll();
                            if (_obj.code == 0) {
//                                //获取成功
                                _self.costs = _obj.data.data;

                                _self.pro=_obj.data.pro;
                            } else {
                                layer.alert(_obj.msg);
                            }
                        }
                    });
                }
            }
        });

        vm.init();
        function addCost(lx,title) {
            openUrl('{{url('/manage/business/cost/create/')}}?lx=' + lx+'&pid=1', title,'800','800');
        }
    </script>
@endsection
