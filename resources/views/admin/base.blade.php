@extends("layouts.laybase")

@section("head")
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
@endsection

@section("content")

    <div class="layui-header">
        <div class="layui-logo"
             style="font-size:1.5em;color:#FFFFFE;width:200px;height:60px;background: #393D49;line-height: 60px; overflow: hidden; text-align: center;">
{{--            ArHelper<sub style="font-size:0.2em">Hafrans</sub>--}}
            {{env("APP_NAME")}}
        </div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left" style="width:100%; height: 100%">
            {{--            <li class="layui-nav-item"><a href="">控制台</a></li>--}}
            {{--            <li class="layui-nav-item"><a href="">商品管理</a></li>--}}
            {{--            <li class="layui-nav-item"><a href="">用户</a></li>--}}
            {{--            <li class="layui-nav-item">--}}
            {{--                <a href="javascript:;">其它系统</a>--}}
            {{--                <dl class="layui-nav-child">--}}
            {{--                    <dd><a href="">邮件管理</a></dd>--}}
            {{--                    <dd><a href="">消息管理</a></dd>--}}
            {{--                    <dd><a href="">授权管理</a></dd>--}}
            {{--                </dl>--}}
            {{--            </li>--}}
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg"
                         class="layui-nav-img">
                    {{Auth::user()->name}}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="{{route("admin.logout")}}">退出</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black" style="margin-top: 60px">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree active" lay-filter="test">
                <li class="layui-nav-item"><a href="{{route("admin.home")}}">首页</a></li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">课程管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{action("Admin\CourseController@index")}}" target="spanel">课程列表</a></dd>
                        <dd><a href="{{action("Admin\CourseController@create")}}" target="spanel">课程添加</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">识别设置</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{action("Admin\SImageController@index")}}" target="spanel">识别图库</a></dd>
                        <dd><a href="{{action("Admin\SImageController@create")}}" target="spanel">添加新图片</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href=""><i class="layui-icon layui-icon-light"></i> &nbsp; 快速添加条目</a></li>
                <li class="layui-nav-item">
                    <a href="https://portal.easyar.cn/crs/list" target="_blank">云识别管理<span>&nbsp; &nbsp;
                            <i class="layui-icon layui-icon-link"></i></span>
                    </a>

                </li>
                <li class="layui-nav-item">
                    <a href="https://portal.qiniu.com/kodo/overview" target="_blank">对象存储管理<span>&nbsp; &nbsp;
                            <i class="layui-icon layui-icon-link"></i></span>
                    </a>

                {{--                <li class="layui-nav-item"><a href="">发布商品</a></li>--}}
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <iframe src="{{route("admin.dashboard")}}" frameborder="0" name="spanel" id="demoAdmin" scrolling="auto"
                style="width: 100%; height: calc( 100% - 10px);"></iframe>

    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
    </div>

@endsection

@section("bottom-script")
    <script>
        //JavaScript代码区域
        layui.use('element', function () {
            var element = layui.element;

        });
    </script>
@endsection
