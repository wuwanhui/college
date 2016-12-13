@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal" notices="form" method="POST"
                      :class="{ 'error': $form.invalid && trySubmit }" novalidate>

                    <div class="box-body">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="name" class="col-md-3 control-label">标题：</label>
                                <div class="col-md-9">
                                    <input id="name" type="text" class="form-control " name="name"
                                           v-model="notices.name"
                                           :class="{ 'error': $validator.name.invalid && trySubmit }"
                                           v-validate:name="{ required: true}" placeholder="不能为空">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="target" class="col-md-3 control-label">目标（部门）：</label>
                                <div class="col-md-9">
                                    <input id="target" type="text" class="form-control " name="target"
                                           v-model="notices.target"
                                           placeholder="为空表示所有">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-md-3 control-label">内容：</label>

                                <div class="col-md-9">
                                            <textarea id="content" type="text" class="form-control"
                                                      style="width: 100%;height:300px;" placeholder="不能为空"
                                                      v-model="notices.content"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="endTime" class="col-md-3 control-label">有效期止：</label>
                                <div class="col-md-9">
                                    <input id="endTime" type="text" class="form-control auto" name="endTime"
                                           v-model="notices.endTime"
                                           placeholder="默认一个月">

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
                notices: {}
            },
            watch: {},

            methods: {

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('notices');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/system/notices/create')}}", this.notices)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            parent.layer.close(frameindex);
                                            parent.layer.msg('新增成功', {offset: '2px', time: 2000});
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
