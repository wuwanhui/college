@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form enctype="multipart/form-data" class="form-horizontal" dept="form" method="POST">

                        <div class="panel-body">
                            <div class="col-xs-12">
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label for="name" class="col-md-3 control-label">部门名称：</label>

                                        <div class="col-md-9">
                                            <input id="name" type="text" class="form-control auto" name="name"
                                                   v-model="dept.name" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="remark" class="col-md-3 control-label">描述：</label>

                                        <div class="col-md-9">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%,height:50px;"
                                                      v-model="dept.remark"></textarea>
                                        </div>
                                    </div>
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
                dept: {}
            },
            watch: {},

            methods: {
                init: function () {
                },
                submit: function () {
                    var _self = this;
                    if (_self.dept.name.length == 0) {
                        return layer.msg('部门名不能为空', {icon: 5, time: 2});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/dept/create')}}",
                        data: _self.dept,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                parent.layer.close(frameindex);
                                parent.layer.msg(_obj.msg, {icon: 6});
                                parent.vue.init();
                            } else {
                                parent.layer.msg(_obj.msg, {icon: 5});
                            }
                        }
                    });
                }

            }
        });
        vue.init();
    </script>
@endsection
