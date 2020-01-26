<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\ScheduleService;

class ScheduleController extends Controller
{
    /**
     * @var ScheduleService
     */
    private $scheduleService;

    /**
     * @param ScheduleService
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = $this->scheduleService->store($request->all());

        return response()->json($schedule);
    }

    /**
     * Display the specified resource.
     *
     * @param  Schedule  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        if ($schedule->user_id === auth()->user()->id) {
            $schedule = $this->scheduleService->show($schedule->id);
        } else {
            $schedule = [];
            $schedule['message'] = 'Failed Permission';
        }

        return response()->json($schedule);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Schedule $schedule
     *
     * @return JsonResponse
     */
    public function update(Request $request, Schedule $schedule)
    {
        if ($schedule->user_id === auth()->user()->id) {
            $schedule = $this->scheduleService->update($request->all(), $schedule);
        } else {
            $schedule = [];
            $schedule['message'] = 'Failed Permission';
        }

        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        if ($schedule->user_id === auth()->user()->id) {
            $response = $this->scheduleService->delete($schedule->id);
        } else {
            $response = [];
        }

        return response()->json(['success' => $response ? true : false]);
    }
}
