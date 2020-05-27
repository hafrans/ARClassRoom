@extends("layouts.laybase")

@section("head")
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <script type="text/javascript" src="{{asset('static/three/three.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('static/three/FBXLoader.js')}}"></script>
    <script type="text/javascript" src="{{asset('static/three/inflate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('static/three/OrbitControls.js')}}"></script>
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
            <div class="layui-col-md12">
                <fieldset class="layui-elem-field layui-field-title site-title">
                    <legend><a name="default">知识点资源查看</a></legend>
                </fieldset>
            </div>
        </div>
        <div class="layui-row">
            <table class="layui-table">
                <colgroup>
                    <col width="100">
                    <col width="300">
                    <col width="100">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th><b>知识点</b></th>
                    <td>{{$item->name}}</td>
                    <th><b>归属课程</b></th>
                    <td>{{$course->name}}</td>
                </tr>
                <tr>
                    <th><b>创建时间</b></th>
                    <td>{{$item->created_at}}</td>
                    <th><b>识别ID</b></th>
                    <td>@if (count($item->simages) == 0) 未绑定图片 @else 已绑定{{count($item->simages)}}张图片 @endif</td>
                </tr>
                <tr>
                    <th><b>文字介绍</b></th>
                    <td colspan="3">
                        @if (empty($item->content))
                            没有文字介绍！
                        @else
                            {{$item->content}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        <b>视频资源</b>
                    </th>
                    <td>
                        @if (empty($item->video_path))
                            无视频资源
                        @else
                            <video width="300" height="200" controls="controls"
                                   src="{{\Illuminate\Support\Facades\Storage::disk("s3")->temporaryUrl($item->video_path,now()->addMinutes(10))}}"></video>
                        @endif
                    </td>
                    <th>
                        <b>音频资源</b>
                    </th>
                    <td>
                        @if (empty($item->audio_path))
                            无音频资源
                        @else
                            <audio type="audio/mp3" controls="controls"
                                   src="{{\Illuminate\Support\Facades\Storage::disk("s3")->temporaryUrl($item->audio_path,now()->addMinutes(10))}}"/>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th><b>3D建模</b></th>
                    <td colspan="3">
                        @if (empty($item->model_path))
                            没有建模资源！
                        @else
                            <div id="uploaded_model">
                                <hr>
                                <div id="container_model"
                                     style="width: 500px; height: 500px; overflow: hidden; position: relative">
                                    <div class="loading-tip" id="loadingtip">

                                        <i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop"></i>
                                        &nbsp; &nbsp;<b> 加载中
                                        </b>
                                    </div>
                                </div>
                                <div class="control-tip">
                                    Tips: 鼠标拖动旋转方向，滚轮调整缩放
                                </div>
                            </div>

                            <script type="text/javascript">

                                document.onreadystatechange = function () {
                                    if (document.readyState == "complete") {

                                        var mixers = []
                                        var oldObject = null;
                                        var container = $("#container_model");
                                        var scene = new THREE.Scene();

                                        scene.add(new THREE.AmbientLight(0xFFFFFF));
                                        var camera = new THREE.PerspectiveCamera(45, container.width() / container.height(), 0.1, 1000);
                                        camera.lookAt(new THREE.Vector3(0, 0, 0));
                                        camera.position.set(-30, 30, 50);

                                        var renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
                                        renderer.setSize(container.width(), container.height());
                                        var control = new THREE.OrbitControls(camera, renderer.domElement);
                                        control.update();

                                        var gridHelper = new THREE.GridHelper(100, 30, 0x2C2C2C, 0x888888);
                                        scene.add(gridHelper);

                                        var clock = new THREE.Clock();

                                        var loader = new THREE.FBXLoader();


                                        function render() {
                                            renderer.render(scene, camera);
                                            for (const mixer of mixers) {
                                                mixer.update(clock.getDelta());
                                            }
                                            window.requestAnimationFrame(() => {
                                                render();
                                            });
                                        }

                                        container.append(renderer.domElement);

                                        loader.load("{{\Illuminate\Support\Facades\Storage::disk("s3")->temporaryUrl($item->model_path,now()->addMinutes(10))}}".replace(/&amp;/g, "&"), function (object) {
                                            console.log(object)
                                            object.scale.setScalar(0.04);
                                            object.position.set(0, 0, 0);
                                            scene.add(object);
                                            $('#loadingtip').addClass('layui-hide');
                                            if (object.animations.length > 0) {
                                                object.mixer = new THREE.AnimationMixer(object);
                                                mixers.push(object.mixer);
                                                object.mixer.clipAction(object.animations[0]).play();
                                            }
                                            render();
                                        })
                                    }
                                }


                            </script>


                        @endif
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

            table.render({
                id: "coco",
                elem: '#courses',
                url: "{{url()->full()}}".replace("&amp;", "&"),
                request: {
                    pageName: "page"
                },
                height: "full-140",
                limit: 20,
                cols: [[
                    {
                        field: "id",
                        title: "序号",
                        width: "80",
                        fixed: "left",
                        unresize: true,
                        sort: true,
                    },
                    {
                        field: "name",
                        title: "知识条目名称",
                        width: 200,
                        unresize: true
                    },
                    {
                        field: "hasVideo",
                        title: "视频素材",
                        type: "normal",
                        unresize: true,
                        width: 100
                    },
                    {
                        field: "video_path",
                        hide: true
                    },
                    {
                        field: "hasAudio",
                        title: "音频素材",
                        type: "normal",
                        unresize: true,
                        width: 100
                    },
                    {
                        field: "audio_path",
                        hide: true
                    },
                    {
                        field: "hasModel",
                        title: "3D模型素材",
                        type: "normal",
                        unresize: true,
                        width: 130
                    },
                    {
                        field: "model_path",
                        hide: true
                    },

                    {
                        field: "hasContent",
                        title: "文本素材",
                        type: "normal",
                        unresize: true,
                        width: 100
                    },
                    {
                        field: "content",
                        hide: true
                    },
                    {
                        field: "created_at",
                        title: "创建日期",
                        width: 180

                    },
                    {
                        field: "updated_at",
                        title: "修改日期",
                        width: 180

                    },
                    {
                        title: "操作",
                        toolbar: "#barDemo",
                        width: 220,
                        fixed: "right"
                    }
                ]],
                page: true
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {
                table.reload("coco", {
                    url: ("{{url()->full()}}&name=" + data.field.name).replace("&amp;", "&"),
                });
                return false;
            });

            table.on('tool(courses)', function (obj) {
                console.log(obj)
                switch (obj.event) {
                    case 'view':
                        var index = layer.open({
                            type: 2 //此处以iframe举例
                            , title: '课程条目查看'
                            , area: ['1024px', '600px']
                            , shade: 1
                            , maxmin: true
                            , content: '{{action("Admin\CourseItemController@index")}}/' + obj.data.id
                            , btn: ['关闭'] //只是为了演示
                            , yes: function () {
                                layer.closeAll();
                            }
                            , zIndex: layer.zIndex //重点1
                            , success: function (layero) {
                                layer.setTop(layero); //重点2
                            }
                        });
                        break;
                    case 'del':
                        layer.confirm("您是否要删除该课程条目？此操作无法恢复",
                            {btn: ['确定', '取消']},
                            function (index, layero) {
                                var objx = obj;
                                $.ajax({
                                    url: "{{action("Admin\CourseItemController@index")}}/" + obj.data.id,
                                    type: "delete",
                                    dataType: "json",
                                    success: function (data) {
                                        layer.msg(JSON.stringify(data))

                                        if (data.code == 0) {
                                            layer.msg("删除成功")
                                            objx.del()

                                        } else {
                                            layer.msg("删除失败")
                                        }

                                        layer.close(index)
                                    },
                                    error: function (jqXhr) {
                                        if (jqXhr.status == 422) {
                                            let obj = JSON.parse(jqXhr.responseText);
                                            for (let i in obj.errors) {
                                                layer.msg(obj.errors[i][0]);
                                            }
                                        } else {
                                            layer.msg("网络异常")
                                        }
                                    }
                                })
                            }
                        )
                        break;
                    case 'edit':
                        layer.msg('编辑');
                        break;
                }
                ;

            });


        });


    </script>

@endsection
