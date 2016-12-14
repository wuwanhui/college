@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            工作台
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
            <li class="active">工作台</li>
        </ol>
    </section>
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i> 教</span>

                    <div class="info-box-content">
                        <span class="info-box-text">教师数</span>
                        <span class="info-box-number">60<small>人</small></span>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i> 学</span>

                    <div class="info-box-content">
                        <span class="info-box-text">学生数</span>
                        <span class="info-box-number">30</span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i> 课</span>

                    <div class="info-box-content">
                        <span class="info-box-text">课程数</span>
                        <span class="info-box-number">760</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i> 选</span>

                    <div class="info-box-content">
                        <span class="info-box-text">选课人次</span>
                        <span class="info-box-number">40</span>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection

