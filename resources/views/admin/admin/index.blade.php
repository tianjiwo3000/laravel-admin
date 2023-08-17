@extends('admin.layout')
@section('content')
    <form class="layui-form layui-row layui-col-space16">
        <div class="layui-col-md4">
            <div class="layui-input-wrap">
                <div class="layui-input-prefix">
                    <i class="layui-icon layui-icon-username"></i>
                </div>
                <input type="text" name="account" value="" placeholder="账号" class="layui-input" lay-affix="clear">
            </div>
        </div>
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="admin-search">搜索</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </form>
    <table class="layui-hide layui-table" id="admin-table" lay-filter="admin-table"></table>
    <script type="text/html" id="admin-table-tools">
        <div class="layui-clear-space">
            <a class="layui-btn layui-btn-warm layui-btn-sm" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-sm" lay-event="more">
                更多
                <i class="layui-icon layui-icon-down layui-font-12"></i>
            </a>
        </div>
    </script>
    <script type="text/html" id="admin-table-toolbar">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="add-admin">添加管理员</button>
        </div>
    </script>
    <script>
        layui.use(function () {
            let $ = layui.$;
            layui.table.render({
                elem: '#admin-table',
                url: '{{route('admin.admin-index')}}',
                method: 'post',
                page: {
                    curr: 1,
                    limit: 10,
                    theme: '#1E9FFF'
                },
                request: {
                    pageName: 'page',
                    limitName: 'pageSize'
                },
                autoSort: false,
                defaultToolbar: ['filter', {
                    title: '提示',
                    layEvent: 'LAYTABLE_EXPORTS',
                    icon: 'layui-icon-export'
                }, 'print'],
                toolbar: '#admin-table-toolbar',
                cols: [[
                    {type: 'checkbox'},
                    {field: 'id', title: 'id', sort: true},
                    {field: 'account', title: '账号'},
                    {field: 'real_name', title: '姓名'},
                    {field: 'phone', title: '手机'},
                    {fixed: 'right', align: 'center', title: '操作', toolbar: '#admin-table-tools'}
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

            //添加
            layui.table.on('tool(admin-table)', function (obj) {
                var layEvent = obj.event;
                if (layEvent === 'edit') {//更新
                    getForm('{{route('admin.admin-edit', ['id' => '###'])}}'.replace(/###/, obj.data.id), '更新菜单', function (data) {
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
                                title: "删除",
                                id: "del"
                            },
                        ],
                        click: function (menudata) {
                            if (menudata.id === "del") {
                                layer.confirm("确定要移除该管理员吗", function (index) {
                                    $.post('{{route('admin.admin-delete', ['id' => '###'])}}'.replace(/###/, obj.data.id), {}, function (res) {
                                        if (res.code == 0) {
                                            obj.del();
                                        } else {
                                            layer.msg(res.msg);
                                        }
                                        layer.close(index);
                                    })
                                });
                            }
                        }
                    });
                }
            });
            //新增管理员
            layui.table.on('toolbar(admin-table)', function (obj) {
                if (obj.event === 'add-admin') {
                    getForm('{{route('admin.admin-add')}}', '添加管理员', function (data) {
                        layui.table.reload(obj.config.id);
                    });
                } else if (obj.event === 'LAYTABLE_EXPORTS') {
                    let header = ['id', '账号', '姓名', '手机'];
                    let data = [];
                    let page = 1;
                    let pageSize = 1000;//单次请求接口的数据
                    let loading = layer.load(2, {content:'正在导出...', shade: 0.2});
                    exports(data, page, pageSize);
                    function exports(data, page, pageSize) {
                        let where = obj.config.where;
                        where.page = page;
                        where.pageSize = pageSize;
                        $.post(obj.config.url, where, function (res) {
                            if (res.code === 0) {
                                let items = res.data.list.data.map(function (item) {
                                    return [
                                        item.id,
                                        item.account,
                                        item.real_name,
                                        item.phone
                                    ]
                                });
                                data = data.concat(items);
                                page++;
                                if (page <= obj.config.page.pages) {
                                    exports(data, page);
                                } else {
                                    layui.table.exportFile(header, data, {title: '管理员列表', type: 'xls'});
                                    layer.close(loading);
                                    layer.msg('导出成功');
                                }
                            } else {
                                layer.close(loading);
                                layer.msg(res.msg);
                            }
                        });
                    }
                }
            });
            // 搜索提交
            layui.form.on('submit(admin-search)', function (data) {
                // 执行搜索重载
                layui.table.reload('admin-table', {
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