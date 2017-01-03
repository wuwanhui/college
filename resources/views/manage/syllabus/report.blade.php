@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            课程表
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage')}}"><i class="fa fa-dashboard"></i> 选课系统</a></li>
            <li class="active">课程表</li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <form method="get" class="form-inline">
                                    <div class="input-group">

                                        <select id="type" name="type" class="form-control" style="width: auto;"
                                                v-model="params.termId">
                                            <option v-for="item in terms" v-bind:value="item.id"
                                                    v-text="item.name" v-bind:selected="term.id==item.id"></option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-success" v-on:click="export()">导出</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <form method="Post" class="form-inline">
                            <table class="table table-bordered table-hover ">
                                <thead>
                                <tr style="text-align: center" class="text-center">

                                    <th><a href=""></a></th>
                                    <th colspan="4"><a href="">第一学期</a></th>
                                    <th colspan="4"><a href="">第二学期</a></th>
                                </tr>
                                <tr style="text-align: center" class="text-center">

                                    <td style="min-width: 80px"><a href="">学生</a></td>
                                    <td><a href="">第1月 </a></td>
                                    <td><a href="">第2月</a></td>
                                    <td><a href="">第3月</a></td>
                                    <td><a href="">第4月</a></td>
                                    <td><a href="">第5月</a></td>
                                    <td><a href="">第6月</a></td>
                                    <td><a href="">第7月</a></td>
                                    <td><a href="">第8月</a></td>

                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="item in list.data">
                                    <tr>

                                        <td style="text-align: center">
                                            <span v-text="item.student.name"></span>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==1">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>

                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==2">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==3">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==4">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==5">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==6">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==7">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                        <td>
                                            <template v-for="subItem in item.syllabus">
                                                <template v-if="subItem.agenda_relate.cycle==8">
                                                    <span v-text="subItem.agenda_relate.agenda.name"></span>
                                                    （<span class="text-primary"
                                                           v-text="subItem.agenda_relate.agenda.teacher"></span>）<br>
                                                </template>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </form>
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
        </div>
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var vm = new Vue({
            el: '.content',
            data: {
                list: eval({!!json_encode($studentList)!!}),
                terms: eval({!!json_encode($terms)!!}),
                term: eval({!!json_encode($term)!!}),
                ids: [],
                params: {state: -1, page: 1, termId: 0},
            },
            watch: {
                'params.state': function () {
                    // this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'params.termId': function (val) {
                    if (val != this.term.id) {
                        this.init();
                    }
                }


            },
            ready: function () {

            },
            computed: {
                succeedApply: function (list) {
                    return list.filter(function (item) {
                        return item.state == 0;
                    })
                },
                failureApply: function (list) {
                    return list.filter(function (item) {
                        return item.state != 0;
                    })
                },
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/syllabus/report?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data.studentList;
                                            _self.term = response.data.data.term;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response));
                                    }
                            );
                },
                export: function (form) {
                    var _self = this;


                    this.$http.post("{{url('/manage/syllabus/excel/export')}}", {
                        term_id: _self.term.id,
                    })
                        .then(function (response) {
                                if (response.data.code == -1) {
                                    parent.layer.alert(JSON.stringify(response));
                                    return;
                                }
                                if (response.data.code == 0) {
                                    parent.msg(response.data.msg);
                                    parent.layer.close(frameindex);
                                    parent.vm.init();
                                    return;
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
