@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <validator name="validator">
                        <form enctype="multipart/form-data" class="form-horizontal" customer="form" method="POST"
                              novalidate>

                            <div class="box-body">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">学生：</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" v-model="student">
                                                <option value="0" selected>请选择学生</option>
                                                <option v-bind:value="item" v-for="item in term.students"
                                                        v-text="item.name"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">课程：</label>
                                        <div class="col-sm-10">
                                            <select id="parent_id" name="sex" class="form-control" v-model="agenda">
                                                <option value="0" selected>请选择课程</option>
                                                <option v-bind:value="item" v-for="item in term.agendas"
                                                        v-text="item.name"></option>
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
        @{{ term|json }}
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
                term: jsonFilter('{{json_encode($term)}}'),
                agenda: {},
                student: {}
            },
            watch: {},
            ready: function () {

            },

            methods: {


                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('term');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/syllabus/create')}}", {
                        term_id: this.term.id,
                        agenda_id: this.agenda.id,
                        student_id: this.student.id
                    })
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
