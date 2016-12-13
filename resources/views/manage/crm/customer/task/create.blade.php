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
                                    <label for="name" class="col-sm-2 control-label">任务标题：</label>
                                    <div class="col-sm-10 ">
                                        <div class="input-group">
                                            <input id="name" type="text" class="form-control" name="name"
                                                   v-model="task.name"
                                                   :class="{ 'error': $validator.name.invalid && trySubmit }"
                                                   v-validate:name="{ required: true}" placeholder="不能为空">
                                            <span class="input-group-btn">
                                   <select id="type" name="type" class="form-control"
                                           style="width: auto;" v-model="task.type">
                                            <option value="0"
                                                    selected>{{Base::data('customer_task_type')->name}}</option>
                                       @foreach(Base::data('customer_task_type')->baseDatas as $item)
                                           <option value="{{$item->value}}">{{$item->name}}</option>
                                       @endforeach
                                        </select>
                                        </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">任务内容：</label>

                                    <div class="col-sm-10">
                                            <textarea id="content" type="text" class="form-control"
                                                      style="width: 100%;height:80px;"
                                                      v-model="task.content"></textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="integral" class="col-sm-2 control-label">任务积分：</label>
                                    <div class="col-sm-4">
                                        <input id="integral" name="integral" type="text" class="form-control "
                                               v-model="task.integral"
                                        >
                                    </div>
                                    <label for="endTime" class="col-sm-2 control-label">有效期止：</label>
                                    <div class="col-sm-4">
                                        <input id="endTime" name="endTime" type="text" class="form-control "
                                               v-model="task.endTime">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="notice" class="col-sm-2 control-label">通知内容：</label>

                                    <div class="col-sm-10">
                                            <textarea id="notice" type="text" class="form-control"
                                                      style="width: 100%;height:80px;"
                                                      v-model="task.notice" placeholder="完成任务通知内容"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="task.remark"></textarea>
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
                task: jsonFilter('{{json_encode($task)}}'),
            },
            watch: {},
            ready: function () {

            },

            methods: {
                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('task');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/customer/task/create')}}", this.task)
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
