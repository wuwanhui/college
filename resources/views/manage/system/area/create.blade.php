@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-default">
            <form enctype="multipart/form-data" class="form-horizontal"   method="POST">

                <div class="box-body">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">所属上级：</label>

                            <div class="col-md-9">
                                <input type="hidden" v-model="parent.id">
                                <span class="" v-text="parent.name"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">区域名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control auto" name="name"
                                       v-model="area.name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remark" class="col-md-3 control-label">描述：</label>

                            <div class="col-md-9">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width:100%;height:50px;"
                                                      v-model="area.remark"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
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
    </div>
@endsection
@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vue = new Vue({
            el: '.content',
            data: {
                area: {},
                parent: {}
            },
            watch: {},
            ready: function () {
                this.parent = parent.vm.parent;
            },

            methods: {
                init: function () {
                },
                submit: function () {
                    var _self = this;
                    if (_self.area.name.length == 0) {
                        return layer.msg('部门名不能为空', {icon: 5, time: 2});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/area/create')}}",
                        data: _self.area,
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
