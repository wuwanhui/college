@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <validator name="validator">
                        <form enctype="multipart/form-data" class="form-horizontal" method="POST"
                              novalidate>

                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label ">学生：</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static"
                                               v-text="syllabus.student_relate.student.name"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">课程：</label>
                                        <div class="col-sm-10">
                                            <select id="parent_id" name="sex" class="form-control auto"
                                                    v-model="syllabus.agenda_id">
                                                <option v-bind:value="item.id" v-for="item in term.agendas"
                                                        v-text="item.agenda.name"></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="state" class="col-sm-2 control-label">状态：</label>
                                        <div class="col-sm-10">
                                            <select id="state" name="state" class="form-control" style="width: auto;"
                                                    v-model="syllabus.state">
                                                <option value="1">待审</option>
                                                <option value="0">有效</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                        <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="term.remark"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-xs-12  text-center">
                                        <button type="button" class="btn btn-default"
                                                onclick="parent.layer.close(frameindex)">
                                            关闭
                                        </button>
                                        <button type="button" class="btn  btn-primary"
                                                v-bind:class="{disabled1:$validator.invalid}"
                                                v-on:click="save($validator)">保存
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </validator>
                </div>
            </div>
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
                syllabus: parent.vm.syllabus,
                term: eval({!!json_encode($term)!!}),
                agenda: {},
                student: {},
                state: 1
            },
            watch: {},
            ready: function () {

            },

            methods: {
                save: function (form) {
                    var _self = this;
                    if (form.invalid) {
                        this.trySubmit = true;
                        return;
                    }
                    this.$http.post("{{url('/manage/syllabus/edit')}}",JSON.stringify(this.syllabus))
                            .then(function (response) {
                                        if (response.data.code == -1) {
                                            parent.layer.alert(JSON.stringify(response));
                                            return;
                                        }
                                        if (response.data.code == 0) {
                                            parent.msg(response.data.msg);
                                            parent.layer.close(frameindex);
                                            parent.vm.init();
                                            return;
                                        }
                                        parent.layer.alert(response.data.msg);

                                    }
                            );
                }

            }
        });
    </script>
@endsection
