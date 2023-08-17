<?php

namespace App\Http\Controllers\Admin;

use App\Library\ArrayHelp;
use App\Library\Tree;
use App\Library\Y;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    //权限列表
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $permissions = Permission::query()
                ->orderBy('sort')
                ->orderByDesc('id')
                ->get()
                ->toArray();
            foreach ($permissions as &$permission) {
                $permission['icon'] = '<div><i class="layui-icon ' . $permission['icon'] . '"></i></div>';
            }
            return Y::success('success', [
                'list' => ArrayHelp::list_to_tree($permissions, 'id', 'pid', 'children'),
            ]);
        } else {
            return view('admin.permission.index');
        }
    }

    //添加权限
    public function add(Request $request, $pid)
    {
        if ($request->isMethod('post')) {
            $post      = $request->post();
            $validator = Validator::make($post, [
                'title' => 'required',
                'route'  => 'required',
                'icon' => 'required',
            ], [
                'title.*' => '菜单名称不能为空',
                'route.*' => '路由不能为空',
                'icon.*' => '图标不能为空',
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            $post['guard_name'] = 'admin';
            $post['name'] = $post['route'];
            $post['pid'] = $pid;
            $permission = Permission::create($post);
            return Y::success('添加成功', $permission);
        } else {
            if (!$pid) {
                $pidName = '顶级菜单';
            } else {
                $parentPermission = Permission::findById($pid);
                $pidName = $parentPermission['title'];
            }
            return view('admin.permission.add', [
                'pidName' => $pidName
            ]);
        }
    }

    //修改权限
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $post = $request->post();
            $validator = Validator::make($post, [
                'title' => 'required',
                'route'  => 'required',
                'icon' => 'required',
            ], [
                'title.*' => '菜单名称不能为空',
                'route.*' => '路由不能为空',
                'icon.*' => '图标不能为空',
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            $post['guard_name'] = 'admin';
            $post['name'] = $post['route'];
            Permission::query()->where('id', $id)->update($post);
            $permission = Permission::query()->find($id);
            return Y::success('更新成功', $permission);
        } else {
            //获取层次权限
            $list = Permission::all()->toArray();
            $list = Tree::unlimitForLevel($list);
            //当前权限
            $info = Permission::query()->findOrFail($id);
            return view('admin.permission.edit', [
                'list' => $list,
                'info' => $info
            ]);
        }
    }

    //是否菜单切换
    public function menu(Request $request, $id)
    {
        $is_menu = intval($request->input('is_menu'));
        Permission::query()->where('id', $id)->update(['is_menu' => $is_menu]);
        return Y::success('设置成功');
    }

    //排序
    public function sort(Request $request, $id)
    {
        $sort = intval($request->input('sort'));
        Permission::query()->where('id', $id)->update(['sort' => $sort]);
        return Y::success('设置成功');
    }

    //删除
    public function delete($id)
    {
        Permission::query()->where('id', $id)->delete();
        return Y::success('删除成功');
    }
}
