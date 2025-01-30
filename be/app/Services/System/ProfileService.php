<?php

namespace App\Services\System;

use App\Helpers\Authorization;
use App\Models\Module\PasienPemeriksaanModel;
use App\Models\User;
use App\Repository\System\LogUserRepository;
use App\Repository\UAM\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileService extends BaseService
{

    public function validedToken()
    {
        $user = Auth::user();
        return [
            'user'  => [
                'id'            => $user->id,
                'username'      => $user->username,
                'name'          => $user->name,
                'email'         => $user->email,
                'avatar_url'    => $user->avatar_url,
            ],
            'token' => [
                'access_token' => Auth::refresh(),
                'expires_in'   => Auth::factory()->getTTL() * 60,
            ],
        ];
    }

    public function getAccess()
    {
        return Authorization::getUserAkses(Auth::id());
    }

    public function updateProfile($data)
    {
        if (isset($data['avatar']) && $data['avatar']->isValid()) {
            $fileName = Auth::user()->username . "." . $data['avatar']->extension();
            $data['avatar_path'] = $data['avatar']->storeAs('avatar', $fileName);
        }

        if (Auth::user()->avatar_path) Storage::delete(Auth::user()->avatar_path);
        $res = (new UserRepository)->update(Auth::id(), $data);
        return $res;
    }

    public function getProfile()
    {
        $user = User::with(['roles'])->find(Auth::id());
        $pemeriksaan = PasienPemeriksaanModel::where('user_id', Auth::id())->get();
        $pasien = $pemeriksaan->groupBy('pasien_id')->count();
        return [
            'id'            => $user->id,
            'username'      => $user->username,
            'name'          => $user->name,
            'email'         => $user->email,
            'avatar_url'    => $user->avatar_url,
            'no_telp'       => $user->no_telp,
            'alamat'        => $user->alamat,
            'is_active'     => $user->is_active,
            'roles'         => $user->roles,
            'pemeriksaan_total' => $pemeriksaan->count(),
            'pasien_total'      => $pasien
        ];
    }

    public function getLogs()
    {
        return (new LogUserRepository())
            ->filterByUserId(Auth::id())
            ->orderDesc()
            ->getQuery()
            ->select(['id', 'description', 'method', 'server_time', 'status'])
            ->limit(25)
            ->get()
            ->map(function ($d) {
                $d['server_time_diff'] = $d->server_time->diffForHumans();
                return $d;
            });
    }
}
