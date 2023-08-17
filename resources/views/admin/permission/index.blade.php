@extends('admin.layout')
@section('content')
<table id="permission-table" lay-filter="permission-table"></table>
<script type="text/html" id="permission-table-tools">
    <div class="layui-btn-container">
        <a class="layui-btn layui-btn-primary layui-btn-sm" lay-event="add">添加</a>
        <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="edit">更新</a>
        <a class="layui-btn layui-btn-sm" lay-event="more">更多 <i class="layui-icon layui-icon-down layui-font-12"></i></a>
    </div>
</script>
<script type="text/html" id="permission-table-toolbar">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="add-permission">添加菜单</button>
    </div>
</script>
<script type="text/html" id="permission-table-switch">
    <input  type="checkbox"  lay-skin="switch" attr-id="@{{ d.id }}" lay-filter="switch-permission" title="是|否"  @{{# if(d.is_menu==1){ }} checked @{{#  } }} />
</script>
<script>
     layui.use(function() {
         layui.treeTable.render({
             elem: '#permission-table',
             url: '{{url()->current()}}', // 此处为静态模拟数据，实际使用时需换成真实接口
             method: 'POST',
             tree: {
                 customName: {
                     children: 'children',
                     name: 'title',
                     id: 'id',
                     pid: 'pid',
                     icon: 'icon',
                 },
             },
             toolbar: '#permission-table-toolbar',
             cols: [[
                 {field: 'id', title: 'id'},
                 {field: 'title', title: '菜单名称'},
                 {field: 'route', title: '路由'},
                 {field: 'name', title: '原省到家路由'},
                 {field: 'is_menu', title: '是否菜单', templet: '#permission-table-switch'},
                 {field: 'sort', title: '排序'},
                 { title: "操作",  align: "center", toolbar: "#permission-table-tools", width: 200}
             ]],
             parseData: function(res) {
                 return {
                     code: res.code, // 解析接口状态
                     msg: res.msg, // 解析提示文本
                     count: res.total,
                     data: res.data.list // 解析数据列表
                 };
             }
         });
         //添加
         layui.treeTable.on('tool(permission-table)', function(obj){
            var layEvent = obj.event;
            if (layEvent === 'add') {
                getForm('{{route('admin.permission-add', ['pid' => '###'])}}'. replace(/###/, obj.data.id), '添加菜单', function (data) {
                    var nodeData = {
                        id: data.id,
                        title: data.title,
                        pid: data.pid,
                        route: data.route,
                        name: data.name,
                        icon: '<div><i class="fa '+ data.icon +'"></i></div>',
                        sort: data.sort,
                    };
                    layui.treeTable.addNodes(obj.config.id, {
                        parentIndex: obj.data["LAY_DATA_INDEX"],
                        index: -1,
                        data: nodeData
                    });
                });
            } else if (layEvent === 'edit') {
                getForm('{{route('admin.permission-edit', ['id' => '###'])}}'. replace(/###/, obj.data.id), '更新菜单', function (data) {
                    layui.treeTable.reloadData(obj.config.id);
                });
            } else if (layEvent === 'more') {
                // 下拉菜单
                layui.dropdown.render({
                    elem: this, // 触发事件的 DOM 对象
                    show: true, // 外部事件触发即显示
                    align: "right", // 右对齐弹出
                    data: [
                        {
                            title: "删除",
                            id: "del"
                        },
                    ],
                    click: function (menudata) {
                        if (menudata.id === "del") {
                            layer.confirm("确定要移除该菜单吗", function (index) {
                                $.post('{{route('admin.permission-delete', ['id' => '###'])}}'. replace(/###/, obj.data.id), {}, function(res) {
                                    if (res.code == 0) {
                                        obj.del();
                                    }
                                })
                                layer.close(index);
                            });
                        }
                    }
                });
            }
         });
         //switch开关
         layui.form.on('switch(switch-permission)', function(obj) {
             let is_menu = obj.elem.checked ? 1: 2;
             $.post('{{route('admin.permission-menu', ['id' => '###'])}}'.replace(/###/, $(obj.elem).attr('attr-id')), {
                 is_menu: is_menu,
             }, function(res) {
             });
         });
         //追加顶级菜单
         layui.table.on('toolbar(permission-table)', function(obj) {
             if (obj.event === 'add-permission') {
                 getForm('{{route('admin.permission-add', ['pid' => 0])}}', '添加菜单', function (data) {
                     layui.table.reload(obj.config.id);
                 });
             }

         });
     })
</script>
@endsection
