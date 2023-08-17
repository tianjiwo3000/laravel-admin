<?php

namespace App\Models;

use App\Library\ArrayHelp;
use App\Library\Tree;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


class Administrator extends Authenticatable
{
    use HasRoles;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    protected $table = 'administrators';

    protected $guard_name = 'admin';

    protected $guarded = [];

    /**
     * 获取菜单树
     * @return array
     * @throws \Exception
     */
    public function getNav()
    {
        if (empty($this->id)) {
            redirect(route('admin.index'));
        }
        //自己
        $self = Permission::query()->where(['route' => Route::currentRouteName()])->first();
        if ($self) {
            $self = $self->toArray();
        } else {
            $self = [
                'id' => 0,
                'name' => '',
                'title' => '',
                'is_menu' => 0,
            ];
        }
        //当前用户含有权限的菜单
        $rules = cache('sys:rule:' . $this->id);
        if (empty($rules)) {
            if ($this->hasRole(config('permission.super_admin'))) {
                $rules = Permission::all()->toArray();
            } else {
                $rules = [];
                if ($this->roles) {
                    foreach ($this->roles as $role) {
                        $rules = array_merge($rules, $role->permissions->toArray());
                    }
                }
            }
            cache(['sys:rule:' . $this->id => $rules], env('APP_ENV') == 'local' ? 1 : 600);
        }
        $menu = cache('sys:menu:' . $this->id);
        if (empty($menu)) {
            $menu = [];
            if ($rules) {
                foreach ($rules as $rule) {
                    if ($rule['is_menu'] == 1) {
                        array_push($menu, $rule);
                    }
                }
            }
            //菜单
            $menu = ArrayHelp::list_to_tree($menu);
            cache(['sys:menu:' . $this->id => $menu], env('APP_ENV') == 'local' ? 1 : 600);
        }
        //面包屑
        $crumb = Tree::getParents($rules, $self['id']);
        array_pop($crumb);
        $parent_ids = [];
        if ($self) {
            array_push($parent_ids, $self['id']);
        }
        if ($crumb) {
            foreach ($crumb as $val) {
                array_push($parent_ids, $val['id']);
            }
        }
        return compact('self', 'menu', 'crumb', 'parent_ids');
    }

}
