<?php
namespace App\Helpers;

use App\Repository\UAM\PermissionRepository;
use App\Repository\UAM\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Authorization
{
    private static function getPermissionKey(int $userId = 0): string
    {
        $id = Auth::id();
        if($userId != 0)
        {
            $id = $userId;
        }
        return $id."-userPermissions";
    }

    private static function getRoleKey(int $userId = 0): string
    {
        $id = Auth::id();
        if($userId != 0)
        {
            $id = $userId;
        }
        return $id."-userRoles";
    }

    public static function getUserAkses(int $userId = 0, $time = 30 * 24 * 60 * 60): array
    {
        $id = Auth::id();
        if($userId != 0)
        {
            $id = $userId;
        }
        $key = self::getPermissionKey($id);
        $user = (new UserRepository())->filterById($id)->getQuery()->with(['roles:id,name'])->first();
        $permRepo = new PermissionRepository();

        if($user->roles->where('id', 1)->isNotEmpty())
        {
            $permissions = $permRepo->get()->toArray();
        }
        else {
            $permissions = $permRepo->getByRoleId(
                $user->roles->map(function($role) { return $role->id; })->toArray()
            )->get()->toArray();
        }
        

        //set permission
        Cache::forget($key);
        Cache::put($key, $permissions, $time);

        //set role
        $key = self::getRoleKey($id);
        Cache::forget($key);
        Cache::put($key, $user->roles->toArray(), $time);

        return $permissions;
    }

    public static function hasRole($role): bool
    {
        $key = self::getRoleKey();
        $roles = Cache::get($key) ?? [];
        $roles = collect($roles);
        return $roles->where('id', $role)->isNotEmpty();
    }

    public static function hasPermission(string $permission): bool
    {
        $key = self::getPermissionKey();
        $permissions = Cache::get($key) ?? [];
        $permissions = collect($permissions);
        
        return $permissions
            ->filter(function($item) use ($permission)
            {
                return $item['id'] == $permission || $item['name'] == $permission;
            })
            ->isNotEmpty();
    }

    public static function hasAnyPermission(array $permission = []): bool
    {
        $key = self::getPermissionKey();
        $permissions = Cache::get($key) ?? [];
        $permissions = collect($permissions);

        return $permissions
            ->filter(function($item) use ($permission)
            {
                return in_array($item['id'], $permission) || in_array($item['name'], $permission);
            })
            ->isNotEmpty();
    }


}