<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AR 课堂</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Cache-Control" content="max-age=7200" />
    <link rel="stylesheet" href="{{asset("css/default.css",true)}}" />
    <script src="{{asset("static/jquery-photo-gallery/jquery.js",true)}}" ></script>
    <script src="{{asset("static/jquery-photo-gallery/jquery.photo.gallery.js",true)}}" ></script>
</head>
<body>

<div class="camera-tip">
    <p>正在打开摄像头...</p>
</div>

<div id="pageWxIos" class="maskerMsg none">
    <div class="masker"></div>
    <div>
        <img class="icon-wx-ios" src="{{asset("static/img/share_ios.png",true)}}">
        <div class="tip">
            <div>请点击右上角<br>选择“在Safari中打开”</div>
        </div>
    </div>
</div>

<div id="loading"></div>
<div id="scanline">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <p>请将目标对准识别框中</p>
    <i></i>
</div>

<div class="movie">
    <div class="movie-btn">&nbsp;</div>
    <video id="movie" webkit-playsinline="true" controls="controls" preload="preload"></video>
</div>

<div class="content">
    <div class="theader">
        <strong>知识点：</strong>
        <span id="title"></span>
    </div>
    <div id="textcontent">
    <p id="text"></p>
    </div>
</div>

<div class="image gallerys">
    <div class="image-btn">&nbsp;</div>
    <img id="image" class="image-content gallery-pic" onclick="$.openPhotoGallery(this)" />
</div>

<div class="graph gallerys">
    <div class="graph-btn">&nbsp;</div>
    <img id="graph" class="image-content gallery-pic" onclick="$.openPhotoGallery(this)" />
</div>



<!-- <div class="header">
    通信网课程小工具
    <div class="ps">遇到难点扫一扫</div>
</div> -->
<div class="footer" style="display: none">
    <input class="openBtn" type="button" value="打开摄像头" id="openCamera" />
    <select class="none" id="videoDevice"></select>
    <input class="none" type="button" value="开始识别" id="start" />
    <input class="none" type="button" value="停止识别" id="stop" />
</div>
<script type="text/javascript" src="{{asset("static/three/three.min.js",true)}}"></script>
<script type="text/javascript" src="{{asset("static/three/inflate.min.js",true)}}"></script>
<script type="text/javascript" src="{{asset("static/three/FBXLoader.js",true)}}"></script>
<script type="text/javascript" src="{{asset("static/three/OrbitControls.js",true)}}"></script>
<script type="text/javascript" src="{{asset("js/adapter.js",true)}}"></script>
<script type="text/javascript" src="{{asset("js/webar.js",true)}}"></script>
<script type="text/javascript" src="{{asset("js/ThreeHelper.js",true)}}"></script>
<script>
    (function(){

        if (navigator.userAgent.includes("MicroMessenger") && navigator.userAgent.includes("iPhone") ){
            document.getElementById("pageWxIos").setAttribute("class","maskerMsg");
        }else{
            const now = (new Date()).getTime();
            const e = document.createElement('script');
            e.setAttribute('src', `{{asset("js/arapp.js",true)}}?t=${now}`);
            document.body.appendChild(e);
        }

    })();
</script>
</body>
</html>
