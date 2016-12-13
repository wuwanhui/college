@extends('layouts.app')

@section('content')
    <div class="content">
        <ol class="breadcrumb">

            <li><a href="#">管理中心</a></li>
            <li><a href="#">资源供应</a></li>
            <li class="active">景区配置</li>
        </ol>
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">资源供应</div>

                    <div class="panel-body">
                        <ul>
                            <li>
                                <a href="{{url('/manage/supplier')}}">供应商列表</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/supplier/product')}}">原始资源</a>
                            </li>

                        </ul>
                        <hr/>
                        <ul>
                            <li>
                                <a href="{{url('/manage/supplier/scenic')}}" class="active">景区配置</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/supplier/scenic')}}">产品中心</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="panel panel-default">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-2  text-left">
                                    <button type="button" class="btn btn-default"
                                            onclick="vbscript:window.history.back()">返回
                                    </button>
                                    <button type="submit" class="btn  btn-primary">保存</button>

                                </div>
                                <div class="col-xs-10 text-right"></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <fieldset>
                                    <legend>基本信息</legend>
                                    {!! csrf_field() !!}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-3 control-label">景点名称：</label>

                                        <div class="col-md-9">
                                            <input id="name" type="text" class="form-control" name="name"
                                                   value="{{ $scenic->name}}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('recommend') ? ' has-error' : '' }}">
                                        <label for="recommend" class="col-md-3 control-label">推荐理由：</label>

                                        <div class="col-md-9">
                                            <input id="recommend" type="text" class="form-control" name="recommend"
                                                   value="{{ $scenic->recommend}}" autofocus>

                                            @if ($errors->has('recommend'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('recommend') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('titlePic') ? ' has-error' : '' }}">
                                        <label for="titlePic" class="col-md-3 control-label">标题图片：</label>

                                        <div class="col-md-9">
                                            <input id="titlePic" type="text" class="form-control" name="titlePic"
                                                   value="{{ $scenic->titlePic }}">

                                            @if ($errors->has('titlePic'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('titlePic') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('describe') ? ' has-error' : '' }}">
                                        <label for="describe" class="col-md-3 control-label">景点描述：</label>

                                        <div class="col-md-9">

                                            <textarea id="describe" type="text" class="form-control"
                                                      name="describe"
                                                      style=" height: 100px"
                                            >{{$scenic->describe}}</textarea>

                                            @if ($errors->has('describe'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('describe') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('attention') ? ' has-error' : '' }}">
                                        <label for="attention" class="col-md-3 control-label">注意事项：</label>

                                        <div class="col-md-9">

                                            <textarea id="attention" type="text" class="form-control"
                                                      name="attention"
                                                      style=" height: 100px"
                                            >{{$scenic->attention}}</textarea>

                                            @if ($errors->has('attention'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('attention') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('contenu') ? ' has-error' : '' }}">
                                        <label for="contenu" class="col-md-3 control-label">景区详情：</label>

                                        <div class="col-md-9">

                                            <textarea id="contenu" type="text" class="form-control"
                                                      name="contenu"
                                                      style=" height: 200px"
                                            >{{$scenic->contenu}}</textarea>

                                            @if ($errors->has('contenu'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('contenu') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
                                        <label for="grade" class="col-md-3 control-label">评级：</label>

                                        <div class="col-md-9">
                                            <select id="grade" name="grade" class="form-control" style="width: auto;">
                                                <option value="0">未知</option>
                                                <option value="1">A</option>
                                                <option value="2">AA</option>
                                                <option value="3">AAA</option>
                                                <option value="4">AAAA</option>
                                                <option value="5">AAAAA</option>
                                                <option value="-1">未评级</option>
                                            </select>

                                            @if ($errors->has('grade'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('grade') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                                        <label for="tel" class="col-md-3 control-label">客服电话：</label>

                                        <div class="col-md-9">
                                            <input id="tel" type="text" class="form-control"
                                                   name="tel"
                                                   style="width: auto;"
                                                   value="{{ $scenic->tel}}" autofocus>

                                            @if ($errors->has('tel'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('tel') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('addres') ? ' has-error' : '' }}">
                                        <label for="addres" class="col-md-3 control-label">地址：</label>

                                        <div class="col-md-9">
                                            <input id="addres" type="text" class="form-control"
                                                   name="addres"
                                                   value="{{ $scenic->addres}}" autofocus>

                                            @if ($errors->has('addres'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('addres') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('traffic') ? ' has-error' : '' }}">
                                        <label for="traffic" class="col-md-3 control-label">交通：</label>

                                        <div class="col-md-9">
                                            <input id="traffic" type="text" class="form-control"
                                                   name="traffic"
                                                   value="{{ $scenic->traffic}}" autofocus>

                                            @if ($errors->has('traffic'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('traffic') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                        <label for="longitude" class="col-md-3 control-label">经度：</label>

                                        <div class="col-md-9">
                                            <input id="longitude" type="text" class="form-control"
                                                   name="longitude"
                                                   style="width: auto;"
                                                   value="{{ $scenic->longitude}}" autofocus>

                                            @if ($errors->has('longitude'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('longitude') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                        <label for="latitude" class="col-md-3 control-label">经度：</label>

                                        <div class="col-md-9">
                                            <input id="latitude" type="text" class="form-control"
                                                   name="latitude"
                                                   style="width: auto;"
                                                   value="{{ $scenic->latitude}}" autofocus>

                                            @if ($errors->has('latitude'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('latitude') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        <label for="state" class="col-md-3 control-label">状态：</label>

                                        <div class="col-md-9">
                                            <select id="state" name="state" class="form-control" style="width: auto;">
                                                <option value="0">正常</option>
                                                <option value="1">禁用</option>
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
                                            >{{$scenic->refundable}}</textarea>

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
                    </form>
                </div>
                @include("common.success")
                @include("common.errors")
            </div>
        </div>
    </div>
@endsection
