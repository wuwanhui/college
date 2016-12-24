@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <validator name="validator">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST"
                      novalidate>

                    <div class="box-body">
                        <div class="col-xs-12">

                            <fieldset>
                                <legend>基本信息</legend>

                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">课程名称：</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static"
                                           v-text="agenda.name"></p>


                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="teacher_id" class="col-sm-2 control-label">任课教师：</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static"
                                           v-text="agenda.teacher"></p>


                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">课程附件：</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">


                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">课程介绍：</label>

                                    <div class="col-sm-10">
                                        <p class="form-control-static"
                                           v-text="agenda.remark"></p>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-12  text-center">
                                <button type="button" class="btn btn-default" onclick="parent.layer.close(frameindex)">
                                    关闭
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </validator>
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
                trySubmit: false,
                agenda: eval({!!json_encode($agenda)!!}),
            },
            watch: {},
            ready: function () {
                this.init();
            },

            methods: {
                init: function () {

                },
            }
        });
    </script>
@endsection
