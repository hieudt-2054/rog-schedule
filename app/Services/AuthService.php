<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
            $request['password'] = Hash::make($request['password']);
            $user = $this->userRepository->create($request);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = [
                'user' => $user,
                'access_token' => $token,
            ];
            DB::commit();
            
            return $response;
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);

            return $ex;
        }
    }

    /**
     * Login Function
     *
     * @param Array $request
     * @return JsonResponse
     */
    public function login($request)
    {
        try {
            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => trans('errors.401'),
                ], 401);
            }
            $user = $this->userRepository->first('email', $request->get('email'));
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            return [
                'user' => $user,
                'access_token' => $token,
            ];
        } catch (\Exception $ex) {
            report($ex);

            return false;
        }
    }
}
