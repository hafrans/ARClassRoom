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
                    <col>
                    <col width="100">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th><b>系统序号</b></th>
                    <td>{{$simage->id}}</td>
                    <th><b>目标名称</b></th>
                    <td>{{$simage->name}}</td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <th><b>图片</b></th>
                    <td colspan="3" style="position: relative">
                        <img style="max-width:100%; max-height: 200px;"
                             src="{{action("Admin\SImageController@index")}}/{{$simage->id}}"/>
                    </td>
                </tr>
                <tr>
                    <td><b>绑定课程</b></td>
                    <td colspan="3">

                        <div class="layui-input-block" style="margin-left: 0;">
                            <input type="text" name="course" required lay-verify="required" maxlength="255"
                                   placeholder="请输入课程" id="input_course" autocomplete="xxx" class="layui-input" list="courses">
                            <datalist id="courses">
                            </datalist>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td><b>绑定知识点</b></td>
                    <td colspan="3">
                        <div class="layui-input-block" style="margin-left: 0;">
                            <input type="text" name="course_item" required lay-verify="required" maxlength="255"
                                   placeholder="请输入课程" id="input_course_item" autocomplete="xxx" class="layui-input" list="course_items">
                            <datalist id="course_items">

                            </datalist>
                        </div>
                    </td>
                </tr>
                <tr>

                    <td colspan="4" style="text-align: center;">
                        <button class="layui-btn layui-btn-lg layui-btn-normal">绑定</button>
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

        let timer = null;
        let flag = true;
        let formerInput = ""

        function debounce(func, timeout) {
            return function (value) {
                if (timer != null) {
                    clearTimeout(timer);
                }
                timer = setTimeout(function(){func(value);}, timeout);
            }
        }


        function throttle(func, timeout) {
            return function (value) {
                if (flag) {
                    setTimeout(function(){func(value)}, 0);
                    flag = false;
                    setTimeout(function () {
                        flag = true;
                    }, timeout);
                }

            }
        }

        function updateCourse(courseName) {

            $.ajax({
                url:"{{url("/admin/cloudImage/find/course")}}",
                type:"get",
                dataType:"json",
                data:"name="+encodeURI(courseName.trim()),
                success:function(data){
                    if(data.code == 0){

                        let lists = data.data;
                        let dataListElement = document.querySelector("#courses");
                        dataListElement.innerHTML = ""
                        let dataOption = document.createElement("OPTION");
                        for (let i of lists){

                            dataOption.dataset.id = i.id;
                            dataOption.value = i.name;

                            dataListElement.appendChild(dataOption.cloneNode());

                        }

                    }else{
                        layer.msg("获取失败！"+data.message);
                    }

                },
                error(){
                    layer.msg("获取失败");
                }
            });

        }

        function updateCourseItem(value) {

            let courseName = value.course;
            let courseItemName = value.courseItem;

            $.ajax({
                url:"{{url("/admin/cloudImage/find/courseItem")}}",
                type:"get",
                dataType:"json",
                data:"name="+encodeURI(courseItemName.trim())+"&course="+encodeURIComponent(courseName.trim()),
                success:function(data){
                    if(data.code == 0){

                        let lists = data.data;
                        let dataListElement = document.querySelector("#course_items");
                        dataListElement.innerHTML = ""
                        let dataOption = document.createElement("OPTION");
                        for (let i of lists){
                            dataOption.dataset.id = i.id;
                            dataOption.value = i.name;
                            dataListElement.appendChild(dataOption.cloneNode());
                        }

                    }else if(data.code == 1){
                        layer.msg("课程不存在！");
                        document.getElementById("input_course_item").value = ""
                    }else{
                        layer.msg("获取失败！"+data.message);
                    }

                },
                error(){
                    layer.msg("获取失败");
                }
            });

        }



        let debouncedUpdateCourse = debounce(updateCourse, 500);
        let debouncedUpdateCourseItem = debounce(updateCourseItem,500);

        document.getElementById("input_course").addEventListener("input",function(e){
            if(e.target.value != formerInput){
                debouncedUpdateCourse(e.target.value);
                formerInput = e.target.value
            }
        },false);

        document.getElementById("input_course_item").addEventListener("focus",function(e){
            let courseField = document.getElementById("input_course");
            if(courseField.value.length == 0){
                debouncedUpdateCourseItem("");
            }

        },false);

        document.getElementById("input_course_item").addEventListener("input",function(e){

                debouncedUpdateCourseItem({
                    course:document.getElementById("input_course").value,
                    courseItem:e.target.value,
                });

        },false);

        document.getElementById("input_course_item").addEventListener("focus",function(e){
            let courseField = document.getElementById("input_course");
            let courseItemField = document.getElementById("input_course_item");
            if(courseField.value.length > 0 && courseItemField.value.length == 0){
                debouncedUpdateCourseItem({
                    course:courseField.value,
                    courseItem:"",
                });
            }

        },false);



        layui.use(['form', 'table'], function () {
            var form = layui.form;
            var table = layui.table;
        });


    </script>

@endsection
