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
                <fieldset class="layui-elem-field layui-field-title site-title">
                    <legend><a name="default">新建云识别图片</a></legend>
                </fieldset>
            </div>
        </div>

        <div class="layui-row">
            <div class="layui-col-md12">

                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">图片名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" required lay-verify="required" maxlength="64" minlength="3"
                                   placeholder="请输入名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">图片</label>
                        <div class="layui-input-block">
                            <div class="layui-upload-drag" id="test10">
                                <i class="layui-icon"></i>
                                <p>点击上传，或将文件拖拽到此处</p>
                                <div class="layui-hide" id="uploadDemoView">
                                    <hr>
                                    <img src="" alt="上传成功后渲染" style="max-width: 196px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">元数据</label>
                        <div class="layui-input-block">
                            <textarea name="meta" placeholder="请输入元数据，最大512个字符" maxlength="512" rows="3"
                                      class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">图片宽度</label>
                        <div class="layui-input-block">
                            <input type="number" name="size" required lay-verify="required" maxlength="64" minlength="3"
                                   placeholder="请输入宽度" autocomplete="off" class="layui-input" value="20">
                            <div style="color: darkgrey">
                                请输入识别图的宽度（cm）。识别图的高度将由系统根据您上传的图片自动计算。识别图的大小和虚拟内容的大小对应。详见<a
                                    href="https://help.easyar.cn/EasyAR%20CRS/api/target-create.html#id3">文档说明</a>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <textarea name="description" placeholder="请输入内容" maxlength="255" rows="15"
                                      class="layui-textarea"></textarea>
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

        let formData = {
            image: null,
        };


        layui.use(['form', 'table', 'upload'], function () {
            var form = layui.form;
            var upload = layui.upload;
            //拖拽上传
            upload.render({
                elem: '#test10',
                acceptMime: 'image/jpg, image/png'
                , url: '{{route("admin.upload.image")}}' //改成您自己的上传接口
                , before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                    layer.load(); //上传loading
                }
                , error: function (index, upload) {
                    layer.msg('上传失败');
                    layer.closeAll('loading'); //关闭loading
                }
                , done: function (res) {
                    layer.closeAll('loading'); //关闭loading
                    layer.msg('上传成功');
                    layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', "/admin/show/image/"+res.data.path);
                    console.log(res)
                }
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {

                if (data.field.name.length <= 3) {
                    layer.msg("课程名称长度过小")
                    return false;
                }

                if (data.field.description.length <= 3) {
                    layer.msg("课程介绍长度过小")
                    return false;
                }

                //check ok

                $.ajax({
                    url: "{{action("Admin\CourseController@store")}}",
                    type: "post",
                    dataType: "json",
                    data: data.field,
                    success: function (data) {
                        if (data.code == 0) {
                            layer.msg("课程创建成功")
                            setTimeout(() => location.href = '{{action("Admin\CourseController@index")}}', 1500);
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
