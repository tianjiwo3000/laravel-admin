<div class="layui-card-body">
    <form class="layui-form" action="{{ url()->current() }}" style="width: 500px;" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">父级菜单</label>
            <div class="layui-form-mid layui-text-em">
                {{$pidName}}
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">菜单名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" placeholder="菜单名称" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">路由</label>
            <div class="layui-input-block">
                <input type="text" name="route" placeholder="路由" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>

            <div class="layui-input-inline layui-input-wrap w-auto">
                <i class="layui-icon layui-icon-edit icon-font28"></i>
                <input type="hidden" name="icon"  value="layui-icon-edit">
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
                    <input type="number" name="sort" value="0" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">是否菜单</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_menu" value="1" lay-text="是|不是" lay-skin="switch">
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">参数</label>
            <div class="layui-input-block">
                <input type="text" name="param" placeholder="参数，http_build_query格式" value="" class="layui-input">
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