<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'route_name'];

    /**
     * The list of routes when authenticated.
     *
     * @return string[]
     */
    public static function routeNameList()
    {
        return [
            'pages',
            'navigation-menus',
            'dashboard',
            'users',
            'user-permissions',
        ];
    }

    /**
     * Checks if the current user role has access
     *
     * @param $userRole
     * @param $routeName
     * @return bool
     */
    public static function isRoleHasRightToAccess($userRole, $routeName)
    {
        try {
            $model = static::where('role', $userRole)
                ->where('route_name', $routeName)
                ->first();

            return (bool)$model;
        } catch (\Throwable $throwable) {

            return false;
        }
    }
}
