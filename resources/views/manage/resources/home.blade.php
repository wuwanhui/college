@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">资源管理</div>

                    <div class="panel-body ">
                        <ul>
                            <li>
                                <a href="{{url('/manage/resources/config')}}">供应商管理</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/lineclass')}}">线路类别管理</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/dept')}}">线路行程管理</a>
                            </li>
                        </ul>
                        <hr/>
                        <ul>
                            <li>
                                <a href="{{url('/manage/resources/permissions')}}">常用集合地</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/role')}}">市场划分</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/auth')}}">公司抬头</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/auth')}}">团期推荐</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/auth')}}">常用酒店</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/auth')}}">常用景点</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/auth')}}">常用大交通</a>
                            </li>
                        </ul>
                        <hr>
                        <ul>
                            <li>
                                <a href="{{url('/manage/resources/user')}}">领队/导游管理</a>
                            </li>
                            <li>
                                <a href="{{url('/manage/resources/user')}}">游客黑名单管理</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <ol class="breadcrumb">
                    <li>资源管理中心</li>
                </ol>
                @include("common.success")
                @include("common.errors")
            </div>
        </div>
    </div>

@endsection
