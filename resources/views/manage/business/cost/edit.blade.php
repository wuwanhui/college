@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST">
                        <input type="hidden" id="id" name="id" value="{{$item->id}}" v-model="item.id">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="name" class="col-md-3 control-label">分类名称</label>

                                        <div class="col-md-9">
                                            <input id="name" type="text" class="form-control auto" name="name"
                                                   value="{{$item->name}}" v-model="item.name" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tag" class="col-md-3 control-label">标签信息</label>
                                        <div class="col-md-9">
                                            <input id="tag" type="text" class="form-control" name="tag"
                                                   value="{{$item->tag}}" v-model="item.tag" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="content" class="col-md-3 control-label">内容描述</label>
                                        <div class="col-md-9">
                                            <textarea id="content" name="content" v-model="item.content" class="form-control"  style="width:100%;height: 80px;">{{$item->content}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        <label for="state" class="col-md-3 control-label">状态：</label>

                                        <div class="col-md-6">
                                            <select id="state" name="state" class="form-control" v-model="item.state"
                                                    style="width: auto;">
                                                <option value="0" {{$item->state==0?"selected":""}}>正常</option>
                                                <option value="1" {{$item->state==1?"selected":""}}>禁用</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="state" class="col-md-3 control-label">排序：</label>
                                        <div class="col-md-3">
                                            <input id="sort" type="text" class="form-control auto" name="sort"
                                                   value="{{$item->sort}}" v-model="item.sort" required autofocus>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <button type="button" class="btn btn-default"
                                            onclick="parent.layer.close(frameindex)">关闭
                                    </button>
                                    <button type="button" class="btn  btn-primary" v-on:click="submit()">保存</button>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
        var vue = new Vue({
            el: '.content',
            data: {
                item: {}
            },
            methods: {
                submit: function () {
                    var _self = this;
                    if (_self.item.name.length == 0) {
                        return layer.msg('分类名称不能为空', {icon: 5});
                    }
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/manage/resources/lineclass/edit')}}",
                        data: _self.item,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (_obj) {
                            if (_obj.code == 0) {
                                parent.layer.close(frameindex);
                                parent.layer.msg(_obj.msg, {icon: 6});
                                parent.vm.init();
                            } else {
                                parent.layer.alert(_obj.msg, {icon: 5});
                            }
                        }
                    });
                }

            }
        });


    </script>
@endsection
