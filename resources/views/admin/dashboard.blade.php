@extends("layouts.laybase")

@section("head")
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
@endsection

@section("body-attr","")

@section("content")

    <div class="layui-container" style="margin-top: 100px;">
        <div class="layui-row">
            <div class="layui-col-md12">
                <div style="font-weight: 300; font-size: 1.5rem; padding-left: 1.25rem">
                    ArHelper <sub style="font-size: 0.2rem">v0.1</sub>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md12">


                <div class="layui-card">

                    <fieldset class="layui-elem-field layui-field-title site-title">
                        <legend><a name="default">服务器信息</a></legend>
                    </fieldset>

                    <div class="layui-card-body">
                        <table class="layui-table">
                            <colgroup>
                                <col width="150">
                                <col>
                            </colgroup>

                            <tbody>
                            <tr>
                                <th>服务器地址</th>
                                <td>{{@$_SERVER["SERVER_ADDR"] ?? "CLI"}}:{{$_SERVER["SERVER_PORT"]}}</td>
                            </tr>
                            <tr>
                                <td>PHP执行程序版本</td>
                                <td>{{$_SERVER["SERVER_SOFTWARE"]}}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td>服务器类型</td>--}}
{{--                                <td>{{$_SERVER[""]}}</td>--}}
{{--                            </tr>--}}
                            </tbody>
                        </table>
                    </div>
                </div>


                <fieldset class="layui-elem-field layui-field-title site-title">
                    <legend><a name="default">软件信息</a></legend>
                </fieldset>




                <div class="layui-card">

                    <div class="layui-card-body">
                        <table class="layui-table">
                            <colgroup>
                                <col width="150">
                                <col>
                            </colgroup>

                            <tbody>
                            <tr>
                                <th>发布日期</th>
                                <td>2020-05-01 14:56:11</td>
                            </tr>
                            <tr>
                                <td>版本号</td>
                                <td>0.1.1.05015611.SNAPSHOT</td>
                            </tr>
                            <tr>
                                <td>联系方式</td>
                                <td>lvzh@hafrans.com</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
