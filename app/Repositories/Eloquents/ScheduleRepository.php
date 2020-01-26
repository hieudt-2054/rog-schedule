<?php

namespace App\Repositories\Eloquents;

use App\Models\Schedule;
use App\Repositories\BaseRepository;
use Illuminate\Database\DatabaseManager;
use App\Repositories\Contracts\ScheduleRepositoryInterface;

/**
 * Class ScheduleRepository
 *
 * @package App\Repositories\Eloquents
 */
class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    /**
     * @var Schedule
     */
    protected $model;

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * ScheduleRepository constructor.
     *
     * @param Schedule $model
     * @param DatabaseManager $db
     */
    public function __construct(Schedule $model, DatabaseManager $db)
    {
        parent::__construct($model);

        $this->db = $db;
    }
}
