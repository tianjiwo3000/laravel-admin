<?php
/**
 * 后台管理
 */

use \Illuminate\Support\Facades\Route;

$route = Route::name('admin.');
/**
 * 不需要登录的模块
 */
$route->group(function () {
    Route::any('login', 'PublicController@login')->name('login');//登录
    Route::any('logout', 'PublicController@logout')->name('logout');//登出
    Route::any('flush', 'IndexController@flush')->name('flush');//刷新缓存
    Route::post('menu', 'AdminController@menu')->name('menu');//左侧菜单树
});

/**
 * 需要登录的模块
 */
$route->middleware(['auth.admin'])->group(function () {
    Route::any('/', 'IndexController@index')->name('index');//首页

    /**
     * 管理员管理
     */
    Route::any('admin/index', 'AdminController@index')->name('admin-index');
    Route::any('admin/add', 'AdminController@add')->name('admin-add');
    Route::any('admin/edit/{id}', 'AdminController@edit')->name('admin-edit');
    Route::post('admin/delete/{id}', 'AdminController@delete')->name('admin-delete');
    Route::post('admin/status/{id}', 'AdminController@status')->name('admin-status');

    /**
     * 角色管理
     */
    Route::any('role/index', 'RoleController@index')->name('role-index');
    Route::any('role/add', 'RoleController@add')->name('role-add');
    Route::any('role/edit/{id}', 'RoleController@edit')->name('role-edit');
    Route::any('role/assign/{id}', 'RoleController@assign')->name('role-assign');
    Route::post('role/delete/{id}', 'RoleController@delete')->name('role-delete');

    /**
     * 菜单管理
     */
    Route::any('permission/index', 'PermissionController@index')->name('permission-index');//菜单列表
    Route::any('permission/add/{pid}', 'PermissionController@add')->name('permission-add');//添加菜单
    Route::any('permission/edit/{id}', 'PermissionController@edit')->name('permission-edit');//更新菜单
    Route::post('permission/menu/{id}', 'PermissionController@menu')->name('permission-menu');//设置菜单
    Route::post('permission/sort/{id}', 'PermissionController@sort')->name('permission-sort');//菜单排序
    Route::post('permission/delete/{id}', 'PermissionController@delete')->name('permission-delete');//删除菜单

});

