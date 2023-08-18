let $ = layui.$;
//全局方法
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    cache: true,
   /* dataFilter: function(data, type) {
        if (type == 'json') {
            let parseData = JSON.parse(data);
            console.log(parseData)
            if (parseData.code !== 0) {
                layer.msg(data.msg);
                return false;
            }
        }
        return data;
    }*/
});

//layui-table全局设置
layui.table.set({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
});
//layui-table全局设置
layui.treeTable.set({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
});

//自定义弹出表单
function getForm(url, title, callback) {
    if (!url) return;
    title = title || '表单';
    $.get(url, function (html) {
        if (typeof html === 'object') {
            layer.msg(html.msg);
            return false;
        }
        layer.open({
            type: 1,
            title: title,
            content: html,
            scrollbar: true,
            maxWidth: '90%',
            maxHeight: '90%',
            anim: 4,
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                if ($(layero).find('.layui-layer-btn0').attr('disabled')) {
                    return false;
                }
                $(layero).find('.layui-layer-btn0').attr('disabled', 'disabled');
                let _form = $(layero).find('form');
                if (_form.length) {
                    let formValues = _form.serializeArray();
                    let switchTest = _form.find('input[lay-skin=switch]');
                    switchTest.each(function() {
                        let layValue = $(this).attr('lay-value');
                        let layValueData = layValue ? layValue.split('|') : [1, 0];
                        let obj = {
                            name: $(this).attr('name'),
                            value: $(this).siblings('.layui-form-switch').hasClass('layui-form-onswitch') ? layValueData[0] : layValueData[1],
                        };
                        formValues.push(obj);
                    });
                    layui.form.on('submit(layerForm)', function (data) {
                        $.ajax({
                            url:  _form.attr('action') || '',
                            type: 'POST',
                            dataType: 'json',
                            data: formValues,
                        }).done(function (res) {
                            if (res.code == 0) {
                                layer.msg(res.msg, {time: 1200}, function () {
                                    layer.close(index);
                                    callback(res.data);
                                });
                            } else {
                                var str = res.msg || '服务器异常';
                                layer.msg(str);
                                $(layero).find('.layui-layer-btn0').removeAttr('disabled')
                            }
                        })
                            .fail(function (jqXHR, textStatus, errorThrown) {
                                $(layero).find('.layui-layer-btn0').removeAttr('disabled')
                            });
                    });
                } else {
                    layer.close(index);
                    callback(null);
                }
            },
            btn2: function (index) {
                layer.close(index);
            },
            success: function (layero) {
                layero.addClass('layui-form');
                layero.find(".layui-layer-btn0").attr({'lay-filter': 'layerForm', 'lay-submit': ''});
                layui.form.render();
            }
        }, 'html');
    });
}

layui.config({
    base: '/static/admin/layui/extends/'
});