@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <form enctype="multipart/form-data" class="form-horizontal" dept="form" method="POST">
                        <input type="hidden" name="product_id" v-model="cost.product_id" value="{{$parm['pid']}}">
                        <input type="hidden" name="costType" v-model="cost.costType" value="{{$parm['lx']}}">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <fieldset>
                                    <legend>基本信息</legend>

                                    <div class="form-group">
                                        <label for="supply_id" class="col-sm-2 control-label">供应商：</label>
                                        <div class="col-sm-9">
                                            <select id="supply_id" class="form-control"
                                                    v-model="cost.supply_id">
                                                <option value="1" selected="selected">公摊</option>
                                                <option value="2">非公摊</option>
                                                <option value="3">指定订单</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="feeType" class="col-sm-2 control-label">费用类型：</label>
                                        <div class="col-sm-3">
                                            <select id="feeType" class="form-control"
                                                    v-model="cost.feeType" v-on:change="Change();">
                                                <option value="1" selected="selected">公摊</option>
                                                <option value="2">非公摊</option>
                                                <option value="3">指定订单</option>
                                            </select>
                                        </div>
                                        <label for="order_id" v-if="willShow"
                                               class="col-sm-2 control-label">所属订单：</label>
                                        <div class="col-sm-3" v-if="willShow">
                                            <input id="order_id" type="text" class="form-control auto " name="name"
                                                   v-model="cost.order_id" required autofocus>
                                        </div>
                                    </div>
                                    {{--签证--}}
                                    @if ($parm['lx'] == 1)
                                        <div class="form-group">
                                            <label for="visaType" class="col-sm-2 control-label">签证类型：</label>
                                            <div class="col-sm-3">
                                                <select id="visaType" class="form-control"
                                                        v-model="cost.subCost.visaType">
                                                    <option value="1" selected="selected">公摊</option>
                                                    <option value="2">非公摊</option>
                                                    <option value="3">指定订单</option>
                                                </select>
                                            </div>
                                            <label for="visaItem"
                                                   class="col-sm-2 control-label">签证项目：</label>
                                            <div class="col-sm-3">
                                                <select id="visaItem" class="form-control"
                                                        v-model="cost.subCost.visaItem">
                                                    <option value="1" selected="selected">公摊</option>
                                                    <option value="2">非公摊</option>
                                                    <option value="3">指定订单</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="visaInTime" class="col-sm-2 control-label">入证时间：</label>

                                            <div class="col-sm-3">
                                                <input id="visaInTime" type="text" class="form-control auto" name="name"
                                                       v-model="cost.subCost.visaInTime" required autofocus>
                                            </div>
                                            <label for="visaOutTime" class="col-sm-3 control-label">出证时间：</label>

                                            <div class="col-sm-3">
                                                <input id="visaOutTime" type="text" class="form-control auto"
                                                       name="name"
                                                       v-model="cost.subCost.visaOutTime" required autofocus>
                                            </div>
                                        </div>
                                        {{--机票--}}
                                    @elseif ($parm['lx'] == 2)
                                        <div class="form-group">
                                            <label for="planeState" class="col-sm-2 control-label">机票状态：</label>
                                            <div class="col-sm-3">
                                                <select id="planeState" class="form-control"
                                                        v-model="cost.subCost.planeState">
                                                    <option value="已出" selected="selected">已出</option>
                                                    <option value="未出">未出</option>
                                                    <option value="已退">已退</option>
                                                    <option value="未退">未退</option>
                                                </select>
                                            </div>
                                            <label for="departureCity"
                                                   class="col-sm-2 control-label">出发城市：</label>
                                            <div class="col-sm-3">
                                                <input id="departureCity" type="text" class="form-control auto "
                                                       name="name"
                                                       v-model="cost.subCost.departureCity" required autofocus>
                                            </div>
                                        </div>
                                        {{--火车票--}}
                                    @elseif ($parm['lx'] == 5)
                                        <div class="form-group">
                                            <label for="costType" class="col-sm-2 control-label">经办方式：</label>
                                            <div class="col-sm-3">
                                                <select id="costType" class="form-control"
                                                        v-model="cost.subCost.costType">
                                                    <option value="总部" selected="selected">总部</option>
                                                    <option value="外办">外办</option>
                                                </select>
                                            </div>
                                            <label for="section"
                                                   class="col-sm-2 control-label">路段：</label>
                                            <div class="col-sm-3">
                                                <input id="section" type="text" class="form-control auto " name="name"
                                                       v-model="cost.subCost.section" required autofocus>
                                            </div>
                                        </div>
                                        {{--餐费--}}
                                    @elseif ($parm['lx'] == 6)
                                        <div class="form-group">
                                            <label for="payTime"
                                                   class="col-sm-2 control-label">消费时间：</label>
                                            <div class="col-sm-3">
                                                <input id="payTime" type="text" class="form-control auto "
                                                       name="payTime"
                                                       v-model="cost.subCost.payTime" required autofocus>
                                            </div>
                                        </div>
                                        {{--车费成本--}}
                                    @elseif ($parm['lx'] == 7)
                                        <div class="form-group">
                                            <label for="useDate"
                                                   class="col-sm-2 control-label">用车日期：</label>
                                            <div class="col-sm-3">
                                                <input id="useDate" type="text" class="form-control auto "
                                                       name="useDate"
                                                       v-model="cost.subCost.useDate" required autofocus>
                                            </div>
                                            <label for="guideInfo"
                                                   class="col-sm-3 control-label">导游：</label>
                                            <div class="col-sm-3">
                                                <input id="guideInfo" type="text" class="form-control auto "
                                                       name="guideInfo"
                                                       v-model="cost.subCost.guideInfo" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="placeOne"
                                                   class="col-sm-2 control-label">约定地点：</label>
                                            <div class="col-sm-3">
                                                <input id="placeOne" type="text" class="form-control auto "
                                                       name="placeOne"
                                                       v-model="cost.subCost.placeOne" required autofocus>
                                            </div>
                                            <label for="placeTwo"
                                                   class="col-sm-3 control-label">送团地点：</label>
                                            <div class="col-sm-3">
                                                <input id="placeTwo" type="text" class="form-control auto "
                                                       name="placeTwo"
                                                       v-model="cost.subCost.placeTwo" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lineInfo" class="col-sm-2 control-label">线路：</label>
                                            <div class="col-sm-9">
                                                <input id="lineInfo" type="text" class="form-control auto"
                                                       name="lineInfo"
                                                       v-model="cost.subCost.lineInfo" required autofocus
                                                       style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="plateNumber"
                                                   class="col-sm-2 control-label">车牌号：</label>
                                            <div class="col-sm-3">
                                                <input id="plateNumber" type="text" class="form-control auto "
                                                       name="plateNumber"
                                                       v-model="cost.subCost.plateNumber" required autofocus>
                                            </div>
                                            <label for="carType"
                                                   class="col-sm-3 control-label">车型：</label>
                                            <div class="col-sm-3">
                                                <input id="carType" type="text" class="form-control auto "
                                                       name="carType"
                                                       v-model="cost.subCost.carType" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact"
                                                   class="col-sm-2 control-label">联系人：</label>
                                            <div class="col-sm-3">
                                                <input id="contact" type="text" class="form-control auto "
                                                       name="contact"
                                                       v-model="cost.subCost.contact" required autofocus>
                                            </div>
                                            <label for="driver"
                                                   class="col-sm-3 control-label">司机：</label>
                                            <div class="col-sm-3">
                                                <input id="driver" type="text" class="form-control auto " name="driver"
                                                       v-model="cost.subCost.driver" required autofocus>
                                            </div>
                                        </div>
                                        {{--酒店--}}
                                    @elseif ($parm['lx'] == 8)
                                        <div class="form-group">
                                            <label for="inDate"
                                                   class="col-sm-2 control-label">入住日期：</label>
                                            <div class="col-sm-3">
                                                <input id="inDate" type="text" class="form-control auto " name="inDate"
                                                       v-model="cost.subCost.inDate" required autofocus>
                                            </div>
                                            <label for="outdate"
                                                   class="col-sm-3 control-label">离店日期：</label>
                                            <div class="col-sm-3">
                                                <input id="outdate" type="text" class="form-control auto "
                                                       name="outdate"
                                                       v-model="cost.subCost.outdate" required autofocus>
                                            </div>
                                        </div>
                                        {{--订票--}}
                                    @elseif ($parm['lx'] == 9)
                                        <div class="form-group">
                                            <label for="bookDate"
                                                   class="col-sm-2 control-label">订票日期：</label>
                                            <div class="col-sm-3">
                                                <input id="bookDate" type="text" class="form-control auto "
                                                       name="bookDate"
                                                       v-model="cost.subCost.bookDate" required autofocus>
                                            </div>
                                            <label for="takeDate"
                                                   class="col-sm-3 control-label">取票日期：</label>
                                            <div class="col-sm-3">
                                                <input id="takeDate" type="text" class="form-control auto "
                                                       name="takeDate"
                                                       v-model="cost.subCost.takeDate" required autofocus>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="section"
                                                   class="col-sm-2 control-label">起点终点：</label>
                                            <div class="col-sm-3">
                                                <input id="section" type="text" class="form-control auto "
                                                       name="section"
                                                       v-model="cost.subCost.section" required autofocus>
                                            </div>
                                            <label for="serviceTime"
                                                   class="col-sm-3 control-label">班次时间：</label>
                                            <div class="col-sm-3">
                                                <input id="serviceTime" type="text" class="form-control auto "
                                                       name="serviceTime"
                                                       v-model="cost.subCost.serviceTime" required autofocus>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="settleType" class="col-sm-2 control-label">结算方式：</label>
                                        <div class="col-sm-9">
                                            <select id="settleType" class="form-control"
                                                    v-model="cost.settleType">
                                                <option value="周结" selected="selected">周结</option>
                                                <option value="月结">月结</option>
                                                <option value="现付">现付</option>
                                                <option value="半月结">半月结</option>
                                                <option value="支付宝">支付宝</option>
                                                <option value="微信">微信</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="abstract" class="col-sm-2 control-label">费用摘要：</label>
                                        <div class="col-sm-9">
                                            <input id="abstract" type="text" class="form-control auto" name="abstract"
                                                   v-model="cost.abstract" required autofocus style="width: 100%;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="remark" class="col-sm-2 control-label">备注说明：</label>

                                        <div class="col-sm-9">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%,height:50px;" name="remark"
                                                      v-model="cost.remark"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-xs-12">
                                <fieldset>
                                    <legend>费用信息</legend>
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                        <th>费用名称</th>
                                        <th>费用金额</th>
                                        <th>费用数量</th>
                                        <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for='(opdtIndex,price) in cost.pricelist'>
                                            <tr>
                                                <td width="50%">
                                                    <input id="costName" type="text" class="form-control auto "
                                                           name="costName"
                                                           v-model="price.costName" required style="width: 100%; background-color: #fff; border: 1px solid silver">
                                                </td>
                                                <td width="20%">
                                                    <input id="costAmount" type="text" class="form-control auto "
                                                           name="costAmount"
                                                           v-model="price.costAmount" required autofocus style="width: 100%;background-color: #fff; border: 1px solid silver">
                                                </td>
                                                <td width="20%">
                                                    <input id="costCount" type="text" class="form-control auto "
                                                           name="costCount"
                                                           v-model="price.costCount" required autofocus style="width: 100%;background-color: #fff; border: 1px solid silver">
                                                </td>
                                                <td width="10%" style="text-align: center; padding-top: 13px;">

                                                    <a href="javascript:;" v-if='opdtIndex==0' v-on:click='addNewSubjectFun()' class="fa fa-plus"></a>
                                                    <a href="javascript:;" v-if='opdtIndex>0' @click='deleteSubjectFun(opdtIndex)' class="fa fa-minus"></a>
                                                    {{--fa-minus--}}
                                                </td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="parent.layer.close(frameindex)">关闭
                                    </button>
                                    <button type="submit" class="btn  btn-primary" v-on:click="submit()">保存</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include("common.success")
                @include("common.errors")
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vue = new Vue({
            el: '.content',
            data: {
                cost: {subCost: {},pricelist:[{}]},
                willShow: false
            },
            watch: {},

            methods: {
                init: function () {
                },
                submit: function () {
                    var _self = this;
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/business/cost/create')}}",
                        data: _self.cost,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
//                            if (_obj.code == 0) {
//                                parent.layer.close(frameindex);
//                                parent.layer.msg(_obj.msg, {icon: 6});
//                                parent.vm.init();
//                            } else {
//                                parent.layer.msg(_obj.msg, {icon: 5});
//                            }
                        }
                    });
                },
                Change: function () {
                    var _self = this;
                    if (_self.cost.feeType == 3) {
                        this.willShow = true;
                    } else {
                        this.willShow = false
                    }
                },
                addNewSubjectFun: function () {
                    var _self = this;
                    _self.cost.pricelist.push({});
                },deleteSubjectFun: function(index) {
                    this.cost.pricelist.splice(index, 1);
                },
            }
        });
        vue.init();
    </script>

@endsection
