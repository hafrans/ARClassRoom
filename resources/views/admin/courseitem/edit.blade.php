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
    </style>
@endsection

@section("body-attr","")

@section("content")

    <div class="layui-container" style="margin-top: 50px;">
        <div class="layui-row">
            <div class="layui-col-md12">
                <fieldset class="layui-elem-field layui-field-title site-title">
                    <legend><a name="default">修改知识点</a></legend>
                </fieldset>
            </div>
        </div>

        <div class="layui-row">
            <div class="layui-col-md12">

                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">归属课程</label>
                        <div class="layui-input-block">
                            <input type="text" name="course_name" required readonly lay-verify="required"
                                   style="color:#444" maxlength="255"
                                   value="{{$course->name}}" placeholder="请输入标题"
                                   autocomplete="off" class="layui-input">
                        </div>
                        <input type="hidden" name="course_id" readonly
                               value="{{$course->id}}"/>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">知识点名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" required lay-verify="required" maxlength="255"
                                   value="{{$item->name}}" placeholder="请输入课程知识点名称" autocomplete="off"
                                   class="layui-input"/>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">视频素材</label>
                        <div class="layui-inline">
                            <div class="layui-upload-drag" id="uploadvideo" style="width: 500px;position: relative">
                                <i class="layui-icon"></i>
                                <p style="color:#333">点击上传，或将视频素材拖拽到此处</p>
                                <div class="layui-hide" id="uploaded_video">
                                    <hr/>
                                    @if( empty($item->video_path))
                                    <video controls="controls" width="480" height="350"></video>
                                    @else
                                        <video controls="controls" width="480" height="350"
                                               src="{{\Storage::disk("s3")->temporaryUrl($item->video_path, now()->addMinutes(10))}}"></video>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">图片素材</label>
                        <div class="layui-inline">
                            <div class="layui-upload-drag" id="uploadaudio" style="width: 500px;position: relative">
                                <i class="layui-icon"></i>
                                <p style="color:#333">点击上传，或将图片素材拖拽到此处</p>
                                <div class="layui-hide" id="uploaded_audio">
                                    <hr>
                                    {{--                                    <audio type="audio/mp3" controls="controls" style="width: 480px;"/>--}}
                                    @if(empty($item->audio_path))
                                    <img style="width: 480px"/>
                                    @else
                                        <img style="width: 480px"
                                             src="{{\Storage::disk("s3")->temporaryUrl($item->audio_path, now()->addMinutes(10))}}"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">知识图谱</label>
                        <div class="layui-inline">
                            <div class="layui-upload-drag" id="uploadgraph" style="width: 500px;position: relative">
                                <i class="layui-icon"></i>
                                <p style="color:#333">点击上传，或将图片素材拖拽到此处</p>
                                <div class="layui-hide" id="uploaded_graph">
                                    <hr>
                                    {{--                                    <audio type="audio/mp3" controls="controls" style="width: 480px;"/>--}}
                                    @if(empty($item->graph_path))
                                        <img style="width: 480px"/>
                                    @else
                                        <img style="width: 480px"
                                             src="{{\Storage::disk("s3")->temporaryUrl($item->graph_path, now()->addMinutes(10))}}"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">3D模型素材</label>
                        <div class="layui-inline">
                            <div class="layui-upload-drag" id="uploadmodel" style="width: 500px;position: relative">
                                <i class="layui-icon"></i>
                                <p style="color:#333">点击上传，或将素材拖拽到此处,不上传不修改</p>
                            </div>
                            <div class="layui-hide" id="uploaded_model"
                                 style="margin-top:2rem;padding:26px;border:1px dashed #CCC;">
                                <hr>
                                <div id="container_model"
                                     style="width: 500px; height: 400px; overflow: hidden; position: relative">

                                </div>
                                <div class="control-tip">
                                    Tips: 鼠标拖动旋转方向，滚轮调整缩放
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">文字介绍</label>
                        <div class="layui-input-block">
                            <textarea name="content" placeholder="请输入内容" maxlength="255" rows="15"
                                      class="layui-textarea">{{$item->content}}</textarea>
                        </div>
                    </div>


                    <div class="layui-form-item">
                        <label class="layui-form-label">验证码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="captcha" required lay-verify="required" autocomplete="off"
                                   class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><a
                                href="javascript:(function(){document.getElementById('captcha').src='{{captcha_src()}}'+Math.random();})()"><img
                                    style="position: relative; top:-8px" src="{{captcha_src()}}" id="captcha"/></a>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection

