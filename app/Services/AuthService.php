<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class AuthService
 *
 * @package App\Services
 */
class AuthService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
    * UserService constructor
    *
    * @param UserRepositoryInterface $userRepository
    */
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Register Function
     *
     * @param Array $request
     * @return JsonResponse
     */
    public function register($request)
    {
        $request['password'] = Hash::make($request['password']);
        $user = $this->userRepository->create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = [
            'user' => $user,
            'access_token' => $token,
        ];
    
        return response()->json($response, 200);
    }

    /**
     * Login Function
     *
     * @param Array $request
     * @return JsonResponse
     */
    public function login($request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        
        $user = $this->userRepository->first('email', $request->email);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }
}
