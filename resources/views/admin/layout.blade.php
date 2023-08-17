<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>后台管理 | {{ env('APP_NAME') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('favicon.ico')}}">
    <link rel="stylesheet" href="{{url('static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{url('static/admin/css/style.css')}}">
    <script type="text/javascript" src="{{url('static/admin/js/md5.min.js')}}"></script>
    <script type="text/javascript" src="{{url('static/admin/layui/layui.js')}}"></script>
    <script type="text/javascript" src="{{ url('static/admin/admin.js')}}"></script>
    @yield('style')
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin" layui-layout="open">
    <div class="layui-header">
        <div class="layui-logo">
            <span>{{ env('APP_NAME') }} 管理系统</span>
        </div>
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;" id="flexible" title="侧边伸缩" >
                    <i class="layui-icon layui-icon-shrink-right"></i>
                </a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;" id="refresh" title="刷新数据">
                    <i class="layui-icon layui-icon-refresh"></i>
                </a>
            </li>
            @role('super admin')
            <li class="layui-nav-item" lay-unselect>
                <a href="{{route('admin.flush')}}" class="ajax-post" title="清空缓存">
                    <i class="fa fa-magic"></i>
                </a>
            </li>
            @endrole
        </ul>
        <ul class="layui-nav layui-layout-right">
            @role('super admin')
            <li class="layui-nav-item" lay-unselect>
                <a href="{{route('admin.message')}}" layadmin-event="message">
                    <i class="layui-icon layui-icon-notice"></i>
                    <span class="layui-badge-dot"></span>
                </a>
            </li>
            @endrole
            <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;" class="user"><img class="layui-nav-img" src="{{ url('static/admin/img/a0.jpg') }}"/>{{ Auth::user()->account }} <i class="layui-icon layui-icon-more-vertical"></i></a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out"></i> 退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <!-- 左侧菜单导航--->
    <ul class="layui-nav layui-nav-tree" lay-filter="leftNav" id="leftNav">
    </ul>
    <script>
        layui.use(function () {
            let $ = layui.$;
            //侧边收缩
            $('#flexible').click(function() {
                let status = $('.layui-layout-admin').attr('layui-layout') == 'closed' ? 'open' : 'closed';
                $('.layui-layout-admin').attr('layui-layout', status);
            });
            //清除缓存
            $('#refresh').click(function() {
                $.post('{{route('admin.flush')}}', function(res) {
                    if (res.code == 0) {
                        layer.msg(res.msg);
                    }
                });
            });
            //菜单渲染
            $.post('{{route('admin.menu')}}', {}, function (res) {
                if (res.code == 0) {
                    $("#leftNav").html(getMenu(res.data));
                    layui.element.render('nav', 'leftNav');
                    $("#leftNav .layui-nav-item").each(function () {
                        if ($(this).attr("route") == '{{\Illuminate\Support\Facades\Route::currentRouteName()}}') {
                            $(this).addClass('layui-this');
                            $(this).parents('.layui-nav-item').addClass('layui-nav-itemed');
                        }
                    });
                    let breadcrumbHtml = '';
                    $("#leftNav .layui-nav-itemed").each(function () {
                        breadcrumbHtml += '<a href="javascript:;">' + $(this).children('a').text() + '</a>';
                    });
                    breadcrumbHtml += '<a><cite>' + $("#leftNav .layui-this").children('a').text() + '</cite></a>';
                    $("#breadcrumb").html(breadcrumbHtml);
                    layui.element.render('breadcrumb', 'breadcrumb');
                }
            });

        });

        //左侧菜单树
        function getMenu(data) {
            let html = '';
            data.forEach(function (item) {
                html += '<li class="layui-nav-item"  route="' + item.route + '">';
                if (item.children && item.children.length > 0) {
                    html += '<a href="javascript:;"><i class="layui-icon ' + item.icon + '"></i><span class="margin-left-24">' + item.title + '</span></a>';
                    html += '<dl class="layui-nav-child">';
                    html += getMenu(item.children);
                    html += '</dl>';
                } else {
                    html += '<a href="' + item.url + '"><i class="layui-icon ' + item.icon + '"></i><span class="margin-left-24">' + item.title + '</span></a>';
                }
                html += '</li>';
            });
            return html;
        }
    </script>
    <div class="main">
        <div class="main-header">
            <span class="layui-breadcrumb" lay-separator=">" id="breadcrumb" lay-filter="breadcrumb">
            </span>
        </div>
        <div class="main-content">
            @section('main')
                <div class="layui-fluid" style="padding: 0 12px;">
                    <div class="layui-card">
                        <div class="layui-card-header"></div>
                        <div class="layui-card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            @show
        </div>
        <div class="main-footer">
            <!-- 底部固定区域 -->
            Copyright © 2023-{{ date('Y') }} {{env('APP_NAME')}} 后台管理系统. All rights reserved.
        </div>
    </div>
</div>

@yield('script')
</body>

</html>
