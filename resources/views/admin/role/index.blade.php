@extends('admin.layout')
@section('content')
    <form class="layui-form layui-row layui-col-space16">
        <div class="layui-col-md4">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-username"></i>
                </div>
                <input type="text" name="name" value="" placeholder="角色名" class="layui-input" lay-affix="clear">
            </div>
        </div>
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="role-search">搜索</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </form>
    <table class="layui-hide layui-table" id="role-table" lay-filter="role-table"></table>
    <script type="text/html" id="role-table-tools">
        <div class="layui-clear-space">
            <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-sm" lay-event="more">
                更多
                <i class="layui-icon layui-icon-down layui-font-12"></i>
            </a>
        </div>
    </script>
    <script type="text/html" id="role-table-toolbar">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="add-role">添加角色</button>
        </div>
    </script>
    <script type="text/html" id="role-table-switch">
        <input  type="checkbox"  lay-skin="switch" attr-id="@{{ d.id }}" lay-filter="switchTest" title="启用|禁用"  @{{# if(d.status==1){ }} checked @{{#  } }} />
    </script>
    <script>
        layui.use(function() {
            layui.table.render({
                elem: '#role-table',
                url: '{{route('admin.role-index')}}',
                method: 'post',
                page: {
                    curr: 1,
                    limit: 10,
                    theme: '#1E9FFF',
                    layout: ['count', 'prev','page','next', 'limit', 'skip']

                },
                request: {
                    pageName: 'page',
                    limitName: 'pageSize'
                },
                autoSort: false,
                toolbar: '#role-table-toolbar',
                cols: [[
                    {type: 'checkbox'},
                    {field: 'id', title: 'id', sort: true},
                    {field: 'name', title: '角色名'},
                    {field: 'status', title: '状态', templet: '#role-table-switch'},
                    {field: 'remark', title: '备注'},
                    {fixed: 'right', align:'center', title: '操作', toolbar: '#role-table-tools'}
                ]],
                parseData: function (res) {
                    return {
                        code: res.code,
                        message: res.msg,
                        data: res.data.list.data,
                        count: res.data.list.total,
                    };
                }
            });

            //表格操作区
            layui.table.on('tool(role-table)', function(obj){
                var layEvent = obj.event;
                if (layEvent === 'edit') {//更新
                    getForm('{{route('admin.role-edit', ['id' => '###'])}}'. replace(/###/, obj.data.id), '更新角色', function (data) {
                        layui.table.reloadData(obj.config.id);
                    });
                } else if (layEvent === 'more') {
                    // 下拉菜单
                    layui.dropdown.render({
                        elem: this, // 触发事件的 DOM 对象
                        show: true, // 外部事件触发即显示
                        align: "right", // 右对齐弹出
                        data: [
                            {
                                title: "分配权限",
                                id: "assign"
                            },
                            {
                                title: "删除",
                                id: "del"
                            },
                        ],
                        click: function (menudata) {
                            if (menudata.id === "del") {
                                layer.confirm("确定要移除该角色吗", function (index) {
                                    $.post('{{route('admin.role-delete', ['id' => '###'])}}'. replace(/###/, obj.data.id), {}, function(res) {
                                        if (res.code == 0) {
                                            obj.del();
                                        }
                                    })
                                    layer.close(index);
                                });
                            } else if (menudata.id === "assign") {
                                getForm('{{route('admin.role-assign', ['id' => '###'])}}'. replace(/###/, obj.data.id), '分配角色', function (data) {
                                    layui.table.reloadData(obj.config.id);
                                });
                            }
                        }
                    });
                }
            });
            //新增角色
            layui.table.on('toolbar(role-table)', function(obj) {
                if (obj.event === 'add-role') {
                    getForm('{{route('admin.role-add')}}', '添加角色', function (data) {
                        layui.table.reload(obj.config.id);
                    });
                }
            });

            // 搜索提交
            layui.form.on('submit(role-search)', function(data){
                // 执行搜索重载
                layui.table.reload('role-table', {
                    page: {
                        curr: 1 // 重新从第 1 页开始
                    },
                    where: data.field // 搜索的字段
                });
                return false;
            });
        });
    </script>
@endsection