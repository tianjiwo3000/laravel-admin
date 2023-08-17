<div id="role-tree" style="width:600px; height:600px;"></div>
<script type="text/javascript">
    let tree = layui.tree;
    let $ = layui.$;
    $.get('{{url()->current()}}' + '?ajax=1', {}, function (res) {
        if (res.code == 0) {
            // 渲染
            let treeRender = tree.render({
                elem: '#role-tree',
                data: res.data.permissions,
                showCheckbox: true,  // 是否显示复选框
                id: 'role-tree',
                //isJump: true, // 是否允许点击节点时弹出新窗口跳转
            });
            treeRender.config.oncheck = function(obj){
                let ids = [];
                getCheckedList(tree.getChecked('role-tree'), ids);
                $.post('{{url()->current()}}', {
                    permissionIds : ids,
                }, function (res) {
                    if (res.code != 0) {
                        layer.msg(res.msg);
                    }
                });
            }
        } else {
            layer.msg(res.msg);
        }
    });
    // 获取选中节点的id
    function getCheckedList(data, ids) {
        $.each(data, function (index, item) {
            ids.push(item.id);
            item.children && getCheckedList(item.children, ids);
        })
    }
</script>
