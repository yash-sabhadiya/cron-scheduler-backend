<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CronJobInterface;
use App\Http\Requests\CronJobRequest;

class CronJobController extends Controller
{
    protected $cronJobService;

    public function __construct(CronJobInterface $cronJobService)
    {
        $this->cronJobService = $cronJobService;
    }

    public function index()
    {
        return $this->sendResp(
            "Cron Job List",
            $this->cronJobService->list()
        );
    }

    public function store(CronJobRequest $request)
    {
        return $this->sendResp(
            "Cron Schedule Successfully",
            $this->cronJobService->store(
                $request->only(['url','interval'])
            )
        );
    }

    public function destroy($id)
    {
        $this->cronJobService->destroy($id);

        return $this->sendResp("Cron Deleted Successfully");
    }
}
