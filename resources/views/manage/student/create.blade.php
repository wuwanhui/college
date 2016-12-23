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
                                    <label for="name" class="col-sm-2 control-label">姓名：</label>
                                    <div class="col-sm-10">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="student.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="number" class="col-sm-2 control-label">学号：</label>
                                    <div class="col-sm-10">
                                        <input id="number" type="text" class="form-control" name="number"
                                               v-model="student.number"
                                               :class="{ 'error': $validator.number.invalid && trySubmit }"
                                               v-validate:number="{ required: true}" placeholder="不能为空">

                                    </div>

                                </div>


                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email：</label>
                                    <div class="col-sm-10">
                                        <input id="email" type="text" class="form-control" name="email"
                                               v-model="student.email">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">密码：</label>
                                    <div class="col-sm-10">
                                        <input id="password" type="password" class="form-control" name="password"
                                               v-model="student.password">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="sex" class="col-sm-2 control-label">性别：</label>
                                    <div class="col-sm-10">

                                        <select v-model="student.sex" id="sex" class="form-control" name="sex">
                                            <option value="-1">未知</option>
                                            <option value="0">男</option>
                                            <option value="1">女</option>
                                        </select>


                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">手机号：</label>
                                    <div class="col-sm-10">
                                        <input id="phone" type="text" class="form-control" name="phone"
                                               v-model="student.phone">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">备注：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="student.remark"></textarea>
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
                student: {},
            },
            watch: {},
            ready: function () {

            },
            methods: {


                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('student');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/student/create')}}", this.student)
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
