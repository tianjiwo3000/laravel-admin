<?php

namespace App\Http\Controllers\Admin;

use App\Library\ArrayHelp;
use App\Library\Y;
use App\Models\Admin;
use App\Models\Administrator;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $account = $request->input('account', '');
        if ($request->isMethod('post')) {
            $list = Administrator::query()
                ->with(['roles'])
                ->when($account, function($query, $account) {
                    $query->where('account', 'like', $account . '%');
                })
                ->orderByDesc('id')
                ->paginate($pageSize, ['*'], 'page', $page);
            return Y::success('获取成功', ['list' => $list]);
        } else {
            return view('admin.admin.index');
        }
    }

    /**
     * 添加管理员
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $params = $request->input();
            $validator = Validator::make($params, [
                'account' => 'required',
                'real_name' => 'required',
                'phone' => 'required',
                'password' => 'required',
                'roles' => 'array'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            $hasAdmin = Administrator::query()->where('account', $params['account'])->exists();
            if ($hasAdmin) {
                return Y::error('账户已存在');
            }
            if (!$params['roles']) {
                return Y::error('未选择角色');
            }
            $roles = $params['roles'];
            unset($params['roles']);
            $params['password'] = Hash::make(md5($params['password']));
            $admin = Administrator::query()->create($params);
            $admin->syncRoles($roles);
            return Y::success('添加成功');
        } else {
            $roles = Role::all();
            return view('admin.admin.add', [
                'roles' => $roles
            ]);
        }
    }

    /**
     * 更新管理员
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $admin = Administrator::query()->find($id);
        if (!$admin) {
            return Y::error('管理员不存在');
        }
        if ($request->isMethod('post')) {
            $params = $request->input();
            $validator = Validator::make($params, [
                'account' => 'required',
                'real_name' => 'required',
                'password' => 'required',
                'roles' => 'array'
            ]);
            if ($validator->fails()) {
                return Y::error($validator->errors()->first());
            }
            if (!$params['roles']) {
                return Y::error('未选择角色');
            }
            $roles = $params['roles'];
            if (empty($params['password'])) {
                unset($params['password']);
            } else {
                $params['password'] = Hash::make(md5($params['password']));
            }
            unset($params['roles']);
            $admin->update($params);
            $admin->syncRoles($roles);
            return Y::success('更新成功');
        } else {
            //当前权限
            $admin = Administrator::query()->with(['roles'])->find($id);
            $roles = Role::all();
            return view('admin.admin.edit', [
                'admin' => $admin,
                'roles' => $roles,
            ]);
        }
    }

    /**
     * 删除管理员
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        Administrator::destroy($id);
        return Y::error('删除失败');
    }


    public function menu(Request $request)
    {
        $admin = auth('admin')->user();
        if ($admin->hasRole(config('permission.super_admin'))) {
            $permissions = Permission::all();
        } else {
            $permissions = $admin->getAllPermissions();
        }
        $realPermissions = $permissions
            ->where('is_menu', 1)
            ->sortBy('sort')
            ->transform(function($item) {
            parse_str($item->param, $param);
            $item->url = route($item->route, $param);
            return $item;
        })->toArray();
        $realPermissions = ArrayHelp::list_to_tree($realPermissions, 'id', 'pid', 'children');
        return Y::success('获取成功', $realPermissions);
    }

}
