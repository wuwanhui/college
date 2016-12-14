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
        <validator name="validator">
            <form class="form-horizontal" :class="{ 'error': $validator.invalid && trySubmit }"
                  novalidate>
                <div class="box box-primary">

                    <div class="box-body">

                        <fieldset>
                            <legend>基本信息</legend>
                            <div class="form-group">
                                <label for="name" class="col-md-2 control-label">平台名称：</label>

                                <div class="col-md-10">
                                    <input id="name" name='name' type="text" class="form-control"
                                           :class="{ 'error': $validator.name.invalid  && trySubmit}"
                                           v-model="config.name"
                                           placeholder="必填项"
                                           v-validate:name="{ required: true, minlength: 2 }">
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="tel" class="col-md-2 control-label">联系电话：</label>

                                <div class="col-md-10">
                                    <input id="tel" name="tel" type="text" class="form-control"
                                           :class="{ 'error': $validator.tel.invalid  && trySubmit}"
                                           v-model="config.tel"
                                           placeholder="必填项"
                                           v-validate:domain="{ required: true}">
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
            el: '.content',
            data: {
                trySubmit: false,
                loading: true,
                config: {},
                item: {
                    email: null,
                    password: null,
                },
            },
            watch: {},
            created: function () {
                //this.init();
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get('{{url('/manage/config?json')}}').then(function (response) {
                        if (response.data.code == 0) {
                            var _data = response.data.data;
                            if (_data) {
                                _self.config = _data;
                            }
                            return
                        }
                        layer.alert(JSON.stringify(response.data.data));

                    });
                },
                save: function (form) {
                    var _self = this;
                    if (form.invalid) {
                        //this.$log('config');
                        this.trySubmit = true;
                        return;
                    }
                    this.$http.post('{{url('/manage/config')}}', _self.config).then(function (response) {
                        if (response.data.code == 0) {
                            _self.config = response.data.data;
                            msg('保存成功');
                            return;
                        }
                        layer.alert(JSON.stringify(response));

                    });

                }
            }
        });


    </script>
@endsection
