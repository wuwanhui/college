@extends('layouts.app')

@section('content')
    <div class="content">
        <ol class="breadcrumb">

            <li><a href="#">管理中心</a></li>
            <li class="active">系统配置</li>
        </ol>
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">系统配置</div>

                    <div class="panel-body ">
                        <ul>
                            <li>
                                <a href="{{url('/manage/system/config')}}">系统参数</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/system/enterprise')}}">企业信息</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/system/dept')}}">部门机构</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/system/user')}}">用户管理</a>
                            </li>


                        </ul>
                        <hr/>
                        <ul>
                            <li>
                                <a href="{{url('/manage/system/permissions')}}">模块权限</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/system/role')}}">角色管理</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/system/auth')}}">用户授权</a>
                            </li>
                        </ul>
                        <hr/>
                        <ul>
                            <li>
                                <a href="{{url('/manage/system/basedata')}}">基础数据</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/system/notices')}}">公告信息</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                系统设置主页
                @include("common.success")
                @include("common.errors")
            </div>
        </div>
    </div>
@endsection
