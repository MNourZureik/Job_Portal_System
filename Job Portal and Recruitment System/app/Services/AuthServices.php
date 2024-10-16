<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Random\RandomException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServices
{
    public function store(Request $request)
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

    /**
     * @throws RandomException
     */
    public function sendVerificationCode($email): void
    {
        $verificationCode = random_int(100000, 999999);
        $user = User::where('email', $email)->get()->first();
        $user->verification_code = Crypt::encrypt($verificationCode);
        $user->save();
        SendEmailJob::dispatch($email , $verificationCode);
    }

    public function checkVerificationCode($verificationCode): bool
    {
        $code = User::where('id' , JWTAuth::user()->id)->get()->first();
        $decrypted = Crypt::decrypt($code->verification_code);
        return $decrypted == $verificationCode;
    }

    public function handleCallBack($googleUser)
    {
        $existingUser = User::where('email', $googleUser->getEmail())->get()->first();
        return $existingUser ?: User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
        ]);

    }
}
