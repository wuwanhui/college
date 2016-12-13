@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            导游/领队管理
            <small>修改</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>资源中心</a></li>
            <li><a href="/manage/resources/guide">导游/领队管理</a></li>
            <li class="active">修改</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <div class="box box-primary">
                        <div class="box-body">
                            <fieldset>
                                <legend>基本信息</legend>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">名称：</label>
                                    <div class="col-sm-4">
                                        <input id="name" type="text" class="form-control"
                                               v-model="guide.name">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="englishName" type="text" class="form-control"
                                               v-model="guide.englishName" placeholder="英文名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sex" class="col-sm-2 control-label">性别：</label>
                                    <div class="col-sm-2">
                                        <label><input type="radio" name="sex" value="男" v-model="guide.sex"/> 男</label>
                                        <label><input type="radio" name="sex" value="女" v-model="guide.sex"/> 女</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="col-sm-2 control-label">类型：</label>
                                    <div class="col-sm-3">
                                        <label><input type="radio" name="type" value="1" v-model="guide.type"/> 导游</label>
                                        <label><input type="radio" name="type" value="2" v-model="guide.type"/> 领队</label>
                                        <label><input type="radio" name="type" value="3" v-model="guide.type"/> 导游/领队</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="birthDate" class="col-sm-2 control-label">出生年月：</label>
                                    <div class="col-sm-4">
                                        <input id="birthDate" type="text" class="form-control"
                                               v-model="guide.birthDate">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="birthPlace" type="text" class="form-control"
                                               v-model="guide.birthPlace" placeholder="出生地">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobilePhone" class="col-sm-2 control-label">手机号：</label>
                                    <div class="col-sm-4">
                                        <input id="mobilePhone" type="text" class="form-control"
                                               v-model="guide.mobilePhone">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="nationality" type="text" class="form-control"
                                               v-model="guide.nationality" placeholder="国籍">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company" class="col-sm-2 control-label">所属公司：</label>
                                    <div class="col-sm-8">
                                        <input id="company" type="text" class="form-control"
                                               v-model="guide.company">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="languages" class="col-sm-2 control-label">语种：</label>
                                    <div class="col-sm-3 checkbox">
                                        <label><input type="checkbox" name="languages" value="英语" v-model="languages"/> 英语</label>
                                        <label><input type="checkbox" name="languages" value="日语" v-model="languages"/> 日语</label>
                                        <label><input type="checkbox" name="languages" value="德语" v-model="languages"/> 德语</label>
                                        <label><input type="checkbox" name="languages" value="法语" v-model="languages"/> 法语</label>
                                        <label><input type="checkbox" name="languages" value="俄语" v-model="languages"/> 俄语</label>
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend>证件信息</legend>
                                <div class="form-group">
                                    <label for="idNumber" class="col-sm-2 control-label">身份证号：</label>
                                    <div class="col-sm-8">
                                        <input id="idNumber" type="text" class="form-control"
                                               v-model="guide.idNumber">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="guideNumber" class="col-sm-2 control-label">导游证号：</label>
                                    <div class="col-sm-4">
                                        <input id="guideNumber" type="text" class="form-control"
                                               v-model="guide.guideNumber">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="guideVld" type="text" class="form-control"
                                               v-model="guide.guideVld" placeholder="导游证有效期">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="leaderNumber" class="col-sm-2 control-label">领队证号：</label>
                                    <div class="col-sm-4">
                                        <input id="leaderNumber" type="text" class="form-control"
                                               v-model="guide.leaderNumber">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="learderVld" type="text" class="form-control"
                                               v-model="guide.learderVld" placeholder="领队证有效期">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passportNumber" class="col-sm-2 control-label">护照号：</label>
                                    <div class="col-sm-4">
                                        <input id="passportNumber" type="text" class="form-control"
                                               v-model="guide.passportNumber">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="passportVld" type="text" class="form-control"
                                               v-model="guide.passportVld" placeholder="护照有效日期">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passportIssueDate" class="col-sm-2 control-label">护照签发日期：</label>
                                    <div class="col-sm-4">
                                        <input id="passportIssueDate" type="text" class="form-control"
                                               v-model="guide.passportIssueDate">
                                    </div>
                                    <div class="col-sm-4">
                                        <input id="passportIssueAdr" type="text" class="form-control"
                                               v-model="guide.passportIssueAdr" placeholder="护照签发地">
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend>其他</legend>
                                <div class="form-group">
                                    <label for="introduction" class="col-sm-2 control-label">个人简介：</label>
                                    <div class="col-sm-8">
                                                <textarea class="form-control" id="remark"
                                                          v-model="guide.introduction"
                                                          style="width:100%;height: 80px;"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-md-2 control-label">排序：</label>
                                    <div class="col-md-3">
                                        <input id="sort" type="number" class="form-control auto" name="sort" v-model="guide.sort">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state" class="col-md-2 control-label">状态：</label>
                                    <div class="col-md-6">
                                        <select id="state" name="state" class="form-control" v-model="guide.state"
                                                style="width: auto;">
                                            <option value="0">正常</option>
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
                                    <button type="button" class="btn  btn-primary" v-on:click="save()"><i
                                                class="fa fa-save"></i> 提交保存
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
        //sidebar.menu = {type: 'resources', item: 'guide'};
        var vm = new Vue({
            el: '.content',
            data: {
                guide: jsonFilter('{{json_encode($item)}}'),
                languages:[]
            },
            ready:function () {
                this.languages= '{{$item->languages}}'.split(',');
            },
            methods: {
                save: function () {
                    var _self = this;
                    if (_self.guide.name.length == 0) {
                        return layer.msg('名称不能为空！', {icon: 5});
                    }
                    _self.guide.language=_self.languages;
                    this.$http.post("{{url('/manage/resources/guide/save')}}", _self.guide).then(function (resspose) {
                        var _obj = resspose.data;
                        if (_obj.code == 0) {
                            msg(_obj.msg);
                            location.href = '{{url('/manage/resources/guide')}}';
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

