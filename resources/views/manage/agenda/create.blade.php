@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST"
                      novalidate>

                    <div class="box-body">
                        <div class="col-xs-12">

                            <fieldset>
                                <legend>基本信息</legend>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">课程名称：</label>
                                    <div class="col-sm-10">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="agenda.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="teacher_id" class="col-sm-2 control-label">任课教师：</label>
                                    <div class="col-sm-10">
                                        <input id="teacher" type="text" class="form-control" name="teacher"
                                               v-model="agenda.teacher"
                                               :class="{ 'error': $validator.teacher.invalid && trySubmit }"
                                               v-validate:teacher="{ required: true}" placeholder="不能为空">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">课程附件：</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">

                                            <input id="teacher" type="file" class="form-control" name="teacher"
                                                   v-model="agenda.accessory"/>
                                            <span class="input-group-btn">  <button class="btn btn-default"
                                                                                    type="button">上传</button>  </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">课程介绍：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:300px;"
                                                      v-model="agenda.remark"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12  text-center">
                                <button type="button" class="btn btn-default" onclick="parent.layer.close(frameindex)">
                                    关闭
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
                agenda: {},
            },
            watch: {},
            ready: function () {
                this.init();
            },

            methods: {
                init: function () {

                },

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/agenda/create')}}", this.agenda)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            parent.msg('新增成功');
                                            parent.layer.close(frameindex);
                                            parent.vm.init();
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                }

            }
        });
    </script>
@endsection
