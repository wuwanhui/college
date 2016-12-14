@extends('layouts.app')
@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <form method="Post" class="form-inline">
                    <table class="table table-bordered table-hover  table-condensed">
                        <thead>
                        <tr style="text-align: center" class="text-center">
                            <th style="width: 20px"><input type="checkbox"
                                                           name="CheckAll" value="Checkid"
                                                           v-on:click="ids=!ids"/>
                            </th>
                            <th style="width: 60px;"><a href="">编号</a></th>
                            <th><a href="">课程名称</a></th>
                            <th style="width: 80px;"><a href="">任课教师</a></th>
                            <th><a href="">备注</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list.data">
                            <td><input type="checkbox"
                                       name="id" v-bind:value="item.id" v-model="ids"/></td>
                            <td style="text-align: center" v-text="item.id"></td>
                            <td v-text="item.name"></td>
                            <td style="text-align: center" v-text="item.teacher.name"></td>
                            <td v-text="item.remark">
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </form>
                <div class="box-footer no-padding">
                    <div class="mailbox-controls">

                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>
                        </button>
                        <div class="pull-right">
                            @include("common.page")
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-xs-12  text-center">
                        <button type="button" class="btn btn-default" onclick="parent.layer.close(frameindex)">
                            关闭
                        </button>
                        <button type="button" class="btn  btn-primary"
                                v-bind:class="{disabled1:$validator.invalid}" v-on:click="bind()">绑定
                        </button>

                    </div>
                </div>
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
                list: jsonFilter('{{json_encode($list)}}'),
                term: parent.vm.term,
                ids: parent.vm.agendaIds,
                params: {state: -1, page: 1},
            },
            watch: {
                'params.state': function () {
                    // this.init();
                },
                'params.page': function () {
                    this.init();
                }
            },
            ready: function () {

            },

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/term/agenda?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response));
                                    }
                            );
                },


                bind: function () {
                    var _self = this;

                    this.$http.post("{{url('/manage/term/bind/agenda')}}", {id: this.term.id, ids: this.ids})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            parent.msg('绑定成功');
                                            parent.layer.close(frameindex);
                                            parent.vm.init();
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },
                search: function (reset) {
                    if (reset) {
                        this.params = {state: -1, page: 1, key: ''};
                        this.init();
                        return
                    }
                    this.init();
                },
                create: function () {
                    openUrl('{{url('/manage/term/create')}}', '新增学期', 800, 600);
                },
                edit: function (item) {
                    this.term = item;
                    openUrl('{{url('/manage/term/edit')}}' + '?id=' + item.id, '编辑"' + item.name + '"学期', 800, 600);
                },
                state: function (item) {
                    var _self = this;
                    this.term = item;
                    this.term.state = this.term.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/term/edit')}}',
                        data: _self.term,
                        headers: {
                            'X-CSRF-TOKEN': Laravel.csrfToken
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                _self.init();
                                layer.msg('状态修改成功！', {icon: 6, time: 1000});
                            } else {
                                layer.alert(_obj.msg, {icon: 1});
                            }

                        }
                    });
                },
                delete: function (ids) {
                    var _self = this;
                    layer.confirm('确认删除吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        _self.$http.post("{{url('/manage/term/delete')}}", {ids: ids})
                                .then(function (response) {
                                            if (response.data.code == 0) {
                                                _self.init();
                                                layer.closeAll();
                                                msg('成功删除' + response.data.data + '条记录！');
                                                return
                                            }
                                            layer.alert(JSON.stringify(response));
                                        }
                                );
                    }, function () {
                        layer.closeAll();
                    });
                }


            }
        });

    </script>
@endsection
