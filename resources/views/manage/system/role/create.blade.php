@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST"
                      :class="{ 'error': $form.invalid && trySubmit }" novalidate>

                    <div class="box-body">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="name" class="col-md-3 control-label">角色名称：</label>
                                <div class="col-md-9">
                                    <input id="name" type="text" class="form-control auto" name="name"
                                           v-model="role.name"
                                           :class="{ 'error': $validator.name.invalid && trySubmit }"
                                           v-validate:name="{ required: true}" placeholder="不能为空">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="remark" class="col-md-3 control-label">描述：</label>

                                <div class="col-md-9">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%,height:50px;"
                                                      v-model="role.remark"></textarea>
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
                                <button type="button" class="btn  btn-primary"
                                        v-bind:class="{disabled1:$validator.invalid}" v-on:click="save($validator)">保存
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </validator>
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
                trySubmit: false,
                role: {}
            },
            watch: {},

            methods: {

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('role');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/system/role/create')}}", this.role)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            parent.layer.close(frameindex);
                                            msg('新增成功');
                                            parent.vm.init();
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );
                }

            }
        });
    </script>
@endsection
