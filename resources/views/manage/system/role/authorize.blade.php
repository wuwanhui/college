@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <form method="Post" class="form-inline">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-bordered table-hover  table-condensed">
                            <thead>
                            <tr style="text-align: center" class="text-center">
                                <th style="width: 20px"><input type="checkbox"
                                                               name="CheckAll" value="Checkid"/></th>
                                <th style="width: 60px;"><a href="">编号</a></th>
                                <th><a href="">名称</a></th>
                                <th><a href="">标识</a></th>
                                <th><a href="">父级</a></th>
                                <th><a href="">地址</a></th>
                                <th><a href="">显示</a></th>
                                <th><a href="">描述</a></th>
                                <th style="width: 100px;">状态</th>
                                <th style="width: 100px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in list.data">
                                <td><input type="checkbox"
                                           v-bind:value="item.id" v-model="ids"/></td>
                                <td style="text-align: center" v-text="item.id"></td>
                                <td v-text="item.name"></td>
                                <td v-text="item.code"></td>
                                <td v-text="item.parent.name"></td>
                                <td v-text="item.url"></td>
                                <td v-text="item.isShow==0?'显示':'隐藏'"></td>
                                <td v-text="item.remark">
                                </td>

                                <td style="text-align: center" v-text="item.state==0?'正常':'禁用'">
                                </td>

                                <td style="text-align: center"><a
                                            href="{{url('/manage/system/permission/edit/' )}}">编辑</a>
                                    |
                                    <a href="{{url('/manage/system/permission/delete/' )}}">删除</a>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
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
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-xs-12  text-center">
                <button type="button" class="btn btn-default"
                        onclick="parent.layer.close(frameindex)">关闭
                </button>
                <button type="button" class="btn  btn-primary"
                        v-bind:class="{disabled1:$validator.invalid}" v-on:click="save()">保存
                </button>

            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vm = new Vue({
            el: '.content',
            data: {
                ids: parent.vm.ids,
                role: parent.vm.role,
                list: jsonFilter('{{json_encode($permissions)}}'),
            },
            watch: {},

            methods: {

                save: function (form) {
                    var _self = this;

                    this.$http.post("{{url('/manage/system/role/authorize')}}", {id: this.role.id, ids: this.ids})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            msg('授权成功');
                                            parent.layer.close(frameindex);
                                            parent.vm.init();
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.msg));
                                    }
                            );
                }

            }
        });
    </script>
@endsection
