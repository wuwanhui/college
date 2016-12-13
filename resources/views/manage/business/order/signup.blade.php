@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            订单管理
            <small>收客报名</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>资源中心</a></li>
            <li><a href="/manage/business/order">订单管理</a></li>
            <li class="active">收客报名</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <input type="hidden" v-model="order.group_id">
                    <div class="box box-primary">
                        <div class="box-body">
                            <fieldset>
                                <legend>团队信息</legend>
                                <table class="table table-bordered detail">
                                    <tbody>
                                    <tr>
                                        <th>团队编号:</th>
                                        <td v-text="group.number"></td>
                                        <th>线路名称:</th>
                                        <td v-text="group.name"></td>
                                        <th>行程天数:</th>
                                        <td v-text="tourline.days"></td>
                                    </tr>
                                    <tr>
                                        <th>出团日期:</th>
                                        <td v-text="group.departureDate"></td>
                                        <th>回团日期:</th>
                                        <td v-text="group.backDate"></td>
                                        <th>集合地:</th>
                                        <td v-text="group.gatherplace"></td>
                                    </tr>
                                    <tr>
                                        <th>剩余人数：</th>
                                        <td v-text="group.planCount"></td>
                                        <th>大交通：</th>
                                        <td colspan="3">
                                            @{{ goTraffic.type | type_cn }}去：@{{ goTraffic.place }}(@{{ goTraffic.flight }} @{{ goTraffic.time }})
                                            @{{ backTraffic.type | type_cn }}回：@{{ backTraffic.place }}(@{{ backTraffic.flight }} @{{ backTraffic.time }})
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                            <fieldset>
                                <legend>预定信息</legend>
                                <div class="form-group">
                                    <label for="header" class="col-sm-2 control-label">客户：</label>
                                    <div class="col-sm-3">
                                        <input type="hidden" v-model="order.customer_id"/>
                                        <input id="cusname" type="text" class="form-control"
                                               v-model="order.cusname" readonly="readonly" style="width: 85%;">
                                        <button type="button" class="btn btn-default" v-on:click="chooseCus()">
                                            <i class="fa fa-search"></i></button>
                                    </div>
                                    <label for="header" class="col-sm-1 control-label">联系人：</label>
                                    <div class="col-sm-1">
                                        <input id="linkman" type="text" class="form-control"
                                               v-model="order.linkman" placeholder="姓名">
                                    </div>
                                    <div class="col-sm-2">
                                        <input id="linkmanPhone" type="text" class="form-control"
                                               v-model="order.linkmanPhone" placeholder="联系电话">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="extnumber" class="col-sm-2 control-label">业务单号：</label>
                                    <div class="col-sm-3">
                                        <input id="extnumber" type="text" class="form-control"
                                               v-model="order.extnumber" placeholder="其他业务系统订单号">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adultCount" class="col-sm-2 control-label">报名人数：</label>
                                    <div class="col-sm-8">
                                        <div class="form-inline">
                                            <input id="adultCount" type="number" class="form-control"
                                                   v-model="order.adultCount" number style="width: 80px;">
                                            <label>成人</label>
                                            <input type="number" class="form-control"
                                                   v-model="order.childCount" number style="width: 80px;">
                                            <label>儿童（占床）</label>
                                            <input type="number" class="form-control"
                                                   v-model="order.childNobedCount" number style="width: 80px;">
                                            <label>儿童（不占床）</label>
                                            <input id="guidCount" type="number" class="form-control"
                                                   v-model="order.guidCount" number style="width: 80px;">
                                            <label>领队=总人数</label>
                                            <input id="totalCount" type="number" class="form-control"
                                                    v-model="totalCount" style="width: 80px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="adultCount" class="col-sm-2 control-label">报名状态：</label>
                                    <div class="col-sm-8">
                                        <label><input type="radio" name="status" v-model="order.orderStatus" value="1" checked>占位</label>
                                        <label><input type="radio" name="status" v-model="order.orderStatus" value="0">已确认</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fax" class="col-sm-2 control-label">结算明细：</label>
                                    <div class="col-sm-8">
                                        <table class="table table-bordered table-condensed">
                                            <thead>
                                            <tr>
                                                <th>结算项目</th>
                                                <th>计划单价</th>
                                                <th>实收单价</th>
                                                <th>数量</th>
                                                <th>结算合计</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="item in order.prices">
                                                <td><input type="text" class="form-control"
                                                           v-model="order.prices[$index].name"></td>
                                                <td><input type="number" class="form-control"
                                                           v-model="order.prices[$index].planPrice" v-bind:value="item.marketPrice"></td>
                                                <td><input type="number" class="form-control"
                                                           v-model="order.prices[$index].price" number v-on:blur="computeAmount($index)"></td>
                                                <td><input type="number" class="form-control"
                                                           v-model="order.prices[$index].count" number v-on:blur="computeAmount($index)"></td>
                                                <td><input type="number" class="form-control"
                                                           v-model="order.prices[$index].totalAmount" number readonly="readonly"></td>

                                                <td><button type="button" class="btn btn-sm btn-default" v-show="$index==0"
                                                            v-on:click="insertPrice(order.prices.length)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" v-show="$index>0"
                                                            v-on:click="deletePrice($index)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>其他</legend>
                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">订单备注：</label>
                                    <div class="col-sm-8">
                                                <textarea class="form-control" id="remark"
                                                          v-model="order.remark"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="otherRemark" class="col-sm-2 control-label">其他备注：</label>
                                    <div class="col-sm-8">
                                                <textarea class="form-control" id="remark"
                                                          v-model="order.otherRemark"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="special" class="col-sm-2 control-label">销售人员：</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" v-model="order.seller">
                                            <option value="0">选择销售</option>
                                        </select>
                                    </div>
                                    <label for="special" class="col-sm-2 control-label">责任计调：</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" v-model="order.operator">
                                            <option value="0">选择计调</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">
                                        <i class="fa fa-reply"></i> 返回列表
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save()"><i
                                                class="fa fa-save"></i> 提交报名
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @{{ order|json }}
    </section>


