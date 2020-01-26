<?php

namespace App\Services;

use DB;
use App\Repositories\Contracts\ScheduleRepositoryInterface;

/**
 * Class ScheduleService
 *
 * @package App\Services
 */
class ScheduleService
{
    /**
     * @var ScheduleRepositoryInterface
     */
    private $scheduleRepository;

    /**
    * ScheduleService constructor
    *
    * @param ScheduleRepositoryInterface $scheduleRepository
    */
    public function __construct(
        ScheduleRepositoryInterface $scheduleRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Create a schedule
     *
     * @param array $input
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function store($input)
    {
        DB::beginTransaction();
        try {
            $input['user_id'] = auth()->user()->id;
            $schedule = $this->scheduleRepository->create($input);
            DB::commit();

            return $schedule;
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);

            return false;
        }
    }

     /**
     * Update a schedule
     *
     * @param array $input
     * @param Schedule $schedule
     *
     * @return bool
     */
    public function update($input, $schedule)
    {
        DB::beginTransaction();

        try {
            $schedule = $this->scheduleRepository->update($schedule, $input);
            DB::commit();

            return $schedule;
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);

            return false;
        }
    }

    /**
     * Delete a schedule
     *
     * @param int $id
     *
     * @return int|bool
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->scheduleRepository->destroy($id);
            DB::commit();

            return $result;
        } catch (\Exception $ex) {
            DB::rollBack();
            report($ex);

            return false;
        }
    }

    /**
     * Get a schedule
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $schedule = $this->scheduleRepository->findOrFail($id);

        return $schedule;
    }
}
