@extends("layouts.laybase")

@section("head")
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <style type="text/css">
        .control-tip {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2em;
            text-align: center;
            line-height: 200%;
            background: rgba(128, 128, 128, 0.5);
        }

        .loading-tip {
            text-align: center;
            width: 100%;
            height: 20%;
            top: 40%;
            position: absolute;
            left: 0;
            font-size: 1.5em;
        }

        .loading-tip > i {
            display: inline-block;
            font-size: 1.5em;
            position: relative;
            top: 0.25em;
        }

        .layui-table tbody tr:hover, .layui-table-hover {
            background-color: #FFF; /*修改成你自己的颜色*/
        }
    </style>
@endsection

@section("body-attr","")

@section("content")

    <div class="layui-container" style="margin-top: 30px;">
        <div class="layui-row">
            <table class="layui-table">
                <colgroup>
                    <col width="100">
                    <col width="180">
                    <col width="100">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th><b>系统序号</b></th>
                    <td>{{$simage->id}}</td>
                    <th><b>识别目标ID</b></th>
                    <td>{{$simage->serial_id}}</td>
                </tr>
                <tr>
                    <th><b>目标名称</b></th>
                    <td>{{$result->name}}</td>
                    <th><b>创建时间</b></th>
                    <td>{{$simage->created_at}}</td>
                </tr>
                <tr>
                    <th><b>识别困难度评分</b></th>
                    <td colspan="3"><strong style="font-size: larger">{{$result->grade}}</strong>&nbsp;&nbsp;&nbsp;<i style="float: right">参考： -1:图像错误; 0,1:目标易检测; 2:一般; 3,4: 目标难以检测</i></td>
                </tr>
                <tr>
                    <th><b>TrackableDistinctiveness</b></th>
                    <td>{{$result->trackableDistinctiveness}}</td>
                    <th><b>DetectableFeatureDistribution</b></th>
                    <td>{{$result->detectableFeatureDistribution}}</td>
                </tr>
                <tr>
                    <th><b>TrackableFeatureCount</b></th>
                    <td colspan="1">{{$result->trackableFeatureCount}}</td>
                    <th><b>DetectableRate</b></th>
                    <td colspan="1">{{$result->detectableRate}}</td>
                </tr>
                <tr>
                    <th><b>TrackableFeatureDistribution</b></th>
                    <td colspan="1">{{$result->trackableFeatureDistribution}}</td>
                    <th><b>Size</b></th>
                    <td colspan="1">{{$result->size}}</td>
                </tr>
                <tr>
                    <th><b>TrackablePatchContrast</b></th>
                    <td colspan="3">{{$result->trackablePatchContrast}}</td>
                </tr>

                <tr>
                    <th><b>图片</b></th>
                    <td colspan="3" style="position: relative">
                        <img style="max-width:100%;" src="{{action("Admin\SImageController@index")}}/{{$simage->id}}" />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="layui-row">
            <div class="layui-col-md12">


            </div>
        </div>

    </div>

@endsection

@section("bottom-script")


    <script type="text/javascript">

        layui.use(['form', 'table'], function () {
            var form = layui.form;
            var table = layui.table;
        });


    </script>

@endsection
