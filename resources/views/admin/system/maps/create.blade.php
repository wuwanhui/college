@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="box box-primary">
            <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">参数名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="mapItem.name" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-md-3 control-label">分类：</label>

                            <div class="col-md-9">
                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapItem.type">
                                    <option v-bind:value="key" v-for="(key,value) in typeList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="control" class="col-md-3 control-label">控件类型：</label>

                            <div class="col-md-9">

                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapItem.control">
                                    <option v-bind:value="key"
                                            v-for="(key,value) in controlList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">标识：</label>

                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control" name="code"
                                       v-model="mapItem.code">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="default" class="col-md-3 control-label">参考值：</label>

                            <div class="col-md-9">
                                <input id="default" type="text" class="form-control" name="default"
                                       v-model="mapItem.default">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer text-center">
                    <button type="button" class="btn btn-default"
                            onclick="parent.layer.close(frameindex)">关闭
                    </button>
                    <button type="button" class="btn  btn-primary" v-on:click="save()">保存</button>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vue = new Vue({
            el: '.content',
            data: {
                mapItem: {},
                typeList: [],
                controlList: [],
            },
            watch: {},
            created: function () {
                this.init();
            },
            methods: {
                init: function () {
                    this.typeList = parent.vm.mapsList.type;
                    this.controlList = parent.vm.mapsList.control;
                    this.mapItem.type = parent.vm.params.type;
                },
                save: function () {
                    var _self = this;
                    if (_self.mapItem.name == null) {
                        return layer.msg('参数名称不能为空', {icon: 5});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/admin/system/maps/create')}}",
                        data: _self.mapItem,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                parent.vm.init();
                                parent.layer.close(frameindex);
                                parent.layer.msg(_obj.msg, {icon: 6});
                                return;
                            }
                            layer.alert(_obj.msg, {icon: 5});

                        }
                    });
                    return false;
                }

            }
        });
    </script>
@endsection
