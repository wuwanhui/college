@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal" customer="form" method="POST"
                      novalidate>

                    <div class="box-body">
                        <div class="col-xs-12">

                            <fieldset>
                                <legend>基本信息</legend>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">姓名：</label>
                                    <div class="col-sm-10">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="teacher.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="number" class="col-sm-2 control-label">教师编号：</label>
                                    <div class="col-sm-10">
                                        <input id="number" type="text" class="form-control" name="number"
                                               v-model="teacher.number">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email：</label>
                                    <div class="col-sm-10">
                                        <input id="email" type="text" class="form-control" name="email"
                                               v-model="teacher.email">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">密码：</label>
                                    <div class="col-sm-10">
                                        <input id="password" type="password" class="form-control" name="password"
                                               v-model="teacher.password">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="post" class="col-sm-2 control-label">职称：</label>
                                    <div class="col-sm-10">
                                        <input id="post" type="text" class="form-control" name="post"
                                               v-model="teacher.post">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="abstract" class="col-sm-2 control-label">教师简介：</label>

                                    <div class="col-sm-10">
                                            <textarea id="abstract" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="teacher.abstract"></textarea>
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
                teacher: {},
            },
            watch: {},
            ready: function () {

            },
            methods: {


                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('teacher');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/teacher/create')}}", this.teacher)
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
