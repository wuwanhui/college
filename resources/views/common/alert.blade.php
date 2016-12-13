@extends('layouts.app')
@section('content')
    <div class="container-fluid" style="padding-top: 15px;">
        @if (count($errors) > 0)
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 ">
                            警告!
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12  text-center">
                            <button type="submit" class="btn  btn-warning" onclick="parent.layer.close(frameindex)">关闭
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 ">
                            提示!
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
                        {{ Session::get('success') }}
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12  text-center">
                            <button type="submit" class="btn  btn-success" onclick="parent.layer.close(frameindex)">关闭
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Session::has('message'))
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 ">
                            提示!
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12  text-center">
                            <button type="submit" class="btn  btn-info" onclick="parent.layer.close(frameindex)">关闭
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script type="application/javascript">
        var frameindex = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(frameindex);
    </script>
@endsection