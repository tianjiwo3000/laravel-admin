<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>欢迎使用 {{ env('APP_NAME') }} 后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('favicon.ico')}}">
    <link rel="stylesheet" href="{{url('static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{url('static/admin/css/style.css')}}">
    <script type="text/javascript" src="{{url('static/admin/js/md5.min.js')}}"></script>
    <script type="text/javascript" src="{{url('static/admin/layui/layui.js')}}"></script>
    <script type="text/javascript" src="{{ url('static/admin/admin.js')}}"></script>
</head>

<body>
<div class="login">
    <div class="layui-card">
        <div class="layui-card-header">
            欢迎使用 <b style="font-family:Monaco,Consolas">{{ env('APP_NAME') }}</b> 后台管理系统
        </div>
        <div class="layui-card-body">
            <form class="layui-form layui-form-pane" lay-filter="loginForm">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" name="account" placeholder="请输入用户名" autocomplete="off" class="layui-input ">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" placeholder="请输入密码" autocomplete="off"
                               class="layui-input ">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">验证码</label>
                    <div class="layui-input-inline" style="width:105px">
                        <input type="text" name="captcha" maxlength="4" placeholder="验证码" autocomplete="off"
                               class="layui-input ">
                    </div>
                    <div class="layui-input-inline" style="width:100px">
                        <img src="{{captcha_src('flat')}}" alt="captcha" id="captcha-src"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-normal layui-btn-fluid" lay-submit="" lay-filter="login">登 录
                    </button>
                </div>
            </form>
            <p>- <b style="font-family:Monaco,Consolas;font-weight:300"> 超越自我，至上追求</b> laravel5.7-layerui管理后台 -</p>
        </div>
    </div>
</div>

<script>
    $('#captcha-src').click(function () {
        var str = '{{captcha_src('flat')}}';
        $(this).attr('src', str + '?' + Math.random());
    });

    layui.use(function () {
        var form = layui.form,
            layer = layui.layer;

        form.on('submit(login)', function (data) {
            let obj = data.field;
            obj.password = md5(obj.password);
            $.ajax({
                type: 'POST',
                url: '{{ url()->current() }}',
                data: obj,
                success: function (res) {
                    layer.msg(res.msg);
                    if (res.code == 0) {
                        window.location.href = res.url;
                    } else {
                        $('#captcha-src').click();
                    }

                }
            });
            return false;
        });

    })
    ;
</script>
</body>

</html>
