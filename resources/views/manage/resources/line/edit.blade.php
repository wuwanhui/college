@extends('layouts.app')

@section('content')
    <!--引用步骤样式-->
    <link href="/css/step.css" rel="stylesheet">
    <section class="content-header">
        <h1>
            编辑线路
            <small>修改线路信息，以便发布团期时直接调用</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>资源中心</a></li>
            <li><a href="/manage/resources/line">线路管理</a></li>
            <li class="active">编辑线路</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="breadcrumbs">
                <div class="inner">
                    <ul class="cf">
                        <li><a v-bind:class="steps=='1'?'active':''" v-on:click="changeStep(1)"><span>1</span><span>线路基本信息</span></a>
                        </li>
                        <li><a v-bind:class="steps=='2'?'active':''" v-on:click="changeStep(2)"><span>2</span><span>线路行程介绍</span></a>
                        </li>
                        <li><a v-bind:class="steps=='3'?'active':''" v-on:click="changeStep(3)"><span>3</span><span>其他备注说明</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!--线路基本信息-->
                <form class="form-horizontal" v-show="steps=='1'">
                    <input type="hidden" v-model="line.id" value="{{$line->id}}"/>
                    <input type="hidden" v-model="parentline.lineid" value="{{$line->id}}"/>
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="lineclass" class="col-sm-2 control-label">线路分类：</label>
                                <div class="col-sm-3">
                                    <select id="lineclass" class="form-control" v-model="line.lineclass_id">
                                        <option v-for="item in lineclass" v-bind:value="item.id"
                                                v-text="item.name"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">线路编码：</label>
                                <div class="col-sm-3">
                                    <input id="code" type="text" class="form-control" value="{{$line->code}}"
                                           v-model="line.code" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-2 control-label">线路名称：</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" value="{{$line->name}}"
                                           v-model="line.name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pic" class="col-sm-2 control-label">线路主图：</label>
                                <div class="col-sm-8">
                                    <input id="pic" type="text" class="form-control" value="{{$line->pic}}"
                                           v-model="line.pic" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="special" class="col-sm-2 control-label">行程特色：</label>
                                <div class="col-sm-8">
                                                <textarea class="form-control" id="special"
                                                          v-model="line.special"
                                                          style="width:100%;height: 80px;">{{$line->special}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="brieflyDesc" class="col-sm-2 control-label">简要描述：</label>
                                <div class="col-sm-8">
                                                <textarea class="form-control" id="brieflyDesc"
                                                          v-model="line.brieflyDesc"
                                                          style="width:100%;height: 80px;">{{$line->brieflyDesc}}</textarea>
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
                                    <button type="button" class="btn  btn-primary" v-on:click="saveline()">
                                        <i class="fa fa-save"></i> 保存转下一步
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--线路行程信息-->
                <form class="form-horizontal" role="form" method="POST" v-show="steps=='2'" style="display:none">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="days" class="col-sm-2 control-label">行程天数：</label>
                                        <div class="col-sm-2">
                                            <input id="days" type="number" class="form-control"
                                                   v-model="parentline.days" v-bind:value="1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">行程方式：</label>
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
                            <br>
                            <div v-show="parentline.lrfs==0">

                                <div v-for="item in parentline.travels">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" v-model="parentline.travels[$index].day"
                                                           v-bind:value="$index+1" number/>
                                                    <label for="name" class="col-sm-2 control-label">第 <b
                                                                style="color:red" v-text="$index+1"></b> 天：</label>
                                                    <div class="col-xs-9">
                                                        <div class="form-inline">
                                                            <input type="text" class="form-control"
                                                                   placeholder="行程概要"
                                                                   v-model="parentline.travels[$index].outline"
                                                            >
                                                            <input type="text" class="form-control"
                                                                   placeholder="交通"
                                                                   v-model="parentline.travels[$index].traffic">
                                                            <input type="text" class="form-control"
                                                                   placeholder="住宿"
                                                                   v-model="parentline.travels[$index].stay">
                                                            <select class="form-control"
                                                                    v-model="parentline.travels[$index].meals">
                                                                <option value="">选择用餐</option>
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
                                                    <label class="col-sm-2 control-label">行程内容：</label>
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
                                                    <label for="name" class="col-sm-2 control-label">景点：</label>
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
                                            <label class="col-sm-3 control-label">行程内容：</label>
                                            <div class="col-xs-9">
                                                    <textarea class="form-control"
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
                <div class="form-horizontal box box-primary " v-show="steps=='3'" style="display:none">
                    <div class="box-body">
                        {{--<legend>其他信息</legend>--}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[0].infoKey" value="费用说明"/>
                                    <label for="fysm" class="col-sm-2 control-label">费用说明：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="fysm"
                                                          v-model="parentline.otherinfo[0].infoValue"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[1].infoKey" value="服务标准"/>
                                    <label for="fwbz" class="col-sm-2 control-label">服务标准：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="fwbz"
                                                          v-model="parentline.otherinfo[1].infoValue" v-text=""
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[2].infoKey" value="注意事项"/>
                                    <label for="zysx" class="col-sm-2 control-label">注意事项：</label>
                                    <div class="col-sm-9">
                                                <textarea class="form-control" id="zysx"
                                                          v-model="parentline.otherinfo[2].infoValue"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" v-model="parentline.otherinfo[3].infoKey" value="其他备注"/>
                                    <label for="qtbz" class="col-sm-2 control-label">其他备注：</label>
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
        //sidebar.menu = {type: 'resources', item: 'line'};
        var vm = new Vue({
            el: '.content',
            data: {
                steps: '1', //默认第一步
                line: {days: 0},  //线路主表信息
                parentline: {travels: [], otherinfo: []},
                lineclass: [],
            },
            created: function () {
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
                    this.$http.get("{{url('/manage/resources/lineclass?json')}}", {params: _self.params})
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            //获取成功
                                            _self.lineclass = _obj.data.data;
                                            //给线路分类赋值
                                            _self.line.lineclass_id = '{{$line->lineclass_id}}';
                                        }
                                    }
                            );
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
                    if (val == 2) {
                        if (this.line.days == 0) {
                            //需要加载行程线路
                            var arrEntities = {'lt': '<', 'gt': '>', 'nbsp': ' ', 'amp': '&', 'quot': '"'};
                            var travels = '{{$line->travels}}';
                            travels = travels.replace(/&(lt|gt|nbsp|amp|quot);/ig, function (all, t) {
                                return arrEntities[t];
                            });
                            this.parentline.travels = JSON.parse(travels);
                            this.line.days = '{{$line->days}}';
                            var lrfs = '{{$line->lrfs}}';
                            if (lrfs == 0) {
                                this.parentline.days = this.parentline.travels.length;
                            } else {
                                this.parentline.days = '{{$line->days}}';
                            }
                            this.$set('parentline.lrfs', lrfs);
                            this.$set('parentline.xcontent', '{{$line->xcontent}}');
                        }
                    }
                    if (val == 3) {
                        if ('{{$line->otherinfo}}'.length > 2) {
                            //需要加载行程线路
                            var arrEntities = {'lt': '<', 'gt': '>', 'nbsp': ' ', 'amp': '&', 'quot': '"'};
                            var otherinfo = '{{$line->otherinfo}}';
                            otherinfo = otherinfo.replace(/&(lt|gt|nbsp|amp|quot);/ig, function (all, t) {
                                return arrEntities[t];
                            });
                            this.parentline.otherinfo = JSON.parse(otherinfo);
                        }
                    }
                    this.steps = val;
                },
                saveline: function () {
                    //保存线路主表，基础信息
                    var _self = this;
                    this.$http.post("{{url('/manage/resources/line/line/save')}}", _self.line)
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            layer.msg('线路基本信息保存成功，请编辑线路行程！', {icon: 6});
                                            _self.line.id = _obj.data.id;
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
                    this.$http.post("{{url('/manage/resources/line/travel/save')}}", _self.parentline)
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
                    this.$http.post("{{url('/manage/resources/line/otherinfo/save')}}", _self.parentline)
                            .then(function (response) {
                                        var _obj = response.data;
                                        if (_obj.code == 0) {
                                            layer.msg('线路信息全部保存成功！', {icon: 6});
                                            if (isover) {
                                                location.href = '/manage/resources/line';
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
