@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal"  method="POST"
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
                                        <select id="teacher_id" name="sex" class="form-control"
                                                v-model="agenda.teacher_id"
                                        >
                                            <option value="" selected>请选择任课教师</option>
                                            <option v-bind:value="item.id" v-for="item in teacherList"
                                                    v-text="item.name"></option>
                                        </select>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
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
                teacherList: jsonFilter('{{json_encode($teacherList)}}'),
                agendaList: jsonFilter('{{json_encode($agendaList)}}'),
            },
            watch: {},
            ready: function () {
            },

            methods: {
                init: function () {
                    var _self = this;
                    this.$http.get("{{url('/manage/teacher/api/list')}}")
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.teacherList = response.data.data;
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('agenda');
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
