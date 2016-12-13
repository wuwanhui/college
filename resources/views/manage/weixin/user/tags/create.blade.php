@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            客户档案
            <small>新增客户</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage/crm')}}"><i class="fa fa-dashboard"></i> 客户关系</a></li>
            <li class="active">客户档案</li>
        </ol>
    </section>
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
                                    <label for="name" class="col-md-2 control-label">客户全称：</label>
                                    <div class="col-md-4">
                                        <input id="name" type="text" class="form-control" name="name"
                                               v-model="customer.name"
                                               :class="{ 'error': $validator.name.invalid && trySubmit }"
                                               v-validate:name="{ required: true}" placeholder="不能为空">

                                    </div>
                                    <label for="control" class="col-md-2 control-label">客户类型：</label>

                                    <div class="col-md-4">
                                        <select id="type" name="type" class="form-control"
                                                style="width: auto;" v-model="customer.type">
                                            <option value="0" selected>{{Base::data('customer_type')->name}}</option>
                                            @foreach(Base::data('customer_type')->baseDatas as $item)
                                                <option value="{{$item->value}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="shortName" class="col-md-2 control-label">简称：</label>
                                    <div class="col-md-4">
                                        <input id="shortName" type="text" class="form-control " name="shortName"
                                               v-model="customer.shortName">

                                    </div>
                                    <label for="code" class="col-md-2 control-label">简码：</label>
                                    <div class="col-md-4">
                                        <input id="code" type="text" class="form-control " name="code"
                                               v-model="customer.code">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="source" class="col-md-2 control-label">来源：</label>

                                    <div class="col-md-4">
                                        <select id="source" name="source" class="form-control"
                                                style="width: auto;" v-model="customer.source">
                                            <option v-for="(key,value) in initBase.sourceList" v-bind:value="key"
                                                    v-text="value"
                                            ></option>
                                        </select>
                                    </div>
                                    <label for="grade" class="col-md-2 control-label">评级：</label>

                                    <div class="col-md-4">
                                        <select id="grade" name="grade" class="form-control"
                                                style="width: auto;" v-model="customer.grade">
                                            <option v-for="(key,value) in initBase.gradeList" v-bind:value="key"
                                                    v-text="value"
                                            ></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="affiliation" class="col-md-2 control-label">所属单位：</label>
                                    <div class="col-md-10">
                                        <input id="affiliation" type="text" class="form-control  " name="affiliation"
                                               v-model="customer.affiliation"
                                        >

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area" class="col-md-2 control-label">所在区域：</label>
                                    <div class="col-md-10">
                                        <input id="area" type="text" class="form-control  " name="area"
                                               v-model="customer.area"
                                        >

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-md-2 control-label">地址：</label>
                                    <div class="col-md-10">
                                        <input id="address" type="text" class="form-control  " name="address"
                                               v-model="customer.address"
                                        >

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="referrerId" class="col-md-2 control-label">推荐人ID：</label>
                                    <div class="col-md-10">
                                        <input id="referrerId" type="text" class="form-control  " name="referrerId"
                                               v-model="customer.referrerId"
                                        >

                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="control" class="col-md-2 control-label">授权登录：</label>

                                    <div class="col-md-10">

                                        <select id="isLogin" name="state" class="form-control"
                                                style="width: auto;" v-model="customer.isLogin">
                                            <option value="0">允许</option>
                                            <option value="1" selected>禁止</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group" v-if="customer.isLogin==0">
                                    <label for="email" class="col-md-2 control-label">邮箱：</label>
                                    <div class="col-md-4">
                                        <input id="email" type="text" class="form-control auto" name="email"
                                               v-model="customer.email"
                                        >

                                    </div>
                                    <label for="email" class="col-md-2 control-label">密码：</label>
                                    <div class="col-md-4">
                                        <input id="password" type="password" class="form-control auto" name="password"
                                               v-model="customer.password"
                                        >

                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>负责人</legend>

                                <div class="form-group">
                                    <label for="leader" class="col-md-2 control-label">联系人：</label>
                                    <div class="col-md-10">
                                        <input id="leader" type="text" class="form-control auto" name="leader"
                                               v-model="customer.leader"
                                               :class="{ 'error': $validator.leader.invalid && trySubmit }"
                                               v-validate:leader="{ required: true}" placeholder="不能为空">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-md-2 control-label">手机号：</label>
                                    <div class="col-md-4">
                                        <input id="mobile" type="text" class="form-control auto" name="mobile"
                                               v-model="customer.mobile"
                                               :class="{ 'error': $validator.mobile.invalid && trySubmit }"
                                               v-validate:mobile="{ required: true}" placeholder="不能为空">

                                    </div>
                                    <label for="qq" class="col-md-2 control-label">QQ：</label>
                                    <div class="col-md-4">
                                        <input id="qq" type="text" class="form-control auto" name="qq"
                                               v-model="customer.qq"
                                        >

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tel" class="col-md-2 control-label">电话：</label>
                                    <div class="col-md-4">
                                        <input id="tel" type="text" class="form-control auto" name="tel"
                                               v-model="customer.tel"
                                        >

                                    </div>
                                    <label for="fax" class="col-md-2 control-label">传真：</label>
                                    <div class="col-md-4">
                                        <input id="fax" type="text" class="form-control auto" name="fax"
                                               v-model="customer.fax"
                                        >

                                    </div>
                                </div>
                            </fieldset>


                            <fieldset>
                                <legend>其它信息</legend>
                                <div class="form-group">

                                    <label for="responsibleId" class="col-md-2 control-label">责任人：</label>

                                    <div class="col-md-10">

                                        <select id="responsibleId" name="responsibleId" class="form-control"
                                                style="width: auto;" v-model="customer.responsibleId">
                                            <option value="0" selected>未指定</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="remark" class="col-md-2 control-label">内部备注：</label>

                                    <div class="col-md-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:100px;"
                                                      v-model="customer.remark"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
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
                </form>
            </validator>
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
                initBase: jsonFilter('{{json_encode($initBase)}}'),
                customer: {state: 0, type: 0, source: 0, grade: 0}
            },
            ready: function () {
            },

            watch: {},

            methods: {

                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        //this.$log('customer');
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/customer/create')}}", this.customer)
                            .then(function (response) {
                                        if (response.data.code == 0) {

                                            layer.msg('新增成功', {offset: '2px', time: 2000});
                                            window.location.href = '{{url('/manage/crm/customer')}}';
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data));
                                    }
                            );
                }

            }
        });
    </script>
@endsection
