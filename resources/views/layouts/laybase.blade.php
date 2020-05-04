<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{$title??"默认界面"}} @if(isset($title)) -- @endif {{config("app.name","Lambda")}}</title>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="{{asset("static/layui/css/layui.css")}}"  media="all">
        <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
        @yield("head")
    </head>
    <body class="@yield("body-attr","layui-layout-body")">
        @yield("content")
        <script src="{{asset("static/layui/layui.js")}}" charset="utf-8"></script>
        @yield("bottom-script")
    </body>
</html>
