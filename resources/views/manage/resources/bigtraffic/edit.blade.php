@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="panel-body">
                            <fieldset>
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label class="control-label">交通航向：</label>
                                            <label><input type="radio" name="trend" value="1" v-model="bigtraffic.trend"/>去程</label>
                                            <label><input type="radio" name="trend" value="2" v-model="bigtraffic.trend"/>返程</label>
                                            <label><input type="radio" name="trend" value="3" v-model="bigtraffic.trend"/>中转</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="type" class="control-label">交通类型：</label>
                                            <label><input type="radio" name="type" value="1" v-model="bigtraffic.type"/>飞机</label>
                                            <label><input type="radio" name="type" value="2" v-model="bigtraffic.type"/>火车</label>
                                            <label><input type="radio" name="type" value="3" v-model="bigtraffic.type"/>轮船</label>
                                            <label><input type="radio" name="type" value="4" v-model="bigtraffic.type"/>汽车</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="departurePlace" class="col-sm-2 control-label">起止地：</label>
                                    <div class="col-sm-4">
                                        <input id="departurePlace" type="text" class="form-control"
                                               v-model="bigtraffic.departurePlace" placeholder="出发地 必填"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="destination" type="text" class="form-control"
                                               v-model="bigtraffic.destination" placeholder="目的地 必填"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="flightNumer" class="col-sm-2 control-label">班次号：</label>
                                    <div class="col-sm-4">
                                        <input id="flightNumer" type="text" class="form-control"
                                               v-model="bigtraffic.flightNumer"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hour" class="col-sm-2 control-label">时间：</label>
                                    <div class="col-sm-4">
                                        <input id="hour" type="number" class="form-control"
                                               v-model="bigtraffic.hour" placeholder="时"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="minute" type="number" class="form-control"
                                               v-model="bigtraffic.minute" placeholder="分"/>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="company" class="col-sm-2 control-label">所属公司：</label>
                                    <div class="col-sm-4">
                                        <input id="company" type="text" class="form-control"
                                               v-model="bigtraffic.company"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort" class="col-sm-2 control-label">排序：</label>
                                    <div class="col-sm-4">
                                        <input id="sort" type="number" class="form-control"
                                               v-model="bigtraffic.sort"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="state" class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-4">
                                        <select id="state" name="state" class="form-control" v-model="bigtraffic.state"
                                                style="width: auto;">
                                            <option value="0">正常</option>
                                            <option value="1">禁用</option>
                                        </select>
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="parent.layer.close(frameindex)">关闭
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save()">保存
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vm = new Vue({
            el: '.content',
            data: {
                bigtraffic: jsonFilter('{{json_encode($item)}}')
            },
            methods: {
                save: function () {
                    var _self = this;
                    //提交保存
                    this.$http.post("{{url('/manage/resources/bigtraffic/save')}}", _self.bigtraffic).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            parent.layer.close(frameindex);
                            parent.msg('常用大交通修改成功!');
                            parent.vm.init();
                        } else {
                            parent.layer.alert(_obj.msg, {icon: 5});
                        }
                    }, function (erro) {
                        parent.layer.alert(erro, {icon: 5});
                    });
                }

            }
        });


    </script>
@endsection

