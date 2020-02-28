<?php

namespace App\Services;

use App\Models\User;
use App\Events\UserLogin;
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
            event(new UserLogin($user));

            return [
                'user' => $user,
                'access_token' => $token,
            ];
        } catch (\Exception $ex) {
            report($ex);

            return false;
        }
    }

    public function exists($conditional)
    {
        $user = $this->userRepository->findOne($conditional);

        return $user ? true : false;
    }

    public function handleSocialAuth($data)
    {
        DB::beginTransaction();
        try {
            $user = $this->exists(['email' => $data->user['email']]);
            if (!$user) {
                $user = $this->userRepository->create([
                    'name' => $data->user['name'],
                    'email' => $data->user['email'],
                    'password' => bcrypt($data->user['id']),
                ]);
            } else {
                $user = $this->userRepository->first('email', $data->user['email']);
            }
            $google2faUrl = $this->getGoogle2FAUrl($user);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            DB::commit();
            event(new UserLogin($user));

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'google2fa_url' => $google2faUrl,
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);

            return false;
        }
    }

    private function getGoogle2FAUrl(User $user)
    {
        $google2faUrl = '';
        if ($user->passwordSecurity != null) {
            $google2fa = app('pragmarx.google2fa');
            $google2faUrl = $google2fa->getQRCodeUrl(
                'ROGCOMPANY',
                $user->email,
                $user->passwordSecurity->google2fa_secret
            );
        }
        
        return $google2faUrl;
    }
}
