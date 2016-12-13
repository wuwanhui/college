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
                    <div class="panel panel-info panel-input">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6  text-left">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">返回
                                    </button>
                                    <button type="submit" class="btn  btn-primary">保存</button>

                                </div>
                                <div class="col-xs-6 text-right"></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            {{ csrf_field() }}
                            <div class="col-xs-12">
                                <fieldset>
                                    <legend>基本信息</legend>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-3 control-label">名称：</label>

                                        <div class="col-md-9">
                                            <input id="name" type="text" class="form-control" name="name"

                                                   value="{{ $demo->name }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(isset($demos))
                                        <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                            <label for="parent_id" class="col-md-3 control-label">所属上级：</label>

                                            <div class="col-md-9">
                                                <select name="parent_id" id="parent_id" class="form-control"
                                                        style="width: auto;">
                                                    <option value="0">请选择所属上级</option>
                                                    @foreach($demos as $item)
                                                        <option value="{{$item->id}}" {{$demo->id==$item->id? "selected":""}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('parent_id'))
                                                    <span class="help-block">
                                        <strong>{{ $errors->first('parent_id') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif


                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        <label for="state" class="col-md-3 control-label">状态：</label>

                                        <div class="col-md-9">
                                            <select id="state" name="state" class="form-control" style="width: auto;">
                                                <option value="0" {{$demo->state==0? "selected":""}}>正常</option>
                                                <option value="1" {{$demo->state==1? "selected":""}}>禁用</option>
                                            </select>

                                            @if ($errors->has('state'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('remark') ? ' has-error' : '' }}">
                                        <label for="remark" class="col-md-3 control-label">内部备注：</label>

                                        <div class="col-md-9">

                                            <textarea id="remark" type="text" class="form-control"
                                                      name="remark"
                                                      style=" height: 100px"
                                            >{{$demo->remark}}</textarea>

                                            @if ($errors->has('remark'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('remark') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </form>
                @include("common.success")
                @include("common.errors")
            </div>
        </div>
    </div>
@endsection
