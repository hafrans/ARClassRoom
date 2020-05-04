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
                        <div class="layui-card">

                            <fieldset class="layui-elem-field layui-field-title site-title">
                                <legend><a name="default">新建课程</a></legend>
                            </fieldset>
                        </div>
                    </div>
                </div>

        <div class="layui-row">
            <div class="layui-col-md12">

                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">课程名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" required  lay-verify="required" maxlength="255" placeholder="请输入标题" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">课程介绍</label>
                        <div class="layui-input-block">
                            <textarea name="description" placeholder="请输入内容" maxlength="255" rows="15" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">验证码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="captcha" required lay-verify="required" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><a href="javascript:(function(){document.getElementById('captcha').src='{{captcha_src()}}'+Math.random();})()"><img src="{{captcha_src()}}" id="captcha" /></a></div>
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

        layui.use(['form', 'table'], function () {
            var form = layui.form;

            //监听提交
            form.on('submit(formDemo)', function (data) {

                if (data.field.name.length <= 3){
                    layer.msg("课程名称长度过小")
                    return false;
                }

                if(data.field.description.length <= 3){
                    layer.msg("课程介绍长度过小")
                    return false;
                }

                //check ok

                $.ajax({
                    url:"{{action("Admin\CourseController@store")}}",
                    type:"post",
                    dataType:"json",
                    data:data.field,
                    success: function(data){
                        layer.msg(JSON.stringify(data))
                    },
                    error:function(jqXhr){
                        if (jqXhr.status == 422){
                            let obj = JSON.parse(jqXhr.responseText);
                            for (let i in obj.errors){
                                layer.msg(obj.errors[i][0]);
                            }
                        }else{
                            layer.msg("网络异常")
                        }
                    }


                });


                return false;
            });


        });


    </script>

@endsection
