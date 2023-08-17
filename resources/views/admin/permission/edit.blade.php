<div class="layui-card-body">
    <form class="layui-form" action="{{ url()->current() }}" style="width: 500px;" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">父级权限</label>
            <div class="layui-input-block">
                <select name="pid" lay-search>
                    <option value="0">顶级菜单</option>
                    @foreach ($list as $vo)
                    <option value="{{$vo['id']}}" @if ($info->pid==$vo['id']) selected="selected" @endif >{{$vo['html']}} {{$vo['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" placeholder="标题" value="{{ $info->title }}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="route" placeholder="路由名称" value="{{ $info->route }}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>
            <div class="layui-input-inline w-auto">
                <i class="layui-icon {{ $info->icon }} icon-font28"></i>
                <input type="hidden" name="icon"  value="{{ $info->icon }}">
            </div>
            <div class="layui-input-inline layui-input-wrap w-auto">
                <button id="choose-icon" type="button" class="layui-btn layui-btn-normal">选择图标</button>
            </div>
            <div class="layui-form-mid layui-word-aux">支持font-awesome字体</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="number" name="sort" value="{{ $info->sort }}" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">是否菜单</label>
                <div class="layui-input-block">
                    <input type="checkbox"  name="is_menu" lay-text="是|不是" lay-value="1|0" lay-filter="switchTest" lay-skin="switch" value="{{$info->is_menu}}" @if ($info->is_menu==1) checked @endif />
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">参数</label>
            <div class="layui-input-block">
                <input type="text" name="param" placeholder="参数，http_build_query格式" value="{{ $info->param }}" class="layui-input">
            </div>
        </div>
    </form>
</div>
<script>
    $("#choose-icon").click(function() {
        layer.open({
            type: 1,
            area: ['auto', '600px'],
            resize: true,
            shadeClose: true,
            title: 'icon列表',
            content: `{{view('admin.icon.index')}}`,
            success: function(layero, index, that){
                $('.icons-list>div').click(function(){
                    var class_name = $(this).find('.docs-icon-fontclass').text().trim();
                    $("input[name=icon]").val(class_name);
                    $("input[name=icon]").siblings('i').attr('class', 'layui-icon ' + class_name);
                    layer.close(index);
                });
            }
        });
    });
</script>