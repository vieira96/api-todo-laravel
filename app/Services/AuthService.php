<?php

namespace App\Services;

use App\Events\ForgotPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{

    public function login($request)
    {
        $input = $request->validated();
        $login = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        if(! $token = Auth::attempt($login)) {
            throw new \Exception('exceptions.login');
        }

        return $token;
    }

    public function verifyEmail($request)
    {
        $user = User::where('confirmation_token', $request->token)->first();
        if(! $user) {
            throw new \Exception('exceptions.token');
        }
        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    public function forgotPassword($request)
    {
        $data = $request->validated();
        $password_reset = PasswordReset::where('email', $data['email'])->first();
        if ($password_reset) {
            throw new \Exception('exceptions.password_reset');
        }
        $token = Str::random(60);
        $data['token'] = $token;
        PasswordReset::create($data);
        $user = User::where('email', $data['email'])->first();
        event(new ForgotPassword($user, $data['token']));
    }

    public function resetPassword($request)
    {
        $token = $request->token;
        $data = $request->validated();
        $password_reset = PasswordReset::where('token', $token)->first();
        if(! $password_reset) {
            throw new \Exception('exceptions.token');
        }
        $user = User::where('email', $password_reset->email)->first();
        $user->password = Hash::make($data['password']);
        $user->save();

        PasswordReset::where('email', $password_reset->email)->delete();
    }

}
