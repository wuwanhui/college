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
                                <input type="hidden" id="customer_id" v-model="linkman.customer_id">

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">姓名：</label>
                                    <div class="col-sm-4">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="linkman.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>
                                    <label for="englishName" class="col-sm-2 control-label">英文名称：</label>

                                    <div class="col-sm-4">
                                        <input id="englishName" type="text" class="form-control" name="englishName"
                                               v-model="linkman.englishName">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sex" class="col-sm-2 control-label">性别：</label>
                                    <div class="col-sm-4">
                                        <select id="sex" name="sex" class="form-control"
                                                style="width: auto;" v-model="linkman.sex">
                                            <option value="-1" selected>未知</option>
                                            <option value="0">男</option>
                                            <option value="1">女</option>
                                        </select>
                                    </div>
                                    <label for="birthday" class="col-sm-2 control-label">生日：</label>
                                    <div class="col-sm-4">
                                        <input id="birthday" name="birthday" type="text" class="form-control "
                                               v-model="linkman.birthday">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="identityCard" class="col-sm-2 control-label">身份证号：</label>

                                    <div class="col-sm-4">
                                        <input id="identityCard" name="identityCard" type="text" class="form-control "
                                               v-model="linkman.identityCard">

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">邮箱：</label>
                                    <div class="col-sm-4">
                                        <input id="email" name="email" type="text" class="form-control "
                                               v-model="linkman.email"
                                               :class="{ 'error': $validator.mobile.invalid && trySubmit }"
                                               v-validate:mobile="{ required: true}" placeholder="不能为空">
                                    </div>
                                    <label for="qq" class="col-sm-2 control-label">QQ：</label>
                                    <div class="col-sm-4">
                                        <input id="qq" name="qq" type="text" class="form-control "
                                               v-model="linkman.qq">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-sm-2 control-label">手机号：</label>
                                    <div class="col-sm-10">
                                        <input id="mobile" name="mobile" type="text" class="form-control  "
                                               v-model="linkman.mobile"
                                               :class="{ 'error': $validator.mobile.invalid && trySubmit }"
                                               v-validate:mobile="{ required: true}" placeholder="不能为空"
                                        >

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tel" class="col-sm-2 control-label">座机电话：</label>
                                    <div class="col-sm-4">
                                        <input id="tel" type="text" class="form-control  " name="tel"
                                               v-model="linkman.tel"
                                        >

                                    </div>

                                    <label for="fax" class="col-sm-2 control-label">传真：</label>
                                    <div class="col-sm-4">
                                        <input id="fax" type="text" class="form-control  " name="fax"
                                               v-model="linkman.fax"
                                        >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="leaderId" class="col-sm-2 control-label">所属上级：</label>
                                    <div class="col-sm-4">
                                        <input id="leaderId" type="text" class="form-control  " name="leaderId"
                                               v-model="linkman.leaderId"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">内部备注：</label>

                                    <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="linkman.remark"></textarea>
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
                linkman: jsonFilter('{{json_encode($linkman)}}'),
            },
            watch: {},
            ready: function () {
            },

            methods: {

                save: function (form) {
                    var _self = this;


                    if (form.invalid) {
                        //this.$log('linkman');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/customer/linkman/edit')}}", JSON.stringify(this.linkman))
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
                }

            }
        });
    </script>
@endsection
