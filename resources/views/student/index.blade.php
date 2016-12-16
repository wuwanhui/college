@extends('layouts.student')

@section('content')
    <section class="content-header">

        <h1>在线选课系统
            <small>v1.0</small>
        </h1>
        <hr/>
    </section>
    <section class="content">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">我的选课</a></li>
            <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">个人信息</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <h4>已选课程</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>学期</th>
                        <th>课程名称</th>
                        <th>任课教师</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in agendaList">
                        <td v-text="item.term.name"></td>
                        <td v-text="item.name"></td>
                        <td v-text="item.teacher.name"></td>
                        <td style="text-align: center" v-text="item.state==0?'生效':'审核中'"></td>
                        <td style="text-align: center"><a v-on:click="delete(item)">删除</a></td>
                    </tr>
                    </tbody>
                </table>
                <h4>可选课程</h4>
                <div v-for="term in termList.data">
                    <h5 v-text="term.name"></h5>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>课程名称</th>
                            <th>任课教师</th>
                            <th>关联课程</th>
                            <th style="width: 100px;">状态</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in term.agendas">
                            <td v-text="item.name"></td>
                            <td v-text="item.teacher.name"></td>
                            <td>
                                <span v-for="subItem in item.children" v-text="subItem.name+','"></span></td>
                            <td style="text-align: center" v-text="item.state==0?'报名中':'停止报名'"></td>
                            <td style="text-align: center"><a v-on:click="add(item)">加入</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="profile">
                <br>
                <div class="row">
                    <div class="col-sm-12">

                        <form enctype="multipart/form-data" class="form-horizontal"  method="POST"
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
                                        <label for="idCar" class="col-sm-2 control-label">身份证号：</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static" v-text="student.idCar"></p>

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
                                                   v-model="student.password">

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="sex" class="col-sm-2 control-label">性别：</label>
                                        <div class="col-sm-10">

                                            <select v-model="student.sex" id="sex" class="form-control" name="sex">
                                                <option value="-1">未知</option>
                                                <option value="0">男生</option>
                                                <option value="0">女生</option>
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
                                                v-bind:class="{disabled1:$validator.invalid}"
                                                v-on:click="save($validator)">修改
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @{{ agendaList|json }}
    </section>
@endsection

@section('script')
    <script type="application/javascript">
        var vm = new Vue({
            el: '.content',
            data: {
                ids: [],
                params: {page: '', state: ''},
                termList: jsonFilter('{{json_encode($termList)}}'),
                agendaList: jsonFilter('{{json_encode($agendaList)}}'),
                student: jsonFilter('{{json_encode(Auth::guard('student')->user())}}'),
                syllabus: {}
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


                }
            },
            ready: function () {
            },

            methods: {
                init: function () {
                    var _self = this;
                    this.$http.get("{{url('/manage/student?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );

                },
                add: function (item) {
                    this.syllabus = item;

                    var _self = this;
                    layer.confirm('确认加入吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        _self.$http.post("{{url('/student/syllabus/add')}}", {
                            student_id: _self.student.id,
                            agenda_id: item.id
                        })
                                .then(function (response) {
                                            if (response.data.code == 0) {
                                                parent.msg('新增成功');
                                                parent.layer.close(frameindex);
                                                parent.vm.init();
                                                return
                                            }
                                            parent.layer.alert(JSON.stringify(response));
                                        }
                                );
                    }, function () {
                        layer.closeAll();
                    });
                },
                search: function () {
                    this.init();
                },

                create: function () {
                    openUrl('{{url('/manage/student/create')}}', '新增学生', 800, 600);
                },
                edit: function (item) {
                    this.student = item;
                    openUrl('{{url('/manage/student/edit')}}?id=' + item.id, '编辑"' + item.name + '"学生', 800, 600);
                },
                delete: function (item) {
                    layer.confirm('您确认要删除“' + item.name + '”吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        layer.msg('的确很重要', {icon: 1});
                    }, function () {
                        layer.msg('也可以这样', {
                            time: 20000, //20s后自动关闭
                            btn: ['明白了', '知道了']
                        });
                    });
                },


            }
        });
    </script>
@endsection

