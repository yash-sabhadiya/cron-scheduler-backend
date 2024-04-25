<?php

namespace App\Http\Interfaces;

interface CronJobInterface
{
    public function list();

    public function store(array $data);

    public function destroy($id);
}
