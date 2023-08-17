<?php

namespace App\Http\Controllers\Admin;

use App\Library\ArrayHelp;

use App\Library\Y;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    //权限列表
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $name = $request->input('name', '');
        if ($request->isMethod('post')) {
            $list = Role::query()
                ->when($name, function($query, $name) {
                    $query->where('name', $name);
                })
                ->orderByDesc('id')
                ->paginate($pageSize, ['*'], 'page', $page);
            return Y::success('获取成功', ['list' => $list]);
        } else {
            return view('admin.role.index');
        }


    }

    //添加权限
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $params = $request->input();
            $validator = Validator::make($params, [
                'name' => 'required',
                'status' => 'required|in:'. implode(',', Role::STATUS_MAP),
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            $params['guard_name'] = 'admin';
            Role::create($params);
            return Y::success('添加成功');
        } else {
            return view('admin.role.add');
        }
    }

    //修改权限
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $params = $request->input();
            $validator = Validator::make($params, [
                'name' => 'required',
                'status' => 'required|in:'. implode(',', Role::STATUS_MAP),
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            Role::query()->where('id', $id)->update($params);
            return Y::success('更新成功');
        } else {
            //当前权限
            $info = Role::query()->find($id);
            return view('admin.role.edit', [
                'info' => $info
            ]);
        }
    }

    //删除
    public function delete($id)
    {
        if (Role::destroy($id) > 0) {
            return Y::success('删除成功');
        }
        return Y::error('删除失败');
    }

    //分配权限
    public function assign(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $permissionIds = $request->input('permissionIds', []);
            $role = Role::findById($id);
            $hasPermissions = $role->permissions->toArray();
            $ids = [];
            if ($hasPermissions) {
                foreach ($hasPermissions as $permission) {
                    array_push($ids, $permission['id']);
                }
            }
            $addPermissionIds = array_diff($permissionIds, $ids);//追加的权限
            $removePermissionIds = array_diff($ids, $permissionIds);//移除的权限
            $addPermissions = Permission::query()->whereIn('id', $addPermissionIds)->get();
            $removePermissions = Permission::query()->whereIn('id', $removePermissionIds)->get();
            $role->givePermissionTo($addPermissions);
            $role->revokePermissionTo($removePermissions);
            return Y::success();
        } else {
            if ($request->get('ajax', 0)) {
                //获取该角色没有的权限
                $role = Role::findById($id);
                $hasPermissions = $role->permissions->toArray();
                $ids = [];
                if ($hasPermissions) {
                    foreach ($hasPermissions as $permission) {
                        array_push($ids, $permission['id']);
                    }
                }
                //所有权限
                $permissions = Permission::query()->select(['id', 'title', 'pid', 'icon'])->get()->toArray();
                foreach ($permissions as &$permission) {
                    $permission['checked'] = in_array($permission['id'], $ids);
                    $permission['icon'] = 'layui-icon ' . $permission['icon'];
                    $permission['spread'] = true;
                }
                return Y::success('success', [
                    'permissions' => ArrayHelp::list_to_tree($permissions, 'id', 'pid', 'children'),
                    'ids' => $ids,
                ]);
            } else {
                return view('admin.role.assign');
            }
        }
    }
}
