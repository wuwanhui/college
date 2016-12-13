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
                                    <label for="code" class="col-sm-2 control-label">景点代码：</label>
                                    <div class="col-sm-4">
                                        <input id="code" type="text" class="form-control"
                                               v-model="scenicspot.code" placeholder="必填"/>
                                    </div>
                                    <label for="name" class="col-sm-2 control-label">景点名称：</label>
                                    <div class="col-sm-4">
                                        <input id="name" type="text" class="form-control"
                                               v-model="scenicspot.name" placeholder="必填"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">类型：</label>
                                    <div class="col-sm-4">
                                        <input id="type" type="text" class="form-control"
                                               v-model="scenicspot.type" placeholder="基础数据中选择"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pic" class="col-sm-2 control-label">主图：</label>
                                    <div class="col-sm-10">
                                        <input id="pic" type="text" class="form-control"
                                               v-model="scenicspot.pic" placeholder="上传"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort" class="col-sm-2 control-label">排序：</label>
                                    <div class="col-sm-4">
                                        <input id="sort" type="number" class="form-control"
                                               v-model="scenicspot.sort"/>
                                    </div>
                                    <label for="state" class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-4">
                                        <select id="state" name="state" class="form-control" v-model="scenicspot.state"
                                                style="width: auto;">
                                            <option value="0" selected="selected">正常</option>
                                            <option value="1">禁用</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qq" class="col-sm-2 control-label">景点介绍：</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="remark"
                                                  v-model="scenicspot.describe"
                                                  style="width:100%;height: 80px;"></textarea>
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
                scenicspot: {}
            },
            methods: {
                save: function () {
                    var _self = this;
                    //提交保存
                    this.$http.post("{{url('/manage/resources/scenicspot/save')}}", _self.scenicspot).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            parent.layer.close(frameindex);
                            parent.msg('景点新增成功!');
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

