@extends("layouts.laybase")

@section("head")
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
@endsection

@section("body-attr","")

@section("content")

    <div class="layui-container" style="margin-top: 50px;">
        <div class="layui-row">
            <div class="layui-col-md12">

                <form class="layui-form" action="">
                    <div class="layui-form-item">

                        <div class="layui-inline">
                            <a class="layui-btn layui-btn-danger" href="{{action("Admin\CourseItemController@create")}}?course={{request()->get("course")}}">新建知识点</a>
                        </div>

                        <div class="layui-inline">
                            <label class="layui-form-label">
                                <b>知识点名称</b>
                            </label>
                            <div class="layui-input-inline" style="width: 500px;">
                                <input type="text" name="name" placeholder="" value="{{old("name")}}" autocomplete="off"
                                       maxlength="255"
                                       class="layui-input">
                            </div>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn" lay-submit lay-filter="formDemo">模糊查询</button>
                        </div>

                        <div class="layui-inline">
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>

                    </div>


                </form>

                <hr>

                <table id="courses" lay-filter="courses"></table>

            </div>
        </div>

    </div>

@endsection

@section("bottom-script")

    <script type="text/html" id="barDemo">
        <div class="layui-btn layui-btn-primary layui-btn-xs" lay-event="view">查看资源</div>
        <div class="layui-btn layui-btn-xs" lay-event="edit">修改</div>
        <div class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</div>
    </script>


    <script type="text/javascript">

        layui.use(['form', 'table'], function () {
            var form = layui.form;
            var table = layui.table;

            table.render({
                id:"coco",
                elem: '#courses',
                url: "{{url()->full()}}".replace("&amp;","&"),
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
                        type:"normal",
                        unresize: true,
                        width: 100
                    },
                    {
                        field:"video_path",
                        hide:true
                    },
                    {
                        field: "hasAudio",
                        title: "音频素材",
                        type:"normal",
                        unresize: true,
                        width: 100
                    },
                    {
                        field:"audio_path",
                        hide:true
                    },
                    {
                        field: "hasModel",
                        title: "3D模型素材",
                        type:"normal",
                        unresize: true,
                        width:130
                    },
                    {
                        field:"model_path",
                        hide:true
                    },

                    {
                        field: "hasContent",
                        title: "文本素材",
                        type:"normal",
                        unresize: true,
                        width: 100
                    },
                    {
                        field:"content",
                        hide:true
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
                table.reload("coco",{
                    url:("{{url()->full()}}&name="+data.field.name).replace("&amp;","&"),
                });
                return false;
            });

            table.on('tool(courses)',function(obj){
                console.log(obj)
                switch(obj.event){
                    case 'view':
                        var index = layer.open({
                            type: 2 //此处以iframe举例
                            ,title: '课程条目查看'
                            ,area: ['1024px', '600px']
                            ,shade: 1
                            ,maxmin: true
                            ,content: '{{action("Admin\CourseItemController@index")}}/'+obj.data.id
                            ,btn: ['关闭'] //只是为了演示
                            ,yes: function(){
                                layer.closeAll();
                            }
                            ,zIndex: layer.zIndex //重点1
                            ,success: function(layero){
                                layer.setTop(layero); //重点2
                            }
                        });
                        break;
                    case 'del':
                        layer.confirm("您是否要删除该课程条目？此操作无法恢复",
                            {btn:['确定','取消']},
                            function (index, layero) {
                                var objx = obj;
                                $.ajax({
                                    url:"{{action("Admin\CourseItemController@index")}}/"+obj.data.id,
                                    type:"delete",
                                    dataType:"json",
                                    success: function(data){

                                        if(data.code == 0){
                                            layer.msg("删除成功")
                                            objx.del()

                                        }else{
                                            layer.msg("删除失败")
                                        }

                                        layer.close(index)
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
                                })
                            }
                        )
                        break;
                    case 'edit':
                        layer.msg('编辑');
                        break;
                };

            });



        });


    </script>

@endsection
