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
                                <input type="hidden" v-model="linkman.customer_id">
                                <div class="form-group">
                                    <label for="customer_id" class="col-sm-2 control-label">客户：</label>
                                    <div class="col-sm-6">
                                        <p class="form-control-static" v-text="follow.customer.name"></p>
                                    </div>
                                    <label for="customer_linkman_id" class="col-sm-2 control-label">联系人：</label>

                                    <div class="col-sm-2">
                                        <select id="customer_linkman_id" name="customer_linkman_id" class="form-control"
                                                v-model="follow.customer_linkman_id" number>
                                            <option value="" selected>请选择</option>
                                            <option v-bind:value="item.id" v-for="item in linkManList"
                                                    v-text="item.name"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">标题：</label>
                                    <div class="col-sm-6">
                                        <input id="customer_id" type="text" class="form-control" name="name"
                                               v-model="follow.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>
                                    <label for="customer_linkman_id" class="col-sm-2 control-label">处理状态：</label>
                                    <div class="col-sm-2 text-right">
                                        <select id="state" name="sex" class="form-control"
                                                style="width: auto;" v-model="follow.state">
                                            <option v-bind:value="key" v-for="(key,value) in initBase.stateList"
                                                    v-text="value"></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">内容：</label>

                                    <div class="col-sm-10">
                                            <textarea id="content" name="content" type="text" class="form-control"
                                                      style="width: 100%;height:80px;"
                                                      v-model="follow.content"
                                                      :class="{ 'error': $validator.content.invalid && trySubmit }"
                                                      v-validate:content="{ required: true}"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">联系方式：</label>
                                    <div class="col-sm-4">
                                        <select id="type" name="sex" class="form-control"
                                                style="width: auto;" v-model="follow.type">
                                            <option v-bind:value="key" v-for="(key,value) in initBase.typeList"
                                                    v-text="value"></option>
                                        </select>
                                    </div>
                                    <label for="number" class="col-sm-2 control-label">联系号码：</label>

                                    <div class="col-sm-4">
                                        <input id="number" name="number" type="text" class="form-control "
                                               v-model="follow.number"
                                               :class="{ 'error': $validator.customer_id.invalid && trySubmit }"
                                               v-validate:customer_id="{ required: true}" placeholder="必填">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="follow.remark"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>下次联系信息</legend>

                                <div class="form-group">
                                    <label for="nextFollow" class="col-sm-2 control-label">时间：</label>
                                    <div class="col-sm-4">
                                        <input id="nextFollow" name="nextFollow" type="text" class="form-control "
                                               v-model="follow.nextFollow">

                                    </div>
                                    <label for="nextId" class="col-sm-2 control-label">联系人：</label>
                                    <div class="col-sm-4">
                                        <select id="nextId" name="nextId" class="form-control"
                                                v-model="follow.nextId" number>
                                            <option value="" selected>请选择联系人</option>
                                            <option v-bind:value="item.id" v-for="item in linkManList"
                                                    v-text="item.name"></option>
                                        </select>
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
                initBase: jsonFilter('{{json_encode($initBase)}}'),
                follow: jsonFilter('{{json_encode($follow)}}'),
                linkManList: []
            },
            watch: {},
            created: function () {
                this.initLinkMan(this.follow.id);
            },
            ready: function () {

            },

            methods: {
                init: function () {
                },

                initLinkMan: function (id) {
                    var _self = this;
                    this.$http.get("{{url('/manage/crm/customer/linkman/api/list')}}", {params: {customer_id: id}})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.linkManList = response.data.data;
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('follow');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/customer/follow/edit')}}", this.follow)
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
