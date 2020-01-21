<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        return $this->authService->register($request);
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
}
