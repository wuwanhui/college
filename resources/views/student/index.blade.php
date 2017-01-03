@extends('layouts.student')

@section('content')
    <section class="content">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/student">在线选课系统</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a v-on:click="logout()">退出</a></li>

                    </ul>
                </div>
            </div>
        </nav>
        <h4 v-text="'欢迎'+student.name+'登录系统'"></h4>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">我的选课</a></li>
            <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">个人信息</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6"> 当前学期：<select id="parent_id" name="sex" class="form-control auto"
                                                                v-model="params.term_id">
                                    <option v-bind:value="item.id" v-for="item in termList"
                                            v-bind:selected="termItem.id==item.id"
                                            v-text="item.name"></option>
                                </select></div>
                            <div class="col-sm-6 text-right"><h4 class="text-danger"
                                                                 v-text="'可选4门课程，已选：'+validAgenda.length+'门'"></h4>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="panel panel-success">
                    <!-- Default panel contents -->
                    <div class="panel-heading">已选课程</div>
                    <div class="panel-body">
                        <span v-text="'已选课程共'+validAgenda.length+'门'"></span>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>课程名称</th>
                            <th>时间</th>
                            <th style="width: 100px;">状态</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in validAgenda">
                            <td><a v-on:click="detail(item.agenda_relate.agenda)"
                                   v-text="item.agenda_relate.agenda.name"></a>
                                <p class="text-primary" v-text="'教师：'+item.agenda_relate.agenda.teacher"></p>
                            </td>
                            <td v-text="cycleCN(item.agenda_relate.cycle)"></td>
                            <td style="text-align: center" v-text="item.state==0?'有效':'审核中'"
                                v-bind:class="text-warning:item.state==1">
                            </td>
                            <td style="text-align: center" v-if="item.state==1">
                                <a v-on:click="delete(item)">删除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <template v-if="invalidAgenda.length>0">
                    <div class="panel panel-danger">
                        <div class="panel-heading">无效课程</div>
                        <div class="panel-body">
                            <span v-text="'无效课程共'+invalidAgenda.length+'门'"></span>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>课程名称</th>
                                <th>时间</th>
                                <th style="width: 100px;">状态</th>
                                <th style="width: 100px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in invalidAgenda">


                                <td><a v-on:click="detail(item.agenda_relate.agenda)"
                                       v-text="item.agenda_relate.agenda.name"></a>
                                    <p class="text-primary" v-text="'教师：'+item.agenda_relate.agenda.teacher"></p>
                                </td>
                                <td v-text="cycleCN(item.agenda_relate.cycle)"></td>
                                <td style="text-align: center" v-text="'课程已满'"></td>
                                <td style="text-align: center" v-if="item.state==2">
                                    <a v-on:click="delete(item)">删除</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template v-if="termItem.state==0">
                    <div class="panel panel-primary">
                        <!-- Default panel contents -->
                        <div class="panel-heading">可选课程</div>
                        <div class="panel-body">
                            <h4 v-text="'可选课程共'+termItem.agendas.length+'门，注意：若有关联课程将会自动选择，同一月只能选择一门课程！'"></h4>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>课程名称</th>
                                <th>时间</th>
                                <th style="width: 100px;">状态</th>
                                <th style="width: 100px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in termItem.agendas">
                                <td><a v-on:click="detail(item.agenda)" v-text="item.agenda.name"></a>
                                    <p class="text-primary" v-text="'教师：'+item.agenda.teacher"></p>
                                    <template v-if="item.parent!=null">
                                        <span class="text-warning"
                                              v-text="'关联课程：'+item.parent.agenda.name"></span>
                                        <span class="text-primary"
                                              v-text="'（'+cycleCN(item.parent.cycle)+'）'"></span></template>
                                </td>

                                <td v-text="cycleCN(item.cycle)"></td>
                                <td style="text-align: center" v-text="stateCN(item.state)"></td>
                                <td style="text-align: center">
                                    <template v-if="filterAdd(item)">
                                        <template v-if="!filterData(item)||!filterData(item.parent)">
                                            <span class="text-warning" title="当月已选或关联课程已经包含">当月已选</span>

                                        </template>
                                        <template v-else>
                                            <template v-if="item.state==1">
                                                <a v-on:click="add(item)">加入待选</a>
                                            </template>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <span class="text-error">不可选</span>
                                    </template>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </template>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
                <br>
                <div class="row">
                    <div class="col-sm-12">

                        <form enctype="multipart/form-data" class="form-horizontal" method="POST"
                              novalidate>

                            <div class="box-body">
                                <div class="col-xs-12">


                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">姓名：</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" v-text="student.name"></p>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">学号：</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" v-text="student.number"></p>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email：</label>
                                        <div class="col-sm-10">
                                            <input id="email" type="text" class="form-control" name="email"
                                                   v-model="student.email">

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-2 control-label">密码：</label>
                                        <div class="col-sm-10">
                                            <input id="password" type="password" class="form-control"
                                                   name="password"
                                                   v-model="student.password" v-bind:value="">

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="sex" class="col-sm-2 control-label">性别：</label>
                                        <div class="col-sm-10">

                                            <select v-model="student.sex" id="sex" class="form-control" name="sex">
                                                <option value="-1">未知</option>
                                                <option value="0">男</option>
                                                <option value="1">女</option>
                                            </select>


                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-2 control-label">手机号：</label>
                                        <div class="col-sm-10">
                                            <input id="phone" type="text" class="form-control" name="phone"
                                                   v-model="student.phone">

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="remark" class="col-sm-2 control-label">备注：</label>

                                        <div class="col-sm-10">
                                            <textarea id="remark" type="text" class="form-control"
                                                      style="width: 100%;height:50px;"
                                                      v-model="student.remark"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-xs-12  text-center">

                                        <button type="button" class="btn  btn-default"
                                                v-on:click="save()">修改
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </form>
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
                params: {page: '', state: '', term_id: 0},
                termList: eval({!!json_encode($termList)!!}),
                termItem: eval({!!json_encode($termItem)!!}),
                termStudent: {},
                student: eval({!!json_encode(Base::student())!!}),
                syllabus: {},
                validAgenda: [],
                invalidAgenda: []
            },
            watch: {
                'params.state': function () {
                    this.init();
                },
                'params.page': function () {
                    this.init();
                },
                'student': function () {
                    var _self = this;
                    this.ids = [];
                },
                'params.term_id': function (val) {
                    var _self = this;
                    if (val != this.termItem.id) {
                        this.init();
                    }
                }
            },
            ready: function () {
                this.termStudent = this.termItem.students[0];
//                this.student = this.termItem.students[0].student;
//                this.student.password = '';
                this.syllabus = this.termItem.students[0].syllabus;
                this.initData();
            },

            methods: {
                initData: function () {
                    this.validAgenda = [];
                    this.invalidAgenda = [];
                    for (var i = 0; i < this.termStudent.syllabus.length; i++) {
                        var subItem = this.termStudent.syllabus[i];
                        if (subItem.state != 2) {
                            this.validAgenda.push(subItem);
                        } else {
                            this.invalidAgenda.push(subItem);
                        }
                    }
                },
                filterAdd: function (item) {
                    var _self = this;
                    for (var i = 0; i < _self.termStudent.syllabus.length; i++) {
                        var subItem = _self.termStudent.syllabus[i];
                        if (subItem.agenda_id == item.id) {
                            return false;
                        }
                    }
                    return true;
                },
                filterData: function (item) {
                    var _self = this;
                    for (var i = 0; i < _self.validAgenda.length; i++) {
                        var subItem = _self.validAgenda[i];
                        if (subItem.agenda_relate.cycle == item.cycle) {
                            return false;
                        }
                    }
                    return true;
                },
                init: function () {
                    var _self = this;
                    this.$http.get("{{url('/student?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
//                                           / layer.alert(JSON.stringify(response));
                                            // _self.termList = response.data.termList;
                                            _self.termItem = response.data.data;
                                            _self.termStudent = _self.termItem.students[0];
                                            _self.student = _self.termItem.students[0].student;
                                            _self.syllabus = _self.termItem.students[0].syllabus;
                                            _self.initData();
                                            //_self.termStudent = response.data.data.termStudent;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response));
                                    }
                            );

                },
                detail: function (item) {
                    openUrl('{{url('/student/agenda/detail?id=')}}' + item.id, '课程详情', 800, 600);
                },
                add: function (item) {
                    if (this.validAgenda.length > 3) {
                        return msg('课程已选满！');
                    }
                    this.syllabus = item;
                    var _self = this;
                    layer.confirm('请再次仔细核对自己选择的课程，提交后，将不允许修改！？', {
                        btn: ['确认', '取消']
                    }, function () {
                        _self.$http.post("{{url('/student/syllabus/add')}}", {
                            term_id: _self.termItem.id,
                            student_id: _self.termStudent.id,
                            agenda_id: item.id
                        }).then(function (response) {
                                    if (response.data.code == 0) {
                                        msg(response.data.msg);
                                        _self.init();
                                        return
                                    }
                                    if (response.data.code != -1) {
                                        msg(response.data.msg);
                                        return
                                    }
                                    parent.layer.alert(JSON.stringify(response));
                                }
                        );
                    }, function () {
                        layer.closeAll();
                    });
                },

                save: function () {
                    var _self = this;
                    if (_self.student.email == '') {
                        return msg('邮箱不能为空！');
                    }
                    if (_self.student.password == '') {
                        // return msg('邮箱不能为空！');
                    }
                    this.$http.post("{{url('/student/user/edit')}}", _self.student)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            msg(response.data.msg);
                                            return
                                        }
                                        parent.layer.alert(JSON.stringify(response));
                                    }
                            );
                },
                delete: function (item) {
                    var _self = this;
                    layer.confirm('您确认要删除“' + item.agenda_relate.agenda.name + '”吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        _self.$http.post("{{url('/student/syllabus/delete')}}", {
                            id: item.id,
                        })
                                .then(function (response) {
                                            if (response.data.code == 0) {
                                                msg(response.data.msg);
                                                _self.init();
                                                return
                                            }
                                            parent.layer.alert(JSON.stringify(response));
                                        }
                                );
                    }, function () {

                    });
                },
                logout: function () {
                    var _self = this;
                    layer.confirm('确认退出吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        _self.$http.post("{{url('/student/logout')}}").then(function (response) {
                            if (response.data.code == 0) {
                                msg('退出成功');
                                window.location.href = "/student/login";
                                return
                            }
                            layer.alert(JSON.stringify(response));
                        });
                    }, function () {
                        layer.closeAll();
                    });


                },
                stateCN: function (id) {
                    switch (parseInt(id)) {
                        case 0:
                            return '开课中';
                        case 1:
                            return '报名中';
                        case 2:
                            return '结束报名';
                        case 3:
                            return '取消课程';
                    }
                },
                cycleCN: function (id) {
                    switch (parseInt(id)) {

                        case 1:
                            return '第一月 1周-4周';
                        case 2:
                            return '第二月 5周-8周';
                        case 3:
                            return '第三月 9周-12周';
                        case 4:
                            return '第四月 13周-16周';
                        case 5:
                            return '第五月 1周-4周';
                        case 6:
                            return '第六月 5周-8周';
                        case 7:
                            return '第七月 9周-12周';
                        case 8:
                            return '第八月 13周-16周';
                    }
                },


            }
        });
    </script>
@endsection

