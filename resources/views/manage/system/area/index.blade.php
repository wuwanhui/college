@extends('layouts.app')

@section('content')

    <section class="content-header">
        <h1>
            区域设置
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 管理中心</a></li>
            <li class="active">区域设置</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-4 ">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">省</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" v-on:click="create()"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding ">
                        <ul class="nav nav-pills nav-stacked ">
                            <li v-for="item in provinceList" v-bind:class="{active:provinceItem==item}"><a
                                        v-bind:class="{active:parent==item}"
                                        v-on:click="getProvince(item)" v-text="item.name"></a></li>
                        </ul>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" v-el:addProvince>
                            <span class="input-group-btn">
        <button class="btn btn-default" type="button" v-on:click="save()">新增</button>
      </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 parent" v-if="cityList.length>0">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">市</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" v-on:click="create(provinceItem)"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked ">
                            <li v-for="item in cityList" v-bind:class="{active:cityItem==item}"><a
                                        v-bind:class="{active:parent.id==item.id}"
                                        v-on:click="getCity(item)" v-text="item.name"></a></li>
                        </ul>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" v-el:addProvince>
                            <span class="input-group-btn">
        <button class="btn btn-default" type="button" v-on:click="save()">新增</button>
      </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 parent" v-if="areaList.length>0">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">区</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" v-on:click="create(cityItem)"><i
                                        class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked ">
                            <li v-for="item in areaList" v-bind:class="{active:areaItem==item}"><a
                                        v-bind:class="{active:parent==item}"
                                        v-on:click="getArea(item)" v-text="item.name"></a></li>
                        </ul>
                    </div>
                    <div class="box-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" v-el:addProvince>
                            <span class="input-group-btn">
        <button class="btn btn-default" type="button" v-on:click="save()">新增</button>
      </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script type="application/javascript">
        //sidebar.menu = {type: 'system', item: 'area'};
        //父级
        var vm = new Vue({
            el: '.content',
            data: {
                provinceList: jsonFilter('{{json_encode($list)}}'),
                cityList: [],
                areaList: [],
                provinceItem: {},
                cityItem: {},
                areaItem: {},
                parent: {}
            },
            watch: {},

            methods: {
                init: function () {
                    var _self = this;
                    _self.cityList = [];
                    _self.areaList = [];
                    //加载数据
                    this.$http.get("{{url('/manage/system/area?json')}}")
                            .then(function (response) {
                                if (response.data.code == 0) {
                                    _self.provinceList = response.data.data;

                                } else {
                                    alert(response.data.msg);
                                }
                            });
                },

                save: function (item) {
                    var newArea = {parent_id: 0};
                    if (item != null) {

                    }

                    this.$http.post("{{url('/manage/system/area/create')}}", newArea)
                            .then(function (response) {
                                if (response.data.code == 0) {
                                    this.provinceList.push(response.data.data);
                                    this.$els.addproject.value = '';
                                } else {
                                    alert(response.data.msg);
                                }
                            });

                },
                getProvince: function (item) {
                    var _self = this;
                    _self.cityList = [];
                    _self.areaList = [];
                    _self.provinceItem = item;
                    _self.cityItem = {};
                    _self.areaItem = {};
                    //加载数据
                    this.$http.get("{{url('/manage/system/area?json')}}", {params: {pid: item.id}})
                            .then(function (response) {
                                if (response.data.code == 0) {
                                    _self.cityList = response.data.data;
                                } else {
                                    alert(response.data.msg);
                                }
                            }, function (err) {
                                alert(err);
                            });
                },

                getCity: function (item) {
                    var _self = this;
                    _self.cityItem = item;
                    _self.areaItem = {};
                    //加载数据
                    this.$http.get("{{url('/manage/system/area?json')}}", {params: {pid: item.id}})
                            .then(function (response) {
                                if (response.data.code == 0) {
                                    _self.areaList = response.data.data;
                                } else {
                                    alert(response.data.msg);
                                }
                            });
                },
                getArea: function (item) {
                    var _self = this;
                    _self.areaItem = item;
                },


                create: function (item) {
                    if (item != null) {
                        this.parent = item;
                    } else {
                        this.parent = {id: 0, name: '顶级'};
                    }
                    openUrl('{{url('/manage/system/area/create')}}', '新增区域');
                },
                edit: function (item) {
                    this.area = item;
                    openUrl('{{url('/manage/system/area/edit')}}?id=' + item.id, '编辑"' + item.name + '"区域');
                },
                delete: function (ids) {
                    var _self = this;
                    layer.confirm('确认删除吗？', {
                        btn: ['确认', '取消']
                    }, function () {
                        $.ajax({
                            type: 'POST',
                            url: '{{url('/manage/system/area/delete')}}',
                            data: {ids: ids},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (_obj) {
                                if (_obj.code == 0) {
                                    _self.init();
                                    layer.msg('成功删除' + _obj.data + '条记录！', {icon: 6, time: 1000});
                                } else {
                                    layer.alert(_obj.msg, {icon: 1});
                                }

                            }
                        });
                    }, function () {
                        layer.closeAll();
                    });
                }


            }
        });

    </script>

@endsection