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
                                    <label for="name" class="col-sm-2 control-label">集合地点：</label>
                                    <div class="col-sm-4">
                                        <input id="name" type="text" class="form-control"
                                               v-model="gatherplace.name" placeholder="必填"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cardNumer" class="col-sm-2 control-label">集合时间：</label>
                                    <div class="col-sm-4">
                                        <input id="time" type="text" class="form-control"
                                               v-model="gatherplace.time"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bankCode" class="col-sm-2 control-label">出发城市：</label>
                                    <div class="col-sm-4">
                                        <input id="departureCity" type="text" class="form-control"
                                               v-model="gatherplace.departureCity"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort" class="col-sm-2 control-label">排序：</label>
                                    <div class="col-sm-4">
                                        <input id="sort" type="number" class="form-control"
                                               v-model="gatherplace.sort"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="state" class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-4">
                                        <select id="state" name="state" class="form-control" v-model="gatherplace.state"
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
                gatherplace: jsonFilter('{{json_encode($item)}}')
            },
            methods: {
                save: function () {
                    var _self = this;
                    //提交保存
                    this.$http.post("{{url('/manage/resources/gatherplace/save')}}", _self.gatherplace).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            parent.layer.close(frameindex);
                            parent.msg('常用集合地修改成功!');
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

