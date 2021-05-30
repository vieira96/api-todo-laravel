<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->middleware('auth:api')->only([
            'me',
            'logout',
            'refresh',
        ]);
        $this->service = $service;
    }

    public function login(AuthLoginRequest $request)
    {
        try {
            $token = $this->service->login($request);
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage(), [], 401);
        }

        return $this->respondWithToken($token);
    }

    public function verifyEmail(Request $request)
    {
        try {
            $user = $this->service->verifyEmail($request);
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage(), [], 400);
        }

        return $this->responseSuccess($user);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try{
            $this->service->forgotPassword($request);
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage(), [], 400);
        }
        return $this->responseSuccess();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $this->service->resetPassword($request);
        } catch(\Exception $e) {
            return $this->responseError($e->getMessage(), [], 400);
        }
        return $this->responseSuccess();
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->responseSuccess(new UserResource(Auth::user()));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }


    protected function respondWithToken($token)
    {
        $user = Auth::user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
