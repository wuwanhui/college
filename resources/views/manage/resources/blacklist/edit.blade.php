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
                                    <label for="name" class="col-sm-2 control-label">姓名：</label>
                                    <div class="col-sm-4">
                                        <input id="name" type="text" class="form-control"
                                               v-model="blacklist.name" placeholder="必填"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="certType" class="col-sm-2 control-label">证件类型：</label>
                                    <div class="col-sm-4">
                                        <input id="certType" type="text" class="form-control"
                                               v-model="blacklist.certType"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="certNo" class="col-sm-2 control-label">证件号码：</label>
                                    <div class="col-sm-4">
                                        <input id="certNo" type="text" class="form-control"
                                               v-model="blacklist.certNo"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">备注说明：</label>
                                    <div class="col-sm-8">
                                                <textarea class="form-control" id="remark"
                                                          v-model="blacklist.remark"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sort" class="col-sm-2 control-label">排序：</label>
                                    <div class="col-sm-4">
                                        <input id="sort" type="number" class="form-control"
                                               v-model="blacklist.sort"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="state" class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-4">
                                        <select id="state" name="state" class="form-control" v-model="blacklist.state"
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
                blacklist: jsonFilter('{{json_encode($item)}}')
            },
            methods: {
                save: function () {
                    var _self = this;
                    //提交保存
                    this.$http.post("{{url('/manage/resources/blacklist/save')}}", _self.blacklist).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            parent.layer.close(frameindex);
                            parent.msg('黑名单修改成功!');
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

