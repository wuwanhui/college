@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2 leftMenu">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">演示系统</div>

                            <div class="panel-body">
                                这个是模型说明
                            </div>
                            <ul class="list-group subMenu">
                                <li class="list-group-item active"><a href="{{url('/manage/demo')}}">列表页</a></li>
                                <li class="list-group-item"><a href="{{url('/manage/demo/create')}}"
                                    >新增</a></li>
                            </ul>
                        </div>
                        <div class="panel panel-warning">
                            <div class="panel-heading">子菜单分区</div>

                            <ul class="list-group subMenu">
                                <li class="list-group-item active"><a href="{{url('/manage/demo')}}">报表</a></li>
                                <li class="list-group-item"><a href="{{url('/manage/demo/create')}}"
                                    >新增</a></li>
                                <li class="list-group-item"><a href="{{url('/manage/demo')}}"
                                    >企业管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <ol class="breadcrumb">
                    <li><a href="#">供应商系统</a></li>
                    <li class="active">演示模型</li>
                </ol>
                <form class="form-horizontal" role="form" method="POST">
                    <div class="panel panel-info">

                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6  text-left">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">返回
                                    </button>
                                    <a href="{{url('/manage/demo/edit/'.$demo->id)}}"
                                       class="btn btn-primary">编辑</a>
                                    <a href="{{url('/manage/demo/delete/'.$demo->id)}}"
                                       class="btn btn-warning">删除</a>

                                </div>
                                <div class="col-xs-6 text-right"><a href="{{url('/manage/demo/print/'.$demo->id)}}"
                                                                    class="btn btn-info">打印</a></div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="col-xs-12">
                                <h3>{{ $demo->name }}
                                    @if(isset($demo->liable))
                                        <small>责任人：{{$demo->liable->name}}</small>
                                    @endif
                                </h3>
                                <hr/>
                                <div class="form-group ">
                                    <div class="col-md-4">
                                        <p class="form-control-static">名称：{{ $demo->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        @if(isset($demo->parent)) <p class="form-control-static">
                                            所属上级：{{$demo->parent->name}}</p>@endif

                                    </div>
                                    <div class="col-md-4">
                                        <p class="form-control-static">状态：{{$demo->state==0?"正常":"禁用" }}</p>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <div class="col-md-4">
                                        <p class="form-control-static">名称：{{ $demo->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        @if(isset($demo->parent)) <p class="form-control-static">
                                            所属上级：{{$demo->parent->name}}</p>@endif

                                    </div>
                                    <div class="col-md-4">
                                        <p class="form-control-static">状态：{{$demo->state==0?"正常":"禁用" }}</p>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <div class="col-md-4">
                                        <p class="form-control-static">名称：{{ $demo->name }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        @if(isset($demo->parent)) <p class="form-control-static">
                                            所属上级：{{$demo->parent->name}}</p>@endif

                                    </div>
                                    <div class="col-md-4">
                                        <p class="form-control-static">状态：{{$demo->state==0?"正常":"禁用" }}</p>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <div class="col-md-6">
                                        <p class="form-control-static">名称：{{ $demo->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        @if(isset($demo->parent)) <p class="form-control-static">
                                            所属上级：{{$demo->parent->name}}</p>@endif

                                    </div>


                                </div>
                                <div class="form-group ">
                                    <div class="col-md-4">
                                        <p class="form-control-static">名称：{{ $demo->name }}</p>
                                    </div>
                                    <div class="col-md-4">


                                    </div>
                                    <div class="col-md-4">
                                        <p class="form-control-static">状态：{{$demo->state==0?"正常":"禁用" }}</p>
                                    </div>

                                </div>
                                <div class="form-group   ">
                                    <div class="col-md-12">
                                        <p class="form-control-static">内部备注：{{ $demo->remark }}</p>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th style="width: 80px;">责任人</th>
                                <td> @if(isset($demo->parent))
                                        所属上级：{{$demo->parent->name}} @endif</td>
                                <th style="width: 80px;">责任人</th>
                                <td> @if(isset($demo->parent))
                                        所属上级：{{$demo->parent->name}} @endif</td>
                                <th style="width: 80px;">责任人</th>
                                <td> @if(isset($demo->parent))
                                        所属上级：{{$demo->parent->name}} @endif</td>
                            </tr>
                            <tr>
                                <th style="width: 80px;">责任人</th>
                                <td> @if(isset($demo->parent))
                                        所属上级：{{$demo->parent->name}} @endif</td>
                                <th style="width: 80px;">责任人</th>
                                <td> @if(isset($demo->parent))
                                        所属上级：{{$demo->parent->name}} @endif</td>
                                <th style="width: 80px;">责任人</th>
                                <td> @if(isset($demo->parent))
                                        所属上级：{{$demo->parent->name}} @endif</td>
                            </tr>
                            <tr>
                                <th style="width: 80px;">内部备注</th>
                                <td colspan="4">{{$demo->remark}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                @include("common.success")
                @include("common.errors") </div>
        </div>
    </div>
@endsection
