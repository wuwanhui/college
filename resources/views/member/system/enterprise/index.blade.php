@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            企业信息
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">企业信息</li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="box box-primary">

                        <div class="box-body">
                            {{ csrf_field() }}
                            <fieldset>
                                <legend>基本信息</legend>

                                <div class="form-group">
                                    <label for="name" class="col-md-2 control-label">全称：</label>

                                    <div class="col-md-10">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="enterprise.name" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="shortName" class="col-md-2 control-label">简称：</label>

                                    <div class="col-md-10">
                                        <input id="shortName" type="text" class="form-control"
                                               name="shortName"
                                               style="width: auto;"
                                               v-model="enterprise.shortName" required>

                                    </div>
                                </div>


                                <div class="form-group ">
                                    <label for="linkMan" class="col-md-2 control-label">联系人：</label>

                                    <div class="col-md-10">
                                        <input id="linkMan" type="text" class="form-control" name="linkMan"
                                               style="width: auto;"
                                               v-model="enterprise.linkMan" required>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile" class="col-md-2 control-label">手机号：</label>

                                    <div class="col-md-10">
                                        <input id="mobile" type="tel" class="form-control" name="mobile"
                                               placeholder="手机号（必填）"
                                               style="width: auto;"
                                               v-model="enterprise.mobile" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tel" class="col-md-2 control-label">电话：</label>

                                    <div class="col-md-10">
                                        <input id="tel" type="tel" class="form-control" name="tel"
                                               placeholder="电话"
                                               style="width: auto;"
                                               v-model="enterprise.tel">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fax" class="col-md-2 control-label">传真：</label>

                                    <div class="col-md-10">
                                        <input id="fax" type="fax" class="form-control" name="fax"
                                               placeholder="传真号码"
                                               style="width: auto;"
                                               v-model="enterprise.fax">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="qq" class="col-md-2 control-label">QQ：</label>

                                    <div class="col-md-10">
                                        <input id="qq" type="text" class="form-control" name="qq"
                                               style="width: 300px;"
                                               v-model="enterprise.qq">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-md-2 control-label">电子邮件：</label>

                                    <div class="col-md-10">
                                        <input id="email" type="email" class="form-control" name="email"
                                               style="width: 300px;"
                                               v-model="enterprise.email">

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="addres" class="col-md-2 control-label">地址：</label>

                                    <div class="col-md-10">
                                        <input id="addres" type="text" class="form-control" name="addres"
                                               v-model="enterprise.addres">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area" class="col-md-2 control-label">所在区域：</label>

                                    <div class="col-md-10">
                                        <input id="area" type="text" class="form-control auto" name="area"
                                               v-model="enterprise.area">

                                    </div>
                                </div>

                            </fieldset>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">返回
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save()">保存</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'enterprise'};
        var vue = new Vue({
            el: '.content',
            data: {
                enterprise: {},
            },
            watch: {
                question: function (newQuestion) {
                    this.answer = 'Waiting for you to stop typing...'
                    this.getAnswer()
                }
            },
            created: function () {
                this.init();
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get('{{url('/manage/system/enterprise?json')}}')
                            .then(function (response) {
                                if (response.data.code == 0) {
                                    _self.enterprise = response.data.data;
                                }
                            }, function (error) {
                                alert("异常：" + error);
                            });

                },
                save: function () {
                    var _self = this;
                    this.$http.post('{{url('/manage/system/enterprise')}}', this.enterprise)
                            .then(function (response) {
                                if (response.data.code == 0) {
                                    _self.enterprise = response.body.data;
                                    layer.msg(response.body.msg, {
                                        icon: 1,
                                        time: 2000,
                                    });
                                } else {
                                    layer.alert(response.body.msg);
                                }

                            }, function (error) {
                                alert("有异常：" + error);
                            });
                }

            }
        });
    </script>
@endsection
