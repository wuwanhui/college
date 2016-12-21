@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            选课记录
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage/crm')}}"><i class="fa fa-dashboard"></i> 选课系统</a></li>
            <li class="active">选课记录</li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" v-on:click="create()">新增</button>
                            </div>
                            <div class="col-md-10 text-right">
                                <form method="get" class="form-inline">
                                    <div class="input-group">

                                        <select id="type" name="type" class="form-control" style="width: auto;"
                                                v-model="term">
                                            <option v-for="item in terms" v-bind:value="item"
                                                    v-text="item.name"></option>
                                        </select>
                                    </div>

                                    <div class="input-group">

                                        <select id="type" name="type" class="form-control" style="width: auto;"
                                                v-model="params.state">
                                            <option value="-1" selected>所有状态</option>
                                            <option v-bind:value="0">正常</option>
                                            <option v-bind:value="1">禁用</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="关键字"
                                               name="key" v-model="params.key">
                                        <span class="input-group-btn">
                                     <button class="btn btn-default" type="button" v-on:click="search()">搜索</button>
                                         <button type="button" class="btn btn-default"
                                                 v-on:click="search(true);">重置</button>
                                        </span>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">按学生</a></li>
                    <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">按课程</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
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
                                            <th style="width: 120px;"><a href="">学号</a></th>
                                            <th style="width: 120px;"><a href="">姓名</a></th>
                                            <th><a href="">所选课程</a></th>
                                            <th style="width: 60px;">状态</th>
                                            <th style="width: 100px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="item in studentList.data">
                                            <tr>
                                                <td><input type="checkbox"
                                                           name="id" v-bind:value="item.id" v-model="ids"/></td>
                                                <td style="text-align: center" v-text="item.id"></td>
                                                <td v-text="item.student_relate.student.name"></td>
                                                <td v-text="item.student_relate.student.number"></td>
                                                <td v-text="item.agenda_relate.agenda.name"></span>
                                                </td>

                                                <td style="text-align: center" v-text="item.state==0?'生效':'审核中'">

                                                </td>

                                                <td style="text-align: center">
                                                    <a v-on:click="edit(item);">编辑</a>
                                                    |
                                                    <a v-on:click="delete(item.id)">删除</a>

                                                </td>
                                            </tr>

                                        </template>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="box-footer no-padding">
                                    <div class="mailbox-controls">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                        class="fa fa-trash-o"
                                                        v-on:click="delete(ids)"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"
                                                                                                    v-on:click="btnBank()"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                        class="fa fa-share" v-on:click="init()"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fa fa-refresh"></i>
                                        </button>
                                        <div class="pull-right">
                                            @include("common.page")
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
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
                                            <th style="width: 120px;"><a href="">教师</a></th>
                                            <th style="width: 120px;"><a href="">报名人数</a></th>
                                            <th style="width: 60px;">状态</th>
                                            <th style="width: 120px;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="item in agendaList.data">
                                            <tr>
                                                <td><input type="checkbox"
                                                           name="id" v-bind:value="item.id" v-model="ids"/></td>
                                                <td style="text-align: center" v-text="item.id"></td>
                                                <td v-text="item.agenda.name"></td>
                                                <td v-text="item.agenda.teacher.name"></td>
                                                <td v-text="item.agenda_student.length"></td>


                                                <td style="text-align: center" v-text="item.state==0?'生效':'审核中'">

                                                </td>

                                                <td style="text-align: center">
                                                    <a v-on:click="edit(item);">编辑</a>
                                                    |
                                                    <a v-on:click="random(item)">随机选</a>
                                                </td>
                                            </tr>

                                        </template>
                                        </tbody>
                                    </table>
                                </form>
                                <div class="box-footer no-padding">
                                    <div class="mailbox-controls">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                        class="fa fa-trash-o"
                                                        v-on:click="delete(ids)"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"
                                                                                                    v-on:click="btnBank()"></i>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                        class="fa fa-share"></i>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fa fa-refresh"></i>
                                        </button>
                                        <div class="pull-right">
                                            @include("common.page")
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @{{ term|json }}
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        var vm = new Vue({
            el: '.content',
            data: {
                studentList: jsonFilter('{{json_encode($studentList)}}'),
                agendaList: jsonFilter('{{json_encode($agendaList)}}'),
                terms: jsonFilter('{{json_encode($terms)}}'),
                syllabus: {},
                term: jsonFilter('{{json_encode($term)}}'),
                ids: [],
                params: {state: -1, page: 1},
            },
            watch: {
                'params.state': function () {
                    // this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'term': function () {
                    Vue.set(this.params, 'termId', this.term.id);
                    this.init();
                }


            },
            ready: function () {
                Vue.set(this.params, 'termId', this.term.id);
                this.term = jsonFilter('{{json_encode($term)}}')
            },

            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/syllabus?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.studentList = response.data.data.studentList;
                                            _self.agendaList = response.data.data.agendaList;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response));
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
                random: function (item) {
                    var _self = this;
                    layer.prompt({title: '请输入随机选择的数量！', formType: 3}, function (text, index) {
                        layer.close(index);
                        //加载数据
                        _self.$http.post("{{url('/manage/syllabus/random')}}", {agendaId: item.id, num: text})
                                .then(function (response) {
                                            if (response.data.code == 0) {
                                                msg(response.data.msg);
                                                _self.init();
                                                return;
                                            }
                                            layer.alert(JSON.stringify(response.data.data));
                                        }
                                );
                    });

                },
                create: function () {
                    openUrl('{{url('/manage/syllabus/create')}}?id=' + this.term.id, '新增选课记录', 800, 300);
                },
                edit: function (item) {
                    this.syllabus = item;
                    openUrl('{{url('/manage/syllabus/edit')}}' + '?id=' + item.id, '编辑"' + item.name + '"选课记录', 800, 300);
                },
                state: function (item) {
                    var _self = this;
                    this.syllabus = item;
                    this.syllabus.state = this.syllabus.state == 0 ? 1 : 0;

                    $.ajax({
                        type: 'POST',
                        url: '{{url('/manage/syllabus/edit')}}',
                        data: _self.syllabus,
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
                        _self.$http.post("{{url('/manage/syllabus/delete')}}", {ids: ids})
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
