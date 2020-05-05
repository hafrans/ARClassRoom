@extends("layouts.laybase")

@section("head")
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
@endsection

@section("body-attr","")

@section("content")

    <div class="layui-container" style="margin-top: 100px;">
        {{--        <div class="layui-row">--}}
        {{--            <div class="layui-col-md12">--}}
        {{--                <div class="layui-card">--}}

        {{--                    <fieldset class="layui-elem-field layui-field-title site-title">--}}
        {{--                        <legend><a name="default">课程列表</a></legend>--}}
        {{--                    </fieldset>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="layui-row">
            <div class="layui-col-md12">

                <form class="layui-form" action="">
                    <div class="layui-form-item">

                        <div class="layui-inline">
                            <label class="layui-form-label">
                                <b>课程名称</b>
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
        <div class="layui-btn layui-btn-xs" lay-event="add">新增知识点</div>
        <div class="layui-btn layui-btn-primary layui-btn-xs" lay-event="view">所有知识点</div>
        <div class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除课程</div>
    </script>


    <script type="text/javascript">

        layui.use(['form', 'table'], function () {
            var form = layui.form;
            var table = layui.table;

            table.render({
                id:"coco",
                elem: '#courses',
                url: "{{url()->full()}}",
                request: {
                    pageName: "page"
                },
                height: "full-200",
                limit: 20,
                cols: [[
                    {
                        field: "id",
                        title: "课程号",
                        width: "8%",
                        fixed: "left",
                        unresize: true,
                        sort: true,
                    },
                    {
                        field: "name",
                        title: "课程名称",
                        width: 200,
                    },
                    {
                        field: "description",
                        title: "课程描述",

                        width: 360,
                        unresize: true,
                    },
                    {
                        field: "created_at",
                        title: "创建日期",
                        width: 180
                    },
                    // {
                    //     field: "updated_at",
                    //     title: "修改日期",
                    //
                    //     width: 120
                    // },
                    {
                        title: "操作",
                        toolbar: "#barDemo",
                        width: 280,fixed:"right"
                    }
                ]],
                page: true
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {
                table.reload("coco",{
                    url:"{{url()->current()}}?name="+data.field.name,
                });
                return false;
            });

            table.on('tool(courses)',function(obj){
                var that = this;
                var objx = obj;
                switch(obj.event){
                    case 'view':
                        //多窗口模式，层叠置顶
                        var index = layer.open({
                            type: 2 //此处以iframe举例
                            ,title: '课程条目查看'
                            ,area: ['1024px', '600px']
                            ,shade: 1
                            ,maxmin: true
                            ,content: '{{action("Admin\CourseItemController@index")}}?course='+objx.data.id+"&bb=true"
                            ,btn: ['关闭'] //只是为了演示
                            ,yes: function(){
                                  layer.closeAll();
                            }
                            ,zIndex: layer.zIndex //重点1
                            ,success: function(layero){
                                layer.setTop(layero); //重点2
                            }
                        });
                        layer.full(index);
                        break;
                    case 'add':
                        var index = layer.open({
                            type: 2 //此处以iframe举例
                            ,title: '课程条目查看'
                            ,area: ['1024px', '600px']
                            ,shade: 1
                            ,maxmin: true
                            ,content: '{{action("Admin\CourseItemController@create")}}?course='+objx.data.id+"&bb=true"
                            ,btn: ['关闭'] //只是为了演示
                            ,yes: function(){
                                layer.closeAll();
                            }
                            ,zIndex: layer.zIndex //重点1
                            ,success: function(layero){
                                layer.setTop(layero); //重点2
                            }
                        });
                        layer.full(index);
                        break;
                    case 'del':
                        layer.confirm("您在删除该课程的同时，该课程下的所有的知识点均会被删除，且无法恢复！您是否要删除该课程？",
                            {btn:['确定','取消']},
                            function (index, layero) {
                                var objx = obj;
                                $.ajax({
                                    url:"{{action("Admin\CourseController@index")}}/"+obj.data.id,
                                    type:"delete",
                                    dataType:"json",
                                    success: function(data){
                                        layer.msg(JSON.stringify(data))

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