@endsection

@section('script')
    <script type="application/javascript">
        Vue.filter("type_cn", function(value) {   //
            if(value==1) return '飞机';
            if(value==2) return '火车';
            if(value==3) return '轮船';
            if(value==4) return '汽车';
        });
        var vm = new Vue({
            el: '.content',
            data: {
                order:{prices:[],adultCount:0,childCount:0,childNobedCount:0,guidCount:0,rosters:[]},
                group:jsonFilter('{{json_encode($group)}}'),
                tourline:jsonFilter('{{json_encode($group->tourline)}}'),
                goTraffic:jsonFilter('{{json_encode($group->traffics->where('trend','1')->first())}}'),
                backTraffic:jsonFilter('{{json_encode($group->traffics->where('trend','2')->first())}}'),
                groupPrices:jsonFilter('{{json_encode($group->prices)}}')
            }
            ,created:function(){
                this.order.prices=this.groupPrices;
                this.order.group_id=this.group.id;
            },computed:{
                //计算总人数
                totalCount:function(){
                    var total=this.order.adultCount+this.order.childCount+this.order.childNobedCount+this.order.guidCount;
                    vm.$set('order.totalCount',total);
                    return total;
                }
            }
            ,
            methods: {
                save: function () {
                    var _self = this;
                    this.$http.post("{{url('/manage/business/order/save')}}", _self.order).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            msg(_obj.msg);
                            location.href = '{{url('/manage/business/order')}}';
                        } else {
                            layer.alert(_obj.msg, {icon: 5});
                        }
                    }, function (erro) {
                        layer.alert(erro, {icon: 5});
                    });
                },
                chooseCus: function () {
                    //选择客户
                    openUrl('{{url('/manage/business/order/choosecus')}}', '选择客户', 850, 650);
                },
                deletePrice: function (index) {
                    this.order.prices.splice(index, 1); //删除价格项
                },
                insertPrice: function (index) {
                    this.order.prices.splice(index + 1, 0, {}); //新增价格项
                },
                computeAmount:function(index){
                    //计算单行合计
                    var price=this.order.prices[index].price; //单价
                    var count=this.order.prices[index].count; //数量
                    var total=price*count;
                    vm.$set('order.prices['+index+'].totalAmount',total);
                }

            }
        });
    </script>
@endsection

