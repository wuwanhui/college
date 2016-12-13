@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            基础数据
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">基础数据</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title">数据分类</h4>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked ">
                            <li v-for="item in baseTypeList" v-bind:class="{active:baseType==item}">
                                <a v-text="item.name+'-'+item.code"
                                   v-on:click="baseType=item"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" v-on:click="createData()">新增</button>
                            </div>
                            <div class="col-md-10 text-right">
                                <form method="get" class="form-inline">
                                    <div class="input-group">
                                        <select id="type" name="type" class="form-control" style="width: auto;">
                                            <option value="">所有类型</option>
                                            <option value="0">系统帐户</option>
                                            <option value="1">普通帐户</option>
                                            <option value="2">供应商</option>
                                            <option value="3">分销商</option>
                                            <option value="4">会员</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="关键字"
                                               name="key" v-model="params.key">
                                        <span class="input-group-btn">
                                     <button class="btn btn-default" type="button" v-on:click="search()">搜索</button>
                                         <button type="button" class="btn btn-default"
                                                 v-on:click="params={};init();">重置</button>
                                        </span>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-bordered table-hover  table-condensed">
                                <thead>
                                <tr style="text-align: center" class="text-center">
                                    <th style="width: 20px"><input type="checkbox"
                                                                   name="CheckAll" value="Checkid"/></th>
                                    <th style="width: 60px;"><a href="">序号</a></th>
                                    <th><a href="">名称</a></th>
                                    <th><a href="">值</a></th>
                                    <th style="width: 100px;"><a href="">系统保留</a></th>
                                    <th style="width: 100px;">状态</th>
                                    <th style="width: 100px;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in baseDataList">
                                    <td><input type="checkbox"
                                               name="id"/></td>
                                    <td style="text-align: center" v-text="$index+1"></td>
                                    <td v-text="item.name"></td>

                                    <td v-text="item.value">
                                    </td>
                                    <td  style="text-align: center" v-text="item.isSystem==0?'是':'否'">
                                    </td>
                                    <td style="text-align: center" v-text="item.state==0?'启用':'禁用'">
                                    </td>

                                    <td style="text-align: center">
                                        <div v-if="item.isSystem"><a
                                                    href="{{url('/manage/system/basedata/edit/' )}}">编辑</a>
                                            |
                                            <a href="{{url('/manage/system/basedata/delete/' )}}"
                                               v-if="item.isSystem">删除</a>
                                        </div>
                                        <div v-else>系统保留</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"
                                                                                        v-on:click="delete(ids)"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                                @include("common.page")
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- 新增基础数据 -->
        <div class="content" id="createData" tabindex="-1" style="display: none">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">名称：</label>
                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="baseData.name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="value" class="col-md-3 control-label">值：</label>

                            <div class="col-md-9">
                                <input id="value" type="text" class="form-control" name="value"
                                       v-model="baseData.value">

                            </div>
                        </div>
                    </form>
                </div>

                <div class="box-footer text-center">
                    <button type="button" class="btn btn-default">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="saveData()">保存</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'basedata'};
        var vm = new Vue({
            el: '.content',
            data: {
                baseTypeList: jsonFilter('{{json_encode($type)}}'),
                baseDataList: [],
                baseType: null,
                baseData: null,
            },
            watch: {
                'baseType': function () {
                    this.initData();
                }
            },

            methods: {

                initType: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/system/basedata/type')}}").then(function (response) {
                        if (response.data.code == 0) {
                            _self.baseTypeList = response.data.data;
                        } else {
                            alert(response.data.msg);

                        }
                    });
                },
                initData: function () {
                    var _self = this;

                    if (_self.baseType == null) {
                        return;
                    }
                    baseDataList = [];
                    this.$http.get("{{url('/manage/system/basedata?json')}}", {params: {pid: _self.baseType.id}}).then(function (response) {
                        _self.baseDataList = response.data.data.data;
                    });

                },

                saveType: function () {
                    var _self = this;

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/basedata/type')}}",
                        data: _self.baseType,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.initType();
                                layer.msg('保存成功');
                                return;
                            }
                            alert(_obj.msg);
                        }
                    });
                },
                createData: function () {
                    var _self = this;
                    if (this.baseType == null) {
                        layer.msg('请选择基础数据分类');
                        return;
                    }
                    layer.open({
                        type: 1,
                        title: '新增数据',
                        area: ['600px', '400px'],
                        shade: 0.4,
                        closeBtn: 1,
                        shadeClose: false,
                        content: $('#createData')
                    });
                },
                saveData: function () {
                    var _self = this;
                    if (this.baseType == null) {
                        layer.msg('请选择基础数据分类');
                        return;
                    }
                    _self.baseData.baseType_id = _self.baseType.id;

                    this.$http.post('{{url('/manage/system/basedata/create')}}', _self.baseData).then(function (response) {
                        alert(response);
                        if (response.data.code == 0) {
                            _self.initData();
                            return;
                        }

                        alert(response.data.msg);
                    });

                }

            }
        });

    </script>
@endsection
