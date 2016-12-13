@extends('layouts.app')

@section('content')
    <section class="content">
        <validator name="validator">
            <form enctype="multipart/form-data" class="form-horizontal" permission="form" method="POST">
                <div class="box box-default">


                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="permission.name"
                                       :class="{ 'error': $validator.name.invalid && trySubmit }"
                                       v-validate:name="{ required: true}" placeholder="不能为空">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">标识：</label>

                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control" name="code"
                                       v-model="permission.code"
                                       :class="{ 'error': $validator.code.invalid && trySubmit }"
                                       v-validate:code="{ required: true}" placeholder="不能为空">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">URL地址：</label>

                            <div class="col-md-9">
                                <input id="url" type="text" class="form-control" name="url"
                                       v-model="permission.url">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="isShow" class="col-md-3 control-label">是否显示：</label>

                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" v-model="permission.isShow" value="0">显示
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="permission.isShow" value="1">不显示
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remark" class="col-md-3 control-label">描述：</label>

                            <div class="col-md-9">
                                <textarea id="remark" class="form-control"
                                          style="width: 100%;height: 50px;"
                                          v-model="permission.remark"></textarea>

                            </div>
                        </div>

                    </div>
                    <div class="box-footer text-center">
                        <button type="button" class="btn btn-default"
                                onclick="vbscript:window.history.back()">返回
                        </button>
                        <button type="button" class="btn  btn-primary" v-on:click="save($validator)">保存</button>
                    </div>

                </div>
            </form>
        </validator>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vm = new Vue({
            el: '.content',
            data: {
                trySubmit: false,
                permission: {}
            },
            watch: {},

            methods: {

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        this.trySubmit = true;
                        return;
                    }
                    this.permission.parent_id=parent.vm.parent.id;

                    this.$http.post("{{url('/manage/system/permission/create')}}", this.permission)
                        .then(function (response) {
                                if (response.data.code == 0) {
                                    parent.layer.close(frameindex);
                                    msg('新增成功');
                                    parent.vm.init();
                                    return
                                }
                            parent.layer.alert(JSON.stringify(response.data.data));
                            }
                        );
                }

            }
        });
    </script>
@endsection
