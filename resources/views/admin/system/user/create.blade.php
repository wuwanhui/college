@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="panel panel-default">
            <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2  text-left">
                            <button type="button" class="btn btn-default"
                                    onclick="vbscript:window.history.back()">返回
                            </button>
                            <button type="submit" class="btn  btn-primary">保存</button>

                        </div>
                        <div class="col-xs-10 text-right"></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
                        <fieldset>
                            <legend>基本信息</legend>
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-3 control-label">用户名</label>

                                <div class="col-md-9">
                                    <input id="name" type="text" class="form-control auto" name="name"
                                           value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-3 control-label">电子邮件</label>

                                <div class="col-md-9">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-3 control-label">密码</label>

                                <div class="col-md-9">
                                    <input id="password" type="password" class="form-control auto"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-3 control-label">确认密码</label>

                                <div class="col-md-9">
                                    <input id="password-confirm" type="password" class="form-control auto"
                                           name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                <label for="state" class="col-md-3 control-label">状态：</label>

                                <div class="col-md-9">
                                    <select id="state" name="state" class="form-control" style="width: auto;">
                                        <option value="0">有效</option>
                                        <option value="1">无效</option>
                                    </select>

                                    @if ($errors->has('state'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </div>
            </form>
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
                role: {}
            },
            watch: {},

            methods: {
                init: function () {
                },
                submit: function () {
                    var _self = this;
                    if (_self.role.name.length == 0) {
                        return layer.msg('角色名不能为空', {icon: 5, time: 2});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/admin/system/role/create')}}",
                        data: _self.role,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
