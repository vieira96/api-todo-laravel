<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $this->service->register($request);
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess();
    }

    public function update(UserRequest $request)
    {
        try {
            $user = new UserResource($this->service->update($request));
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return $this->responseSuccess($user);
    }
}
