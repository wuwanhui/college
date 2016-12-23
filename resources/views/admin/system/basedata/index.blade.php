@extends('layouts.admin')

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
            <div class="col-md-2">
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
                            <li v-for="item in baseTypeList">
                                <a v-text="item.name"
                                   v-on:click="baseData.baseType_id=item.id" v-bind:class="{active:dept.id==0}"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-block margin-bottom">新增分类</button>
            </div>
            <div class="col-md-10">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" v-on:click="create()">新增</button>
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
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr style="text-align: center" class="text-center">
                                    <th style="width: 20px"><input type="checkbox"
                                                                   name="CheckAll" value="Checkid"/></th>
                                    <th style="width: 60px;">序号</th>
                                    <th><a href="">名称</a></th>
                                    <th><a href="">值</a></th>
                                    <th><a href="">系统保留</a></th>
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
                                    <td v-text="item.isSystem==0?'是':'否'">
                                    </td>
                                    <td style="text-align: center" v-text="item.state">
                                    </td>

                                    <td style="text-align: center"><a
                                                href="{{url('/manage/system/basedata/edit/' )}}">编辑</a>
                                        |
                                        <a href="{{url('/manage/system/basedata/delete/' )}}">删除</a>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                            <div class="btn-group">

                            </div>

                            <div class="pull-right">
                                @include("common.page")
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- 新增分类-->
    <div class="modal  " id="createType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增基础分类</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">分类名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="baseType.name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">分类标识：</label>
                            <div class="col-md-9">
                                <input id="code" type="text" class="form-control"
                                       style="width: auto;"
                                       v-model="baseType.code">

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="createType()">保存</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 新增基础数据 -->
    <div class="modal fade" id="createData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增基础数据</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">名称：</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name"
                                       v-model="basedata.name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="value" class="col-md-3 control-label">值：</label>

                            <div class="col-md-9">
                                <input id="value" type="text" class="form-control" name="value"
                                       v-model="basedata.value">

                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" v-on:click="createData()">保存</button>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        var vue = new Vue({
            el: '.content',
            data: {
                lists: [],
                items: [],
                baseTypeList: [],
                baseType: {},
                baseData: {},
                menu: {type: 'system', item: 'basedata'}
            },
            watch: {},

            methods: {
                open: function (_obj, w, h) {
                    layer.open({
                        type: 1,
                        area: ['600px', '360px'],
                        shadeClose: true, //点击遮罩关闭
                        content: $(_obj)
                    });
                },

                load: function (_obj, w, h) {
                    var _load = layer.load();
                    //此处用setTimeout演示ajax的回调
                    setTimeout(function () {
                        layer.close(_load);
                    }, 1000);
                },
                initType: function () {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/basedata/type')}}",
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.baseTypeList = _obj.data.data;
                            } else {
                                alert(_obj.msg);

                            }

                        }
                    });
                },
                initData: function () {
                    var _self = this;
                    //加载数据
                    $.ajax({
                        type: 'GET',
                        url: "{{url('/manage/system/basedata?json')}}+'&pid='" + _self.baseType.id,
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.baseDataList = _obj.data.data;
                            } else {
                                alert(_obj.msg);
                            }

                        }
                    });
                },
                createType: function () {
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
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/system/basedata/create?json')}}",
                        data: _self.baseData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.initType();
                                return;
                            }

                            alert(_obj.msg);
                        }
                    });
                }

            }
        });
        vue.initType();

    </script>
@endsection
