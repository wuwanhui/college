@extends('layouts.app')
@section('content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-body no-padding">

                <form method="Post" class="form-inline">
                    <table class="table table-bordered table-hover  table-condensed">
                        <thead>
                        <tr style="text-align: center" class="text-center">
                            <th style="width: 60px;">序号</th>
                            <th>姓名</th>
                            <th><a href="">学号</a></th>
                            <th><a href="">身份证号</a></th>
                            <th><a href="">邮箱</a></th>
                            <th><a href="">性别</a></th>
                            <th><a href="">手机号</a></th>
                            <th><a href="">操作</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in list.data">
                            <td style="text-align: center" v-text="$index+1"></td>
                            <td style="text-align: center" v-text="item.name"></td>

                            <td style="text-align: center" v-text="item.number">
                            </td>
                            <td style="text-align: center" v-text="item.idCar">
                            </td>
                            <td v-text="item.email">
                            </td>
                            <td style="text-align: center" v-text="item.sex_cn">
                            </td>
                            <td v-text="item.phone">
                            </td>
                            <td style="text-align: center"><a v-on:click="bind(item)">加入</a>
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

        </div>
        <div class="row">
            <div class="col-xs-12  text-center">
                <button type="button" class="btn btn-primary"
                        onclick="parent.layer.close(frameindex)">
                    关闭
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
                list: [],
                term: parent.vm.term,
                ids: [],
                student: {},
                params: {state: 0, page: 1},
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
                this.init();
            },

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.post("{{url('/manage/term/student?json')}}", this.params)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return;
                                        }
                                        layer.alert(JSON.stringify(response));
                                    }
                            );
                },


                bind: function (item) {
                    var _self = this;
                    this.student = item;
                    this.$http.post("{{url('/manage/term/bind/student')}}", {
                        term_id: _self.term.id,
                        student_id: _self.student.id
                    })
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


            }
        });

    </script>
@endsection
