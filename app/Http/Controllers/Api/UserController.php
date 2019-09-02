<?php

namespace Rspafs\Http\Controllers\Api;

use Illuminate\Http\Response;
use Rspafs\Http\Controllers\Controller;
use Rspafs\Http\Requests\UserLoginRequest;
use Rspafs\Http\Requests\UserRegisterRequest;
use Rspafs\Contracts\Repositories\UserRepositoryContract;
use Rspafs\Contracts\Services\UserServiceContract;

class UserController extends Controller
{
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryContract $user)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->user = $user;
    }

    /**
     * Rewrite login function in AuthenticatesUsers class for username or password login.
     *
     * @param UserLoginRequest $request
     * @param UserServiceContract $userService
     * @return void
     */
    public function login(UserLoginRequest $request, UserServiceContract $userService)
    {
        $userService->checkLogin($request->username, $request->password);
        
        if ($user = $request->user()) {
            return response()->json([
                'access_token' => $user->createToken('Personal Access Token')->accessToken,
                'token_type' => 'bearer'
            ]);
        } else {
            return response()->json([
                'errors' => trans('auth.failed')
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Register using api
     *
     * @param UserRegisterRequest $request
     * @return void
     */
    public function register(UserRegisterRequest $request)
    {
        $user = $this->user->createUser($request->all());
        
        return response()->json([
            'access_token' => $user->createToken('Personal Access Token')->accessToken,
            'token_type' => 'bearer'
        ], Response::HTTP_CREATED);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(auth()->guard('api')->check()) {
            auth()->user()->token()->revoke();
            auth()->guard('api')->user()->token()->delete();
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user()
    {
        return response()->json(auth()->user());
    }
}
