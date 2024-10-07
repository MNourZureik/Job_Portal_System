<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthServices
{
    public function StoreUser(Request $request)
    {
        $request->validate(User::rules(is_register: true));
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());
        $user->assignRole($user['role']);
        return $user;
    }

    public function login(Request $request): array
    {
        return $request->validate(User::rules());
    }

    public function listUsers($role)
    {
        return User::where('role', $role)->get()->all();
    }
}
