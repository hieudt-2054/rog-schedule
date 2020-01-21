<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;

class AuthController extends Controller
{
    /**
     * @var SocialAccountService
     */
    private $userRepo;

    /**
     * @param socialAccountService
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function dumpData()
    {
        return response()->json($this->userRepo->all());
    }
}
