<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AR 课堂</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="{{asset("css/default.css",true)}}" />
</head>
<body>
<!-- <div class="header">
    通信网课程小工具
    <div class="ps">遇到难点扫一扫</div>
</div> -->
<div class="footer">
    <input class="openBtn" type="button" value="打开摄像头" id="openCamera" />
    <select class="none" id="videoDevice"></select>
    <input class="none" type="button" value="开始识别" id="start" />
    <input class="none" type="button" value="停止识别" id="stop" />
</div>

<script type="text/javascript" src="{{asset("js/adapter.js",true)}}"></script>
<script type="text/javascript" src="{{asset("js/webar.js",true)}}"></script>
<script>
    (function(){

        const now = (new Date()).getTime();

        const e = document.createElement('script');
        e.setAttribute('src', `{{asset("js/arapp.js",true)}}?t=${now}`);
        document.body.appendChild(e);
    })();
</script>
</body>
</html>
