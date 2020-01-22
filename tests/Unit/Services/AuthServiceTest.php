<?php

namespace Tests\Unit\Services;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse as Json;
use App\Services\UserService;
use App\Services\AuthService;
use App\Http\Controllers\AuthController;
use App\Http\Requests\UserLoginRequest;
use App\Repositories\Contracts\UserRepositoryInterface;

class AuthServiceTest extends TestCase
{
    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockUserRepository =  m::mock(UserRepositoryInterface::class)->makePartial();
        $this->authService = new AuthService($this->mockUserRepository);
    }

    /**
     * Test register a new user success
     *
     * @test
     *
     * @return void
     */
    public function user_can_register()
    {
        $input = [
            'name' => 'abc',
            'email' => 'abc@gmail.com',
            'password' => '123456',
        ];

        $userTest = factory(User::class)->create($input);
        $this->mockUserRepository->shouldReceive('create')->with($input)->andReturn($userTest);
        $this->assertInstanceOf(User::class, $userTest);
    }

    /**
     * Test register a new user success
     *
     * @test
     *
     * @return void
     */
    public function user_can_not_login()
    {
        $request = new UserLoginRequest([], [], ['email' => 'random@email.com', 'password' => '123456']);
        $response = $this->authService->login($request);
        $this->assertInstanceOf(Json::class, $response);
        $arrayResponse = (array) json_decode($response->content());
        $this->assertArrayHasKey('message', $arrayResponse);
    }
}