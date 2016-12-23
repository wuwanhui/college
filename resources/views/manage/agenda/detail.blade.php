@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            客户档案
            <small>客户详情</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage/crm')}}"><i class="fa fa-dashboard"></i> 客户关系</a></li>
            <li class="active">客户档案</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3><span v-text="customer.name"></span>
                    <small v-text="customer.affiliation"></small>
                </h3>
                <hr/>
            </div>

            <div class="box-body">
                <table class="table table-bordered detail">
                    <tbody>
                    <tr>
                        <th>客户类型:</th>
                        <td v-text="customer.type_cn"></td>
                        <th>来源:</th>
                        <td v-text="customer.source_cn"></td>
                    </tr>
                    <tr>
                        <th>来源:</th>
                        <td v-text="customer.source_cn"></td>
                        <th>评级:</th>
                        <td v-text="customer.grade_cn"></td>

                    </tr>
                    <tr>
                        <th>负责人:</th>
                        <td v-text="customer.leader_cn"></td>
                        <th>手机号:</th>
                        <td v-text="customer.mobile"></td>
                    </tr>
                    <tr>
                        <th>QQ:</th>
                        <td v-text="customer.qq"></td>
                        <th>电话:</th>
                        <td v-text="customer.tel"></td>
                    </tr>
                    <tr>
                        <th>传真:</th>
                        <td v-text="customer.fax"></td>
                        <th>邮箱:</th>
                        <td v-text="customer.email"></td>
                    </tr>

                    <tr>
                        <th>所在区域:</th>
                        <td v-text="customer.area"></td>
                        <th>地址:</th>
                        <td v-text="customer.address"></td>
                    </tr>
                    <tr>
                        <th>推荐人:</th>
                        <td v-text="customer.referrerId"></td>
                        <th>邮箱:</th>
                        <td v-text="customer.email"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

                <li role="presentation" class="active"><a href="#config" role="tab"
                                                          data-toggle="tab">联系人</a></li>
                <li role="presentation"><a href="#maps" role="tab" data-toggle="tab">联系记录</a>
                </li>
                <li role="presentation"><a href="#maps" role="tab" data-toggle="tab">积分</a>
                </li>
                <li role="presentation"><a href="#maps" role="tab" data-toggle="tab">往来帐户</a>
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
                                               v-validate:name="{ required: true, minlength: 6 }">
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
        //sidebar.menu = {type: 'crm', item: 'customer'};
        var vm = new Vue({
            el: '.content',
            data: {
                trySubmit: false,
                initBase: eval({!!  json_encode($initBase)!!}),
                customer: eval({!! json_encode($customer) !!})
            },
            ready: function () {
            },

            watch: {},

            methods: {

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/customer/edit')}}", this.customer)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            msg('编辑成功');
                                            window.location.href = '{{url('/manage/crm/customer')}}';
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data));
                                    }
                            );
                },
                delete: function () {
                    var _self = this;
                    layer.confirm('确认删除"' + _self.customer.name + '"吗？', {
                                btn: ['确认', '取消']
                            }, function () {
                                _self.$http.post("{{url('/manage/crm/customer/delete')}}", {ids: _self.customer.id})
                                        .then(function (response) {
                                                    if (response.data.code == 0) {
                                                        msg('成功删除' + response.data.data + '条记录！');
                                                        window.location.href = '{{url('/manage/crm/customer')}}';
                                                        return
                                                    }
                                                    layer.alert(JSON.stringify(response.data));
                                                }
                                        );
                            }, function () {
                                layer.closeAll();
                            }
                    )
                    ;
                }

            }
        });
    </script>
@endsection
