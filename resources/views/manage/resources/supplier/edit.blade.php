@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            编辑供应商
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>资源中心</a></li>
            <li><a href="/manage/resources/supplier">供应商管理</a></li>
            <li class="active">编辑供应商</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <input type="hidden" v-model="id"/>
                    <div class="box box-primary">
                        <div class="box-body">
                            <fieldset>
                                <legend>基本信息</legend>
                                <div class="form-group">
                                    <label for="code" class="col-sm-2 control-label">供应商代码：</label>
                                    <div class="col-sm-3">
                                        <input id="code" type="text" class="form-control"
                                               v-model="supplier.code"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">供应商名称：</label>
                                    <div class="col-sm-8">
                                        <input id="name" type="text" class="form-control"
                                               v-model="supplier.name" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">供应类型：</label>
                                    <div class="col-sm-8">
                                        <label v-for="(key,value) in supplier.type_list"><input id="fly"
                                                                                                type="checkbox"
                                                                                                v-bind:value="key"
                                                                                                v-model="datalist"/>@{{value}}
                                            &nbsp;</label>
                                        {{--<label><input id="fly" type="checkbox" value="1" v-model="supplier.type"/>机票</label>&nbsp;--}}
                                        {{--<label><input id="train" type="checkbox" value="2" v-model="supplier.type"/>火车票</label>&nbsp;--}}
                                        {{--<label><input id="car" type="checkbox" value="3" v-model="supplier.type"/>汽车票</label>&nbsp;--}}
                                        {{--<label><input id="hotel" type="checkbox" value="4" v-model="supplier.type"/>酒店</label>&nbsp;--}}
                                        {{--<label><input id="ticket" type="checkbox" value="5" v-model="supplier.type"/>门票</label>&nbsp;--}}
                                        {{--<label><input id="djs" type="checkbox" value="6" v-model="supplier.type"/>地接社</label>&nbsp;--}}
                                        {{--<label><input id="jp" type="checkbox" value="7" v-model="supplier.type"/>餐饮</label>--}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="province" class="col-sm-2 control-label">所属区域：</label>
                                    <div class="col-sm-8 form-inline">
                                        <input id="province" type="text" class="form-control"
                                               v-model="supplier.province" placeholder="选择省份">
                                        <input id="city" type="text" class="form-control"
                                               v-model="supplier.city" placeholder="选择城市">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">公司地址：</label>
                                    <div class="col-sm-8">
                                        <input id="address" type="text" class="form-control"
                                               v-model="supplier.address" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">公司网址：</label>
                                    <div class="col-sm-8">
                                        <input id="url" type="text" class="form-control"
                                               v-model="supplier.url"/>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>主联系人</legend>
                                <div class="form-group">
                                    <label for="header" class="col-sm-2 control-label">负责人：</label>
                                    <div class="col-sm-8">
                                        <input id="header" type="text" class="form-control"
                                               v-model="supplier.header">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobilePhone" class="col-sm-2 control-label">手机号：</label>
                                    <div class="col-sm-8">
                                        <input id="mobilePhone" type="text" class="form-control"
                                               v-model="supplier.mobilePhone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telephone" class="col-sm-2 control-label">电话：</label>
                                    <div class="col-sm-8">
                                        <input id="telephone" type="text" class="form-control"
                                               v-model="supplier.telephone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fax" class="col-sm-2 control-label">传真：</label>
                                    <div class="col-sm-8">
                                        <input id="fax" type="text" class="form-control"
                                               v-model="supplier.fax">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qq" class="col-sm-2 control-label">QQ：</label>
                                    <div class="col-sm-8">
                                        <input id="qq" type="text" class="form-control"
                                               v-model="supplier.qq">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">邮箱：</label>
                                    <div class="col-sm-8">
                                        <input id="email" type="text" class="form-control"
                                               v-model="supplier.email">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>其他</legend>
                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">备注说明：</label>
                                    <div class="col-sm-8">
                                                <textarea class="form-control" id="remark"
                                                          v-model="supplier.remark"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-md-2 control-label">排序：</label>
                                    <div class="col-md-3">
                                        <input id="sort" type="number" class="form-control auto" name="sort"
                                               value="0" v-model="supplier.sort" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-md-2 control-label">状态：</label>
                                    <div class="col-md-6">
                                        <select id="state" name="state" class="form-control" v-model="supplier.state"
                                                style="width: auto;">
                                            <option value="0" selected="selected">正常</option>
                                            <option value="1">禁用</option>
                                        </select>
                                    </div>

                                </div>
                            </fieldset>

                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">
                                        <i class="fa fa-reply"></i> 返回列表
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save()"><i class="fa fa-save"></i> 提交保存
                                    </button>
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
        //sidebar.menu = {type: 'resources', item: 'supplier'};
        var vm = new Vue({
            el: '.content',
            data: {
                supplier: jsonFilter('{{json_encode($supplier)}}'),
                datalist:[]
            },
            ready:function () {
                this.datalist= '{{$supplier->type}}'.split(',');
            },
            methods: {
                save: function () {
                    var _self = this;
                    if (_self.supplier.name.length == 0) {
                        return layer.msg('供应商名称不能为空！', {icon: 5});
                    }
                    _self.supplier.type=_self.datalist;
                    if (_self.supplier.type.length == 0) {
                        return layer.msg('请为供应商至少选择一项供应类型！', {icon: 5});
                    }
                    this.$http.post("{{url('/manage/resources/supplier/save')}}", _self.supplier).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            layer.msg('保存成功！');
                            location.href='{{url('/manage/resources/supplier')}}';
                        } else {
                            layer.alert(_obj.msg, {icon: 5});
                        }
                    }, function (erro) {
                        layer.alert(erro, {icon: 5});
                    });
                }

            }
        });


    </script>
@endsection

