@extends('layouts.app')
@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <validator name="validator">
                    <form enctype="multipart/form-data" class="form-horizontal" method="POST"
                          novalidate>

                        <div class="box-body">
                            <div class="col-xs-12">

                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">课程：</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" v-text="termAgenda.agenda.name"></p>

                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">上课周期：</label>
                                        <div class="col-sm-10">
                                            <select id="cycle" name="cycle" class="form-control auto"
                                                    v-model="termAgenda.cycle"
                                                    :class="{ 'error': $validator.cycle.invalid && trySubmit }"
                                                    v-validate:cycle="{ required: true}">
                                                <option value="0">请选择上课周期</option>
                                                <option value="1">第一月 1周-4周</option>
                                                <option value="2">第二月 5周-8周</option>
                                                <option value="3">第三月 9周-12周</option>
                                                <option value="4">第四月 13周-16周</option>
                                                <option value="5">第五月 1周-4周</option>
                                                <option value="6">第六月 5周-8周</option>
                                                <option value="7">第七月 9周-12周</option>
                                                <option value="8">第八月 13周-16周</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="parent_id" class="col-sm-2 control-label">关联课程：</label>
                                        <div class="col-sm-10">
                                            <select id="parent_id" name="sex" class="form-control"
                                                    v-model="termAgenda.parent_id"
                                            >
                                                <option value="0">请选择关联课程</option>
                                                <option v-bind:value="item.id" v-for="item in agendaList"
                                                        v-text="item.agenda.name"></option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">课程状态：</label>
                                        <div class="col-sm-10">
                                            <select id="state" name="state" class="form-control auto"
                                                    v-model="termAgenda.state">
                                                <option value="1">报名中</option>
                                                <option value="2">结束报名</option>
                                                <option value="0">开课中</option>
                                                <option value="3">取消课程</option>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                        <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="termAgenda.remark"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
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
                                            v-bind:class="{disabled1:$validator.invalid}" v-on:click="save($validator)">
                                        修改
                                    </button>

                                </div>
                            </div>
                        </div>
                    </form>
                </validator>
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
                termAgenda: eval({!!json_encode($termAgenda)!!}),
                agendaList: eval({!!json_encode($agendaList)!!}),
                term: parent.vm.term,
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

                    this.$http.post("{{url('/manage/term/edit/agenda')}}", this.termAgenda)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            parent.msg('编辑成功');
                                            parent.layer.close(frameindex);
                                            parent.vm.init();
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },
            }
        });

    </script>
@endsection
