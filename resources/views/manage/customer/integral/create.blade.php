@extends('layouts.app')

@section('content')
    <section class="content" xmlns="http://www.w3.org/1999/html">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal" customer="form" method="POST"
                      novalidate>

                    <div class="box-body">
                        <div class="col-xs-12">

                            <fieldset>
                                <legend>基本信息</legend>
                                <input type="hidden" id="customer_id" v-model="integral.customer_id">
                                <div class="form-group">
                                    <label for="customer_id" class="col-sm-2 control-label">客户：</label>
                                    <div class="col-sm-10">
                                        <select id="customer_id" name="sex" class="form-control"
                                                v-model="integral.customer_id"
                                                :class="{ 'error': $validator.customer_id.invalid && trySubmit }" number
                                                v-validate:customer_id="{ required: true}">
                                            <option value="" selected>请选择客户</option>
                                            <option v-bind:value="item.id" v-for="item in customerList"
                                                    v-text="item.name"></option>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="customer_id" class="col-sm-2 control-label">任务：</label>
                                    <div class="col-sm-10">
                                        <select id="task_id" name="sex" class="form-control"
                                                v-model="taskItem">
                                            <option value="" selected>请选择任务</option>
                                            <option v-bind:value="item" v-for="item in taskList"
                                                    v-text="item.name"></option>
                                        </select>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">标题：</label>
                                    <div class="col-sm-10">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="integral.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="subject" class="col-sm-2 control-label">事由：</label>

                                    <div class="col-sm-10">
                                            <textarea id="subject" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="integral.subject"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="integral" class="col-sm-2 control-label">积分：</label>
                                    <div class="col-sm-4">
                                        <input id="integral" name="integral" type="text" class="form-control "
                                               v-model="integral.integral" number
                                               :class="{ 'error': $validator.integral.invalid && trySubmit }" number
                                               v-validate:integral="{ required: true}">
                                    </div>
                                    <label for="state" class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-4">
                                        <select id="state" name="state" class="form-control"
                                                v-model="integral.state">
                                            <option v-bind:value="key" v-for="(key,value) in initBase.stateList"
                                                    v-text="value"></option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="integral.remark"></textarea>
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
                taskItem: {},
                integral: {customer_id: 0, task_id: 0, name: '', subject: '', integral: 0, state: 2},
                initBase: jsonFilter('{{json_encode($initBase)}}'),
                customerList: [],
                taskList: [],


            },
            watch: {
                'taskItem': function (val) {
                    this.integral.name = val.name;
                    this.integral.subject = val.content;
                    this.integral.integral = val.integral;
                    this.integral.task_id = val.id;
                }
            },


            ready: function () {
                this.initCustomer();
                this.initTask();
                if (parent.vm.customer) {
                    this.integral.customer_id = parent.vm.customer.id;
                }
            },

            methods: {

                initCustomer: function () {
                    var _self = this;
                    this.$http.get("{{url('/manage/crm/customer/api/list')}}")
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.customerList = response.data.data;

                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },

                initTask: function () {
                    var _self = this;
                    this.$http.get("{{url('/manage/crm/customer/task/api/list')}}")
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.taskList = response.data.data;
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('integral');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/customer/integral/create')}}", this.integral)
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
