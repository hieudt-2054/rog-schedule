<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use Socialite;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @param AuthService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

     /**
     * Store a newly created resource in stor\Illuminate\Http\Responseage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return @return JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        return $this->authService->register($request->all());
    }

    /**
     * Login Request Function
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        return $this->authService->login($request);
    }

    /**
     * Revoke the access token from the authenticated user.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        return response()->json(['success' => $request->user()->token()->revoke()]);
    }

    public function socialLogin($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        return $this->authService->handleSocialAuth($user);
    }
}
