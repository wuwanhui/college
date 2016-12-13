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
                <div class="active tab-pane" id="config">
                    <validator name="form">
                        <form class="form-horizontal" :class="{ 'error': $form.invalid && trySubmit }"
                              novalidate>
                            <fieldset>
                                <legend>基本信息</legend>
                                <div class="form-group">
                                    <label for="name" class="col-md-2 control-label">平台名称：</label>

                                    <div class="col-md-10" :class="{ 'error': $form.name.invalid && trySubmit }">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="config.name"
                                               v-validate:name="{ required: true, minlength: 6 }">
                                        <div v-if="trySubmit">
                                            <div v-if="$form.name.required" v-text="平台名称为必填"></div>
                                            <div v-if="$form.name.minlength" v-text="平台名称最少不低于6个字符"></div>
                                        </div>

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
                                        <input id="domain" type="text" class="form-control"
                                               name="domain"
                                               v-model="config.domain" required>

                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>授权信息</legend>

                                <div class="form-group">
                                    <label for="key" class="col-md-2 control-label">序列号：</label>

                                    <div class="col-md-10">
                                        <input id="key" type="tel" class="form-control" name="key"
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
                                <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
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
                                <button type="button" class="btn  btn-primary ui fluid large teal submit button"
                                        v-on:click="saveConfig($form)">保存
                                </button>
                            </div>
                        </form>
                    </validator>
                    <div class="ui error message" v-if="trySubmit">
                        <ul class="list">
                            <li v-if="$form.name.required">Please enter your e-mail</li>
                            <li v-if="$form.email.email">Please enter a valid e-mail</li>
                            <li v-if="$form.password.required">Please enter your password</li>
                            <li v-if="$form.name.minlength">Your password must be at least 6 characters</li>
                        </ul>
                    </div>
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
                            <button type="button" class="btn btn-primary" v-on:click="create()">新增</button>
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </section>
    <!-- 新增全局参数 -->
    <div class="modal fade" id="createMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增参数 </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">参数名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="mapItem.name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-md-3 control-label">分类：</label>

                            <div class="col-md-9">
                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapItem.type">
                                    <option v-bind:value="key" v-for="(key,value) in typeList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="control" class="col-md-3 control-label">控件类型：</label>

                            <div class="col-md-9">

                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapItem.control">
                                    <option v-bind:value="key" v-for="(key,value) in controlList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">标识：</label>

                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control" name="code"
                                       v-model="mapItem.code">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="default" class="col-md-3 control-label">参考值：</label>

                            <div class="col-md-9">
                                <input id="default" type="text" class="form-control" name="default"
                                       v-model="mapItem.default">

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="create()">保存</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 编辑全局参数 -->
    <div class="modal fade" id="editMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增参数 </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">参数名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="mapItem.name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-md-3 control-label">分类：</label>

                            <div class="col-md-9">
                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapItem.type">
                                    <option v-bind:value="key" v-for="(key,value) in typeList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="control" class="col-md-3 control-label">控件类型：</label>

                            <div class="col-md-9">

                                <select id="state" name="state" class="form-control"
                                        style="width: auto;" v-model="mapItem.control">
                                    <option v-bind:value="key" v-for="(key,value) in controlList">@{{ value }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">标识：</label>

                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control" name="code"
                                       v-model="mapItem.code">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="default" class="col-md-3 control-label">参考值：</label>

                            <div class="col-md-9">
                                <input id="default" type="text" class="form-control" name="default"
                                       v-model="mapItem.default">

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="create()">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'config'};
        var configVue = new Vue({
            el: '#config',
            data: {
                config: {name: ''},
                item: {
                    email: null,
                    password: null,
                },
                trySubmit: false
            },
            watch: {},
            created: function () {
                this.init();
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据

                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/config?json')}}",
                        success: function (_obj) {
                            _self.config = _obj.data;

                        }
                    });
                },
                saveConfig: function (form) {
                    this.trySubmit = true;
                    if (!form.valid) {
                        this.$log('config')
                        return;
                    }
                    var _self = this;
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/config')}}",
                        data: _self.config,
                        headers: {
                            'X-CSRF-TOKEN': Laravel.csrfToken
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.config = _obj.data;
                                layer.msg(_obj.msg, {
                                    icon: 1,
                                    time: 2000,
                                });
                            } else {
                                layer.alert(JSON.stringify(_obj.data));
                            }
                        }
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
            watch: {
                'mapItem.value': function (val, oldVal) {
                    alert(111);
                    //this.edit();
                }
            },
            created: function () {
                this.init();
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
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/basemaps?json')}}",
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.mapList = _obj.data.data;
                                _self.typeList = _obj.data.type;
                                _self.controlList = _obj.data.control;
                            }
                            if (_obj.code == 2) {
                                alert(JSON.stringify(_obj.data));
                            }
                        }
                    });
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
