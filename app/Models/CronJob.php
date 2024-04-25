<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CronJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getIntervalAttribute($value)
    {
        $interval = collect(config('scheduler.interval_options'))->where('value',$value)->first();

        return $interval['text'];
    }
}
