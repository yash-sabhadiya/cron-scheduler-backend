<?php

namespace App\Http\Services;

use App\Http\Interfaces\CronJobInterface;
use App\Models\CronJob;

class CronJobService implements CronJobInterface
{
    private $cronJob;

    public function __construct(CronJob $cronJob)
    {
        $this->cronJob = $cronJob->query();
    }

    public function list()
    {
        return $this->cronJob->get();
    }

    public function store(array $data)
    {
        return $this->cronJob->create($data);
    }

    public function destroy($id)
    {
        return $this->cronJob->where('id',$id)->delete();
    }
}
