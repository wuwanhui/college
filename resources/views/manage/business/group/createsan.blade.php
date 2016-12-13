@extends('layouts.app')

@section('content')
    <!--引用步骤样式-->
    <link href="/css/step.css" rel="stylesheet">
    <section class="content-header">
        <h1>
            增加散拼
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>资源中心</a></li>
            <li><a href="/">团期管理</a></li>
            <li class="active">增加散拼</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="breadcrumbs">
                <div class="inner">
                    <ul class="cf">
                        <li><a v-bind:class="steps=='1'?'active':''" v-on:click="changeStep(1)"><span>1</span><span>团队线路信息</span></a>
                        </li>
                        <li><a v-bind:class="steps=='2'?'active':''"
                               v-on:click="changeStep(2)"><span>2</span><span>团期计划</span></a></li>
                        <li><a v-bind:class="steps=='3'?'active':''"
                               v-on:click="changeStep(3)"><span>3</span><span>线路行程</span></a>
                        </li>
                        <li><a v-bind:class="steps=='4'?'active':''"
                               v-on:click="changeStep(4)"><span>4</span><span>其他备注</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!--线路基本信息-->
                <form class="form-horizontal" v-show="steps=='1'">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-md-2 control-label">线路名称：</label>
                                <div class="col-md-6">
                                    <div class="form-inline">
                                        <input id="name" type="text" style="width: 80%" class="form-control" value=""
                                               v-model="parentline.name" required>
                                        <button type="button" class="btn btn-warning" v-on:click="chooseLine()">选择线路
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lineclass" class="col-sm-2 control-label">线路分类：</label>
                                <div class="col-sm-2">
                                    <select id="lineclass" class="form-control" v-model="parentline.lineclass_id">
                                        <option v-for="item in lineclass" v-bind:value="item.id"
                                                v-text="item.name"></option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="days" class="col-sm-2 control-label">行程天数：</label>
                                <div class="col-sm-2">
                                    <input id="days" type="number" class="form-control"
                                           v-model="parentline.days" v-bind:value="1" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="special" class="col-sm-2 control-label">线路特色：</label>
                                <div class="col-sm-8">
                                                <textarea class="form-control" id="special"
                                                          v-model="parentline.special"
                                                          style="width:100%;height: 80px;"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="brieflyDesc" class="col-sm-2 control-label">简要描述：</label>
                                <div class="col-sm-8">
                                                <textarea class="form-control" id="brieflyDesc"
                                                          v-model="parentline.brieflyDesc"
                                                          style="width:100%;height: 80px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">
                                        <i class="fa fa-reply"></i> 返回列表
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="saveline()">保存转下一步
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--团期计划-->
                <form class="form-horizontal" v-show="steps=='2'" style="display: none;">
                    <div class="box box-primary">
                        <div class="box-body">
                            <fieldset>
                                <legend>大交通</legend>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>航向</th>
                                                    <th style="width:40px;">选择</th>
                                                    <th style="width: 100px;">交通方式</th>
                                                    <th style="width:150px;">起止地</th>
                                                    <th style="width:150px;">航班/车次</th>
                                                    <th style="width:100px;">时间</th>
                                                    <th>备注</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in group.traffic">

                                                    <td v-show="item.trend<3" style="text-align: center"><label v-text="group.traffic[$index].trendname"></label></td>
                                                    <td v-show="item.trend<3" style="text-align:center">
                                                        <input type="hidden" class="form-control"
                                                               v-model="group.traffic[$index].trend">

                                                        <button type="button" class="btn btn-sm btn-default" v-on:click="chooseTraffic($index,item.trend);">
                                                            <i class="fa fa-search"></i>
                                                        </button></td>


                                                    <td v-show="item.trend==3" style="text-align: center">
                                                        <div class="form-inline">
                                                            第<input type="number" class="form-control" style="width:80px;" v-bind:value="$index-1"
                                                                    v-model="group.traffic[$index].day">天转
                                                        </div></td>
                                                    <td v-show="item.trend==3" style="text-align: center"> <button type="button" class="btn btn-sm btn-default" v-on:click="chooseTraffic($index,item.trend);">
                                                            <i class="fa fa-search"></i>
                                                        </button></td>

                                                    <td>
                                                        <select class="form-control" v-model="group.traffic[$index].type">
                                                            <option value="1">飞机</option>
                                                            <option value="2">火车</option>
                                                            <option value="3">轮船</option>
                                                            <option value="4">汽车</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control"
                                                               v-model="group.traffic[$index].place"></td>
                                                    <td><input type="text" class="form-control" v-model="group.traffic[$index].flight"></td>
                                                    <td><input type="text" class="form-control" v-model="group.traffic[$index].time"></td>
                                                    <td><input type="text" class="form-control" v-model="group.traffic[$index].remark"></td>
                                                    <td><button v-show="item.trend==3" type="button" class="btn btn-sm btn-danger" v-on:click="deleteTransfer($index);">
                                                            <i class="fa fa-minus"></i></button></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="9"><button type="button" class="btn btn-sm btn-default" v-on:click="addTransfer(group.traffic.length);">
                                                        <i class="fa fa-plus"></i> 增加中转</button></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <legend>团队信息</legend>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">团期选择：</label>
                                    <div class="col-sm-8">
                                        <ul class="nav nav-tabs">
                                            <li role="presentation" class="active"><a href="#zd_date" role="tab"
                                                                                      data-toggle="tab"
                                                                                      v-on:click="group.tqxz=1">指定日期</a>
                                            </li>
                                            <li role="presentation"><a href="#qj_date" role="tab"
                                                                       data-toggle="tab"
                                                                       v-on:click="group.tqxz=2">区间日期</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="zd_date">
                                                <input type="text" class="form-control" v-model="group.zddate"
                                                       placeholder="选择单个或多个日期">
                                            </div>
                                            <div class="tab-pane" id="qj_date">
                                                <input type="text" style="width:49%;" class="form-control"
                                                       placeholder="选择开始日期" v-model="group.begindate">-
                                                <input type="text" style="width:49%;" class="form-control"
                                                       placeholder="选择结束日期" v-model="group.enddate">
                                                <br/>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value="1" v-model="weeks"/> 周一</label>&nbsp;
                                                    <label><input type="checkbox" value="2" v-model="weeks"/> 周二</label>&nbsp;
                                                    <label><input type="checkbox" value="3" v-model="weeks"/> 周三</label>&nbsp;
                                                    <label><input type="checkbox" value="4" v-model="weeks"/> 周四</label>&nbsp;
                                                    <label><input type="checkbox" value="5" v-model="weeks"/> 周五</label>&nbsp;
                                                    <label><input type="checkbox" value="6" v-model="weeks"/> 周六</label>&nbsp;
                                                    <label><input type="checkbox" value="0" v-model="weeks"/> 周日</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="planCount" class="col-sm-2 control-label">计划人数：</label>
                                    <div class="col-sm-2">
                                        <input id="planCount" type="number" class="form-control" value="1"
                                               v-model="group.planCount">
                                    </div>
                                    <label for="thqz" class="col-sm-2 control-label">团号前缀：</label>
                                    <div class="col-sm-2">
                                        <input id="thqz" type="text" class="form-control" value="TY-" v-model="group.thqz">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="special" class="col-sm-2 control-label">指定计调：</label>
                                    <div class="col-sm-2">
                                        <select class="form-control">
                                            <option value="">选择计调</option>
                                        </select>
                                    </div>
                                    <label for="special" class="col-sm-2 control-label">指定销售：</label>
                                    <div class="col-sm-2">
                                        <select class="form-control">
                                            <option value="">选择销售</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gatherplace" class="col-md-2 control-label">集合地：</label>
                                    <div class="col-sm-6">
                                        <input id="gatherplace" type="text" class="form-control" style="width: 80%"
                                               v-model="group.gatherplace">
                                        <button type="button" class="btn btn-default" v-on:click="chooseGatherPlace()">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">备注描述：</label>
                                    <div class="col-sm-8">
                                        <ul class="nav nav-tabs">
                                            <li role="presentation" class="active"><a href="#dlsm" role="tab"
                                                                                      data-toggle="tab">对内说明</a></li>
                                            <li role="presentation"><a href="#dwsm" role="tab"
                                                                       data-toggle="tab">对外说明</a>
                                            </li>
                                            <li role="presentation"><a href="#qtbz" role="tab"
                                                                       data-toggle="tab">其他备注</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="dlsm">
                                                                                        <textarea class="form-control"
                                                                                                  id="brieflyDesc"
                                                                                                  v-model="group.insideExplan"
                                                                                                  style="width:100%;height: 80px;"></textarea>
                                            </div>
                                            <div class="tab-pane" id="dwsm">
                                                                                        <textarea class="form-control"
                                                                                                  id="brieflyDesc"
                                                                                                  v-model="group.outsideExplan"
                                                                                                  style="width:100%;height: 80px;"></textarea>
                                            </div>
                                            <div class="tab-pane" id="qtbz">
                                                                                        <textarea class="form-control"
                                                                                                  id="brieflyDesc"
                                                                                                  v-model="group.remark"
                                                                                                  style="width:100%;height: 80px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <legend>团队价格</legend>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <table class="table table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>价格类型</th>
                                                    <th>市场价</th>
                                                    <th>同行价</th>
                                                    <th>成本价</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in group.prices">
                                                    <td><input type="text" class="form-control"
                                                               v-model="group.prices[$index].name"></td>
                                                    <td><input type="number" class="form-control"
                                                               v-model="group.prices[$index].marketPrice" number
                                                               placeholder="市场价"></td>
                                                    <td><input type="number" class="form-control"
                                                               v-model="group.prices[$index].peerPrice" number
                                                               placeholder="同行价"></td>
                                                    <td><input type="number" class="form-control"
                                                               v-model="group.prices[$index].costPrice" number
                                                               placeholder="成本价"></td>
                                                    <td><button type="button" class="btn btn-sm btn-default" v-show="$index==0"
                                                                v-on:click="insertPrice(group.prices.length)">
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
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">
                                        <i class="fa fa-reply"></i> 返回列表
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="saveGroup()">保存转下一步
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--线路行程信息-->
                <form class="form-horizontal" role="form" method="POST" v-show="steps=='3'" style="display:none">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label">行程方式：</label>
                                        <div class="col-sm-9">
                                            <label class="radio-inline">
                                                <input type="radio" checked="" value="0"
                                                       id="optionsRadios1"
                                                       name="optionsRadios" v-model="parentline.lrfs"
                                                       number>按天录入</label>
                                            <label class="radio-inline">
                                                <input type="radio" value="1" id="optionsRadios2"
                                                       name="optionsRadios" v-model="parentline.lrfs"
                                                       number>文档编辑</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div v-show="parentline.lrfs==0">

                                <div v-for="item in parentline.travels">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" v-model="parentline.travels[$index].day"
                                                           v-bind:value="$index+1"/>
                                                    <label for="name" class="col-sm-3 control-label">第 <b
                                                                style="color:red" v-text="$index+1"></b> 天：</label>
                                                    <div class="col-xs-9">
                                                        <div class="form-inline">
                                                            <input type="text" class="form-control"
                                                                   placeholder="行程概要"
                                                                   v-model="parentline.travels[$index].outline">
                                                            <input type="text" class="form-control"
                                                                   placeholder="交通"
                                                                   v-model="parentline.travels[$index].traffic">
                                                            <input type="text" class="form-control"
                                                                   placeholder="住宿"
                                                                   v-model="parentline.travels[$index].stay">
                                                            <select class="form-control"
                                                                    v-model="parentline.travels[$index].meals">
                                                                <option value="" selected="selected">选择用餐</option>
                                                                <option value="早餐">早餐</option>
                                                                <option value="早餐、午餐">早餐、午餐</option>
                                                                <option value="早餐、午餐、晚餐">早餐、午餐、晚餐</option>
                                                                <option value="午餐">午餐</option>
                                                                <option value="午餐、晚餐">午餐、晚餐</option>
                                                                <option value="晚餐">晚餐</option>
                                                                <option value="早餐、晚餐">早餐、晚餐</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-3 control-label">行程内容：</label>
                                                    <div class="col-xs-8">
                                                    <textarea class="form-control"
                                                              v-model="parentline.travels[$index].xcontent"
                                                              style="width:100%;height: 80px;"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name" class="col-sm-3 control-label">景点：</label>
                                                    <div class="col-xs-8">
                                                        <input id="name" type="text" class="form-control"
                                                               name="name"
                                                               v-model="parentline.travels[$index].scenicspot">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <button type="button" class="btn btn-xs btn-success"
                                                v-on:click="insertTravel($index)">
                                            <i class="fa fa-plus"></i> 插入
                                        </button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                v-on:click="deleteTravel($index)">
                                            <i class="fa fa-minus"></i> 删除
                                        </button>
                                    </div>
                                    <hr>
                                    <br>
                                </div>
                            </div>
                            <div v-show="parentline.lrfs==1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">行程内容：</label>
                                            <div class="col-xs-9">
                                                    <textarea class="form-control" id="xcontent" name="xcontent"
                                                              v-model="parentline.xcontent"
                                                              style="width:100%;height: 80px;"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            v-on:click="changeStep(1)">上一步
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="saveTravel()">保存转下一步
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--线路其他信息-->
                <div class="form-horizontal box box-primary " v-show="steps=='4'" style="display:none">
                    <div class="box-body">
                        {{--<legend>其他信息</legend>--}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[0].infoKey" value="费用说明"/>
                                    <label for="fysm" class="col-sm-3 control-label">费用说明：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="fysm"
                                                          v-model="parentline.otherinfo[0].infoValue"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[1].infoKey" value="服务标准"/>
                                    <label for="fwbz" class="col-sm-3 control-label">服务标准：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="fwbz"
                                                          v-model="parentline.otherinfo[1].infoValue"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[2].infoKey" value="注意事项"/>
                                    <label for="zysx" class="col-sm-3 control-label">注意事项：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="zysx"
                                                          v-model="parentline.otherinfo[2].infoValue"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[3].infoKey" value="其他备注"/>
                                    <label for="qtbz" class="col-sm-3 control-label">其他备注：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="qtbz"
                                                          v-model="parentline.otherinfo[3].infoValue"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12  text-center">
                                <button type="button" class="btn btn-default"
                                        v-on:click="changeStep(2)">上一步
                                </button>
                                <button type="button" class="btn btn-primary" v-on:click="saveOtherInfo(false)">保存
                                </button>
                                <button type="button" class="btn btn-success" v-on:click="saveOtherInfo(true)">保存并结束编辑
                                </button>

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
        //sidebar.menu = {type: 'business', item: 'sanping'};
        var vm = new Vue({
            el: '.content',
            data: {
                steps: '1', //默认第一步
                line: {days: 1},  //线路主表信息
                parentline: {travels: [], otherinfo: []},
                lineclass: [],
                group: {tqxz: 1, traffic: [], prices: [], weeks: []}, //团期计划
                weeks: [], //区间日期指定星期
                trafficIndex:0, //用于指定大交通所在的索引
                trafficType:0 //交通类型，去程或返程
            },
            created: function () {
                this.group.traffic.splice(1, 0, {trend:1,trendname:'去程'});
                this.group.traffic.splice(2, 0, {trend:2,trendname:'返程'});
                this.group.prices.splice(1, 0, {name:'成人'});
                this.group.prices.splice(2, 0, {name:'儿童'});
                this.init();
            },
            watch: {
                'parentline.days': function () {
                    var days = this.parentline.days;
                    var len = this.parentline.travels.length;
                    if (days < len) {
                        var cz = len - days;
                        //移除集合
                        this.parentline.travels.splice(days, cz);
                    }
                    if (days > len) {
                        //添加集合
                        var cz = days - len;
                        for (var i = 0; i < cz; i++) {
                            this.insertTravel(len + i - 1);
                        }
                    }
                }
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/resources/lineclass?json')}}", {params: {state: 0}})
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            _self.lineclass = _obj.data.data;
                                            return
                                        }
                                    }
                            );
                },
                deletePrice: function (index) {
                    this.group.prices.splice(index, 1); //删除团期价格项
                },
                insertPrice: function (index) {
                    this.group.prices.splice(index + 1, 0, {}); //新增团期价格项
                },
                chooseLine: function () {
                    openUrl('{{url('/manage/business/group/chooseline')}}', '选择线路', 850, 650);
                },
                chooseTraffic: function (index,type) {
                    this.trafficIndex=index;
                    this.trafficType=type;
                    openUrl('{{url('/manage/business/group/choosetraffic')}}', '选择大交通', 850, 650);
                },
                chooseGatherPlace: function () {
                    openUrl('{{url('/manage/business/group/choosegatherplace')}}', '选择集合地', 850, 650);
                },
                addTransfer:function(index){
                    //增加中转交通
                    this.group.traffic.splice(index + 1, 0, {trend:3});
                },
                deleteTransfer: function (index) {
                    this.group.traffic.splice(index, 1); //删除中转
                },
                deleteTravel: function (index) {
                    this.parentline.travels.splice(index, 1);
                    this.parentline.days = this.parentline.travels.length;
                },
                insertTravel: function (index) {
                    this.parentline.travels.splice(index + 1, 0, {});
                    this.parentline.days = this.parentline.travels.length;
                },
                changeStep: function (val) {
                    if ((val == 2||val==3||val==4) && this.group.tourline_id == null) {
                        layer.msg('请先完善团期线路基本信息！');
                        return;
                    }
                    this.steps = val;
                },
                saveline: function () {
                    //保存线路主表，基础信息
                    var _self = this;
                    this.$http.post("{{url('/manage/business/group/tourline/save')}}", JSON.stringify(_self.parentline))
                            .then(function (response) {

                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            msg('团期线路信息保存成功，请发布团期计划线路行程！', {icon: 6});
                                            _self.group.tourline_id = _obj.data.id;
                                            _self.parentline.lineid = _obj.data.id;
                                            _self.changeStep(2);
                                            return;
                                        }
                                        layer.alert(_obj.msg);
                                    }
                            );
                },
                saveTravel: function () {
                    var _self = this;
                    //保存线路行程
                    this.$http.post("{{url('/manage/business/group/tourline/travel/save')}}", _self.parentline)
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            layer.msg('线路行程保存成功！', {icon: 6});
                                            _self.line = _obj.data;
                                            _self.changeStep(3);
                                            return;
                                        }
                                        layer.alert(_obj.msg);
                                    }
                            );
                },
                saveOtherInfo: function (isover) {
                    var _self = this;
                    //保存线路其他备注说明
                    this.$http.post("{{url('/manage/business/group/tourline/otherinfo/save')}}", _self.parentline)
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            layer.msg('保存成功！', {icon: 6});
                                            if (isover) {
                                                location.href = '/manage/business/group/index';
                                            }
                                            return;
                                        }
                                        layer.alert(_obj.msg);
                                    }
                            );
                },
                saveGroup: function (isover) {
                    var _self = this;
                    _self.group.weeks = _self.weeks;
                    _self.group.name = _self.parentline.name; //团期名称就用线路名称
                    _self.group.days = _self.parentline.days; //行程天数
                    //保存团期
                    this.$http.post("{{url('/manage/business/group/save')}}", JSON.stringify(_self.group))
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            layer.msg('团期计划发布成功！', {icon: 6});
                                            if (isover) {
                                                location.href = '/manage/business/group/index';
                                            }else
                                            {
                                                _self.changeStep(3);
                                            }
                                            return;
                                        }
                                        layer.alert(_obj.msg);
                                    }
                            );
                }
            }
        });


    </script>
@endsection
