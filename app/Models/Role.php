<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Role extends \Spatie\Permission\Models\Role
{

    protected $guarded = [];


    /**
     * 状态: 正常
     */
    const STATUS_NORMAL = 1;

    /**
     * 状态: 禁用
     */
    const STATUS_DISABLE = 2;

    const STATUS_MAP = [
        self::STATUS_NORMAL,
        self::STATUS_DISABLE,
    ];
}
