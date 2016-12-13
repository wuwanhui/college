@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            系统参数
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">系统参数</li>
        </ol>
    </section>
    <section class="content">
        <validator name="validatorConfig">
            <form class="form-horizontal" :class="{ 'error': $validatorConfig.invalid && trySubmit }"
                  novalidate>
                <div class="box box-primary">

                    <div class="box-body">

                        <fieldset>
                            <legend>基本信息</legend>
                            <div class="form-group">
                                <label for="name" class="col-md-2 control-label">平台名称：</label>

                                <div class="col-md-10">
                                    <input id="name" name='name' type="text" class="form-control"
                                           :class="{ 'error': $validatorConfig.name.invalid  && trySubmit}"
                                           v-model="config.name"
                                           placeholder="必填项"
                                           v-validate:name="{ required: true, minlength: 2 }">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="logo" class="col-md-2 control-label">标志：</label>

                                <div class="col-md-10">
                                    <input id="logo" type="text" class="form-control"
                                           name="logo"
                                           v-model="config.logo">

                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="domain" class="col-md-2 control-label">平台地址：</label>

                                <div class="col-md-10">
                                    <input id="domain" name="domain" type="text" class="form-control"
                                           :class="{ 'error': $validatorConfig.domain.invalid  && trySubmit}"
                                           v-model="config.domain"
                                           placeholder="必填项"
                                           v-validate:domain="{ required: true}">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>授权信息</legend>

                            <div class="form-group">
                                <label for="key" class="col-md-2 control-label">序列号：</label>

                                <div class="col-md-10">
                                    <input id="key" type="key" class="form-control" name="key"
                                           style="width: auto;"
                                           v-model="config.key">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="authNum" class="col-md-2 control-label">授权用户数：</label>

                                <div class="col-md-10">
                                    <input id="authNum" type="number" class="form-control"
                                           name="authNum"
                                           style="width: auto;"
                                           v-model="config.authNum">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="endTime" class="col-md-2 control-label">有效期止：</label>

                                <div class="col-md-10">
                                    <input id="endTime" type="datetime" class="form-control"
                                           name="endTime"
                                           style="width: auto;"
                                           v-model="config.endTime">

                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>系统状态</legend>
                            <div class="form-group ">
                                <label for="state" class="col-md-2 control-label">状态：</label>

                                <div class="col-md-10">
                                    <select id="state" name="state" class="form-control"
                                            style="width: auto;"
                                            v-model="config.state">
                                        <option value="0">正常</option>
                                        <option value="2">维护</option>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="remark" class="col-md-2 control-label">维护信息：</label>

                                <div class="col-md-10">
                                    <input id="remark" type="text" class="form-control"
                                           name="remark"
                                           style="width: auto;"
                                           v-model="config.remark">

                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12  text-center">
                                <button type="button" class="btn btn-default" onclick="vbscript:window.history.back()">
                                    返回
                                </button>
                                <button type="button" class="btn  btn-primary"
                                        v-bind:class="{disabled1:$validator.invalid}" v-on:click="save($validator)">保存
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </validator>

    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var vm = new Vue({
            el: '#config',
            data: {
                trySubmit: false,
                loading: true,
                config: jsonFilter('{{$config}}'),
                item: {
                    email: null,
                    password: null,
                },
            },
            watch: {},
            created: function () {

            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get('{{url('/manage/system/config?json')}}').then(function (response) {
                        if (response.data.code == 0) {
                            _self.config = response.data.data;
                            return
                        }
                        layer.alert(JSON.stringify(response.data.data));

                    });
                },
                saveConfig: function (form) {
                    var _self = this;
                    if (form.invalid) {
                        //this.$log('config');
                        this.trySubmit = true;
                        return;
                    }
                    this.$http.post('{{url('/manage/system/config')}}', _self.config).then(function (response) {
                        if (response.data.code == 0) {
                            _self.config = response.data.data;
                            parent.layer.msg('保存成功', {offset: '2px', time: 2000});
                            return;
                        }
                        layer.alert(JSON.stringify(response.data.data));

                    });

                }
            }
        });


    </script>
@endsection