@section("bottom-script")

    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>


    <script type="text/javascript">

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

        container.append(renderer.domElement)


        function render() {
            renderer.render(scene, camera);
            for (const mixer of mixers) {
                mixer.update(clock.getDelta());
            }
            window.requestAnimationFrame(() => {
                render();
            });
        }


        layui.use(['form', 'table', 'upload'], function () {
            var form = layui.form;
            var upload = layui.upload;

            var multiMediaPartialForm = {
                video_path: "{{$item->video_path}}",
                audio_path: "{{$item->audio_path}}",
                model_path: "{{$item->model_path}}",
                graph_path: "{{$item->graph_path}}",
            };

            if(multiMediaPartialForm.video_path.length > 5){
                layui.$('#uploaded_video').removeClass('layui-hide')
            }

            if (multiMediaPartialForm.audio_path.length > 5){
                layui.$('#uploaded_audio').removeClass('layui-hide');
            }

            if (multiMediaPartialForm.graph_path.length > 5){
                layui.$('#uploaded_graph').removeClass('layui-hide');
            }


            ////拖拽上传
            // 视频
            upload.render({
                elem: '#uploadvideo'
                , accept: "video"
                , url: '{{route("admin.upload.video")}}' //改成您自己的上传接口
                , before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    layer.load(); //上传loading
                }
                , error: function (index, upload) {
                    layer.closeAll('loading'); //关闭loading
                }
                , done: function (res) {
                    layer.msg('上传成功');
                    layer.closeAll('loading'); //关闭loading
                    layui.$('#uploaded_video').removeClass('layui-hide').find('video').attr('src', res.data.temporary);
                    multiMediaPartialForm.video_path = res.data.path;
                    console.log(res)
                }
            });
            // audio
            upload.render({
                elem: '#uploadaudio'
                , accept: "images"
                , url: '{{route("admin.upload.audio")}}' //改成您自己的上传接口
                , before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    layer.load(); //上传loading
                }
                , error: function (index, upload) {
                    layer.closeAll('loading'); //关闭loading
                }
                , done: function (res) {
                    layer.closeAll('loading'); //关闭loading
                    layer.msg('上传成功');
                    layui.$('#uploaded_audio').removeClass('layui-hide').find('img').attr('src', res.data.temporary);
                    multiMediaPartialForm.audio_path = res.data.path
                    console.log(res)
                }
            });

            // graph
            upload.render({
                elem: '#uploadgraph'
                , accept: "images"
                , url: '{{route("admin.upload.audio")}}' //改成您自己的上传接口
                , before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    layer.load(); //上传loading
                }
                , error: function (index, upload) {
                    layer.closeAll('loading'); //关闭loading
                }
                , done: function (res) {
                    layer.closeAll('loading'); //关闭loading
                    layer.msg('上传成功');
                    layui.$('#uploaded_graph').removeClass('layui-hide').find('img').attr('src', res.data.temporary);
                    multiMediaPartialForm.graph_path = res.data.path
                    console.log(res)
                }
            });

            // model
            upload.render({
                elem: '#uploadmodel'
                , accept: "file"
                , exts: "fbx"
                , url: '{{route("admin.upload.model")}}'
                , before: function (obj) {
                    layer.load(); //上传loading
                }
                , error: function (index, upload) {
                    layer.closeAll('loading'); //关闭loading
                }
                , done: function (res) {
                    layer.closeAll('loading'); //关闭loading
                    layer.msg('上传成功');
                    multiMediaPartialForm.model_path = res.data.path
                    loader.load(res.data.temporary, function (object) {
                        object.scale.setScalar(0.04);
                        object.position.set(0, 0, 0);
                        if (oldObject != null) {
                            scene.remove(oldObject);
                        }
                        scene.add(object);
                        layui.$('#uploaded_model').removeClass('layui-hide');
                        oldObject = object;
                        if (object.animations.length > 0) {
                            object.mixer = new THREE.AnimationMixer(object);
                            mixers.push(object.mixer);
                            object.mixer.clipAction(object.animations[0]).play();
                        }
                    })

                    render();
                    console.log(res)
                }
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {
                // alert(JSON.stringify(Object.assign({},data.field,multiMediaPartialForm)))

                if (data.field.name.length <= 3) {
                    layer.msg("课程名称长度过小")
                    return false;
                }

                //check ok

                $.ajax({
                    url: "{{action("Admin\CourseItemController@update",["courseItem"=>$item->id])}}",
                    type: "put",
                    dataType: "json",
                    data: Object.assign({}, data.field, multiMediaPartialForm),
                    success: function (data) {
                        if (data.code == 0) {
                            layer.msg("知识点修改成功")
                            setTimeout(() => window.parent.location.href = '{{action("Admin\CourseItemController@index")}}?course={{$course->id}}', 1500);
                        }
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


                });


                return false;
            });


        });


    </script>

@endsection
