@extends('layouts.app')

<!--选择客户-->
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                        <div class="row">
                            <div class="col-md-10">
                                <form method="get" class="form-inline">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="关键字"
                                                   name="key" v-model="params.key">
                                            <span class="input-group-btn">
								<button class="btn btn-default" type="button" v-on:click="init()">搜索</button>
                                     <button type="button" class="btn btn-default" v-on:click="params={};init();">
                                    重置
                                </button>
							</span>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="box box-primary">

                                <form method="Post" class="form-inline">
                                    <fieldset>
                                        <table class="table table-bordered table-hover  table-condensed">
                                            <thead>
                                            <tr style="text-align: center" class="text-center">
                                                <th style="width: 40px;">序号</th>
                                                <th>名称</th>
                                                <th style="width: 100px;">联系人</th>
                                                <th  style="width: 100px;">手机号</th>
                                                <th style="width: 150px;">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="item in list.data">
                                                <td style="text-align: center" v-text="$index+1"></td>
                                                <td style="text-align: center"><a href="javascript:;" v-on:click="choose(item)" v-text="item.name"></a></td>
                                                <td style="text-align: center" v-text="item.leader"></td>
                                                <td style="text-align: center" v-text="item.mobile"></td>
                                                <td style="text-align: center">
                                                    <a
                                                            v-on:click="choose(item)">选择</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </form>
                                <div class="box-footer no-padding">
                                    <div class="mailbox-controls">
                                        <div class="pull-right">
                                            @include("common.page")
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12  text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="parent.layer.close(frameindex)">关闭
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vm = new Vue({
            el: '.content',
            data: {
                params: {page: 1, state: 0},
                list: [],
            },
            watch: {
                //监听参数变化
                'params.page': function () {
                    this.init();
                }
            },created:function(){
                this.params.trend=parent.vm.trafficType;
                this.init();
            },
            methods: {
                init: function () {
                    var _self = this;
                    //加载数据
                    this.$http.get("{{url('/manage/crm/customer?json')}}", {params: this.params})
                            .then(function (response) {
                                        if (response.data.code == 0) {
                                            _self.list = response.data.data;
                                            return
                                        }
                                        layer.alert(JSON.stringify(response.data.data));
                                    }
                            );
                },
                choose:function(item){
                    parent.vm.$set('order.customer_id',item.id);
                    parent.vm.$set('order.cusname',item.name);
                    parent.vm.$set('order.linkman',item.leader);
                    parent.vm.$set('order.linkmanPhone',item.mobile);
                    parent.layer.close(frameindex);
                }
            }
        });
    </script>
@endsection

