<div class="layui-card-body">
    <form class="layui-form" action="{{ url()->current() }}" style="width: 500px;" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">角色名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" placeholder="角色名称" value="{{ $info->name }}" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="status" lay-filter="switchTest" lay-value="1|2" value="{{$info->status}}" lay-text="启用|禁用" lay-skin="switch" @if ($info->status == 1) checked @endif>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
                <textarea  name="remark" placeholder="备注"  class="layui-textarea">{{$info->remark}}</textarea>
            </div>
        </div>
    </form>
</div>