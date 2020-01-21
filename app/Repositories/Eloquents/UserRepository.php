<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\DatabaseManager;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * Class UserRepository
 *
 * @package App\Repositories\Eloquents
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     * @param DatabaseManager $db
     */
    public function __construct(User $model, DatabaseManager $db)
    {
        parent::__construct($model);

        $this->db = $db;
    }
}
