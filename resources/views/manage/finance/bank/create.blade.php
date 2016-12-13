@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST">

                        <div class="panel-body">
                            <div class="col-xs-12">
                                <fieldset>
                                    <legend>基本信息</legend>
                                    <div class="form-group">
                                        <label for="bankUserName" class="col-sm-2 control-label">户名：</label>

                                        <div class="col-sm-4">
                                            <input id="bankUserName" type="text" class="form-control auto" name="bankUserName"
                                                   v-model="bank.bankUserName" required autofocus>
                                        </div>

                                        <label for="bankTitle" class="col-sm-2 control-label">开户银行：</label>

                                        <div class="col-sm-4">
                                            <input id="bankTitle" type="text" class="form-control auto" name="bankTitle"
                                                   v-model="bank.bankTitle" required autofocus>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                    </div>
                                    <div class="form-group">
                                        <label for="bankNumber" class="col-md-3 control-label">银行账号：</label>

                                        <div class="col-md-9">
                                            <input id="bankNumber" type="number" class="form-control auto" name="bankNumber"
                                                   v-model="bank.bankNumber" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="initialMoney" class="col-md-3 control-label">初始金额：</label>

                                        <div class="col-md-9">
                                            <input id="initialMoney" type="number" class="form-control auto" name="initialMoney"
                                                   v-model="bank.initialMoney" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort" class="col-md-3 control-label">排序：</label>

                                        <div class="col-md-9">
                                            <input id="sort" type="number" class="form-control auto" name="sort"
                                                   v-model="bank.sort" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="state" class="col-md-3 control-label">状态：</label>

                                        <div class="col-md-9">
                                            <select id="state" name="state"  v-model="bank.state" class="form-control" style="width: auto;">
                                                <option value="0" selected>正常</option>
                                                <option value="1">禁用</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="note" class="col-md-3 control-label">描述：</label>

                                        <div class="col-md-9">
                                            <textarea id="note" type="text" class="form-control"
                                                      style="width: 100%,height:50px;"
                                                      v-model="bank.note"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="parent.layer.close(frameindex)">关闭
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="save()">保存</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @include("common.success")
                @include("common.errors")
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vue = new Vue({
            el: '.content',
            data: {
                bank: {}
            },
            watch: {},

            methods: {
                init: function () {
                },
                save: function () {
                    var _self = this;
                    if (_self.bank.bankUserName.length == 0) {
                        return layer.msg('户名不能为空', {icon: 5, time:800});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/finance/bank/create')}}",
                        data: _self.bank,
                        headers: {
                            'X-CSRF-TOKEN': Laravel.csrfToken
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                parent.layer.close(frameindex);
                                parent.layer.msg(_obj.msg, {icon: 6});
                                parent.vue.init();
                            } else {
                                parent.layer.msg(_obj.msg, {icon: 5});
                            }
                        }
                    });
                }

            }
        });
        vue.init();
    </script>
@endsection
