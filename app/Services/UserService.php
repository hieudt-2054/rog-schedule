<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService
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
     * Check user exists by id
     *
     * @param  string  $userId
     *
     * @return bool
     */
    public function exists(string $userId)
    {
        return $this->userRepository->exists('id', $userId);
    }
    
    /**
     * Update Or Create User
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->userRepository->updateOrCreate($attributes, $values);
    }

    /**
     * Get All users
     *
     * @return Collection
     */
    public function getAll()
    {
        return $this->userRepository->all();
    }
}
