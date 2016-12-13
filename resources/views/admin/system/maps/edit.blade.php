@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <form enctype="multipart/form-data" class="form-horizontal" method="POST">
                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <input type="hidden" v-model="mapsItem.id">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">参数名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="mapsItem.name" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-md-3 control-label">分类：</label>

                            <div class="col-md-9">
                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapsItem.type">
                                    <option v-bind:value="key" v-for="(key,value) in typeList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="control" class="col-md-3 control-label">控件类型：</label>

                            <div class="col-md-9">

                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapsItem.control">
                                    <option v-bind:value="key"
                                            v-for="(key,value) in controlList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">标识：</label>

                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control" name="code"
                                       v-model="mapsItem.code">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="default" class="col-md-3 control-label">参考值：</label>

                            <div class="col-md-9">
                                <input id="default" type="text" class="form-control" name="default"
                                       v-model="mapsItem.default">

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
        var vm = new Vue({
            el: '.content',
            data: {
                mapsItem: {},
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
                    this.mapsItem = parent.vm.mapsItem;
                },
                save: function () {
                    var _self = this;
                    if (_self.mapsItem.name == null) {
                        return layer.msg('参数名称不能为空', {icon: 5});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/admin/system/maps/edit')}}",
                        data: _self.mapsItem,
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
                            layer.alert(JSON.stringify(_obj.data), _obj.msg, {icon: 5});
                        }
                    });
                    return false;
                }

            }
        });
    </script>
@endsection