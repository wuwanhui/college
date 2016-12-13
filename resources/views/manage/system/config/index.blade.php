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
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

                <li role="presentation" class="active"><a href="#config" role="tab"
                                                          data-toggle="tab">系统参数</a></li>
                <li role="presentation"><a href="#maps" role="tab" data-toggle="tab">其它参数</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="active tab-pane" id="config" v-if="loading">
                    <validator name="validatorConfig">
                        <form class="form-horizontal" :class="{ 'error': $validatorConfig.invalid && trySubmit }"
                              novalidate>

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
                            <div class="text-center">
                                <button type="button" class="btn btn-default"
                                        onclick="vbscript:window.history.back()">返回
                                </button>
                                <button type="button" class="btn  btn-primary ui fluid large teal submit button "
                                        v-bind:class="{disabled:$validatorConfig.invalid}"
                                        v-on:click="saveConfig($validatorConfig)">保存
                                </button>
                            </div>
                        </form>
                    </validator>
                </div>
                <div class="tab-pane" id="maps">
                    <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST">

                        <fieldset v-for="(key,value) in typeList">
                            <legend v-text="value"></legend>
                            <div class="form-group" v-for="item in even(key)">
                                <label v-bind:for="item.code" class="col-md-2 control-label"
                                       v-text="item.name"></label>
                                <div class="col-md-10">
                                    <input v-bind:id="item.code" type="text" class="form-control"
                                           v-if="item.control=='text'"
                                           style="width: auto;" v-on:click="newMapItem=item"
                                           v-on:onfocus="edit()"
                                           v-model="item.value"/>
                                    <textarea v-bind:id="item.code" class="form-control"
                                              v-if="item.control=='textarea'"
                                              style="width: 100%;height: 50px;"
                                              v-model="item.value"></textarea>

                                    <input type="checkbox" v-bind:id="item.code" class="form-control"
                                           v-if="item.control=='checkbox'"
                                           style="width: auto;"
                                           v-model="item.value"/>

                                    <select v-bind:id="item.code" v-if="item.control=='select'"
                                            class="form-control"
                                            style="width: auto;" v-model="item.value">
                                        <option v-bind:value="key"
                                                v-for="(key,value) in eval(item.default)">@{{ value }}</option>
                                    </select>


                                </div>
                            </div>
                        </fieldset>
                        <div class="text-center">
                            <button type="button" class="btn btn-default"
                                    onclick="vbscript:window.history.back()">返回
                            </button>
                            <button type="button" class="btn  btn-primary ui fluid large teal submit button"
                                    v-on:click="saveMaps($form)">保存
                            </button>
                        </div>
                    </form>

                </div>


            </div>
        </div>

    </section>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'config'};
        var configVue = new Vue({
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

        var mapsVue = new Vue({
            el: '#maps',
            data: {
                mapList: [],
                mapItem: '',
                newMapItem: '',
                typeList: [],
                controlList: [],
                loading: true,
            },

            ready: function () {
                this.init();

            },


            watch: {
                'newMapItem.value': function (val, oldVal) {
                    alert(111);
                }
            },

            methods: {
                eval: function (_str) {
                    return JSON.parse(_str);
                },
                even: function (type) {
                    var _self = this;
                    return _self.mapList.filter(function (mapItem) {
                        if (mapItem.type == type) {
                            return mapItem
                        }
                    })
                },
                init: function () {
                    var _self = this;
                    this.$http.get('{{url('/manage/system/basemaps?json')}}').then(
                            function (response) {

                                if (response.data.code == 0) {
                                    _self.mapList = response.data.data.data;
                                    _self.typeList = response.data.data.type;
                                    _self.controlList = response.data.data.control;
                                    return
                                }
                                layer.alert(JSON.stringify(response.data.data));
                            }
                    );
                },


                search: function () {
                    this.init();
                },
                create: function () {
                    openUrl('{{url('/manage/system/maps/create')}}', '新增参数');
                },
                edit: function (item) {
                    this.role = item;
                    openUrl('{{url('/manage/system/maps/edit')}}?id=' + item.id, '编辑"' + item.name + '"参数');
                },
                delete: function (index, item) {
                    var _self = this;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/basemaps?json')}}",
                        data: item,
                        headers: {
                            'X-CSRF-TOKEN': Laravel.csrfToken
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.maps.splice(index, 1);
                            } else {
                                alert(_obj.msg);
                            }
                        }
                    });

                }
            }
        });

    </script>
@endsection
