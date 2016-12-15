@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            学期管理
            <small>客户详情</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/manage')}}"><i class="fa fa-dashboard"></i> 选课系统</a></li>
            <li class="active">学期管理</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header">
                <h3><span v-text="term.name"></span>
                    <small v-text="term.affiliation"></small>
                </h3>
                <hr/>
            </div>

            <div class="box-body">
                <table class="table table-bordered detail">
                    <tbody>
                    <tr>
                        <th style="width:200px;">课程数:</th>
                        <td v-text="agendas.total"></td>
                        <th style="width:200px;">学生数:</th>
                        <td v-text="students.total"></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

                <li role="presentation" class="active"><a href="#agenda" role="tab"
                                                          data-toggle="tab">课程安排</a></li>
                <li role="presentation"><a href="#student" role="tab" data-toggle="tab">参与学生</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="active tab-pane" id="agenda">
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
                            <th><a href="">关联课程</a></th>
                            <th><a href="">备注</a></th>
                            <th style="width: 60px;">状态</th>
                            <th style="width: 100px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in agendas.data">
                            <td><input type="checkbox"
                                       name="id" v-bind:value="item.id" v-model="ids"/></td>
                            <td style="text-align: center" v-text="item.id"></td>
                            <td v-text="item.name"></td>
                            <td style="text-align: center" v-text="item.teacher.name"></td>
                            <td><span v-for="subItem in item.children" v-text="subItem.name+','"></span></td>
                            <td v-text="item.remark">
                            </td>

                            <td style="text-align: center"><a
                                        v-bind:class="{'text-warning':item.state==1 }"
                                        v-on:click="state(item);" v-text="item.state_cn"></a>
                            </td>

                            <td style="text-align: center">
                                <a v-on:click="delete(item.id)">移除</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="button" class="btn  btn-primary ui fluid large teal submit button"
                                v-on:click="bindAgenda()">绑定课程
                        </button>
                    </div>
                </div>
                <div class="tab-pane" id="student">
                    <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST">

                        <table class="table table-bordered table-hover  table-condensed">
                            <thead>
                            <tr style="text-align: center" class="text-center">
                                <th style="width: 20px"><input type="checkbox"
                                                               name="CheckAll" value="Checkid"/></th>
                                <th style="width: 60px;"><a href="">编号</a></th>
                                <th>姓名</th>
                                <th><a href="">学号</a></th>
                                <th><a href="">身份证号</a></th>
                                <th><a href="">邮箱</a></th>
                                <th><a href="">性别</a></th>
                                <th><a href="">手机号</a></th>
                                <th style="width: 100px;">状态</th>
                                <th style="width: 100px;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in students.data">
                                <td><input type="checkbox" v-model="ids" v-bind:value="item.id"/></td>
                                <td style="text-align: center" v-text="item.id"></td>
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
                                <td style="text-align: center" v-text="item.state_cn"></td>

                                <td style="text-align: center">
                                    <a v-on:click="delete(item)">移除</a>

                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <div class="text-center">
                            <button type="button" class="btn  btn-primary ui fluid large teal submit button"
                                    v-on:click="bindStudent()">绑定学生
                            </button>
                        </div>
                    </form>

                </div>


            </div>
        </div>
        @{{ agendas|json }}
    </section>
@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'crm', item: 'term'};
        var vm = new Vue({
            el: '.content',
            data: {
                trySubmit: false,
                term: jsonFilter('{{json_encode($term)}}'),
                agendas: jsonFilter('{{json_encode($agendas)}}'),
                students: jsonFilter('{{json_encode($students)}}'),
            },
            ready: function () {
            },

            watch: {},

            methods: {
                bindAgenda: function (item) {
                    this.term = item;
                    openUrl('{{url('/manage/term/bind/agenda')}}', '绑定课程', 800, 400);
                },
                bindStudent: function (item) {
                    this.term = item;
                    openUrl('{{url('/manage/term/bind/student')}}', '绑定学生', 800, 400);
                },
                save: function (form) {
                    var _self = this;

                    if (form.invalid) {
                        this.trySubmit = true;
                        return;
                    }

                    this.$http.post("{{url('/manage/crm/term/edit')}}", this.term)
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            msg('编辑成功');
                                            window.location.href = '{{url('/manage/crm/term')}}';
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data));
                                    }
                            );
                },
                delete: function () {
                    var _self = this;
                    layer.confirm('确认删除"' + _self.term.name + '"吗？', {
                                btn: ['确认', '取消']
                            }, function () {
                                _self.$http.post("{{url('/manage/crm/term/delete')}}", {ids: _self.term.id})
                                        .then(function (response) {
                                                    if (response.data.code == 0) {
                                                        msg('成功删除' + response.data.data + '条记录！');
                                                        window.location.href = '{{url('/manage/crm/term')}}';
                                                        return
                                                    }
                                                    layer.alert(JSON.stringify(response.data));
                                                }
                                        );
                            }, function () {
                                layer.closeAll();
                            }
                    )
                    ;
                }

            }
        });
    </script>
@endsection
