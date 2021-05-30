<?php

namespace App\Services;

use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService {

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }


    public function register($request)
    {
        $input = $request->only([
            'first_name',
            'last_name',
            'email',
            'password',
        ]);

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'confirmation_token' => Str::random(60),
        ]);

        event(new UserRegistered($user));

        return $user;
    }

    public function update($request)
    {
        $data = $request->only([
            'first_name',
            'last_name',
            'password',
        ]);

        $user = User::where('id', $this->user->id)->first();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];

        if(! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        return $user;
    }
}
