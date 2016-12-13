@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="panel-body">
                            <fieldset>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">姓名：</label>
                                    <div class="col-sm-4">
                                        <input id="name" type="text" class="form-control"
                                               v-model="contact.name" placeholder="必填"/>
                                    </div>
                                    <label for="mobilePhone" class="col-sm-2 control-label">手机号：</label>
                                    <div class="col-sm-4">
                                        <input id="mobilePhone" type="text" class="form-control"
                                               v-model="contact.mobilePhone"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deptName" class="col-sm-2 control-label">部门：</label>
                                    <div class="col-sm-4">
                                        <input id="deptName" type="text" class="form-control"
                                               v-model="contact.deptName"/>
                                    </div>
                                    <label for="position" class="col-sm-2 control-label">职位：</label>
                                    <div class="col-sm-4">
                                        <input id="position" type="text" class="form-control"
                                               v-model="contact.position"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telephone" class="col-sm-2 control-label">电话：</label>
                                    <div class="col-sm-4">
                                        <input id="telephone" type="text" class="form-control"
                                               v-model="contact.telephone"/>
                                    </div>
                                    <label for="fax" class="col-sm-2 control-label">传真：</label>
                                    <div class="col-sm-4">
                                        <input id="fax" type="text" class="form-control"
                                               v-model="contact.fax"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qq" class="col-sm-2 control-label">QQ：</label>
                                    <div class="col-sm-4">
                                        <input id="qq" type="text" class="form-control"
                                               v-model="contact.qq"/>
                                    </div>
                                    <label for="sort" class="col-sm-2 control-label">排序：</label>
                                    <div class="col-sm-4">
                                        <input id="sort" type="number" class="form-control"
                                               v-model="contact.sort"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qq" class="col-sm-2 control-label">备注：</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="remark"
                                                  v-model="contact.remark"
                                                  style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-4">
                                        <select id="state" name="state" class="form-control" v-model="contact.state"
                                                style="width: auto;">
                                            <option value="0" selected="selected">正常</option>
                                            <option value="1">禁用</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="parent.layer.close(frameindex)">关闭
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save()">保存
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vm = new Vue({
            el: '.content',
            data: {
                contact: {supplier_id:parent.vm.sid}
            },
            methods: {
                save: function () {
                    var _self = this;
                    //提交保存
                    this.$http.post("{{url('/manage/resources/supplier/contacts/save')}}", _self.contact).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            parent.layer.close(frameindex);
                            parent.msg('联系人新增成功!');
                            parent.vm.init();
                        } else {
                            parent.layer.alert(_obj.msg, {icon: 5});
                        }
                    }, function (erro) {
                        parent.layer.alert(erro, {icon: 5});
                    });
                }

            }
        });


    </script>
@endsection

