<?php


namespace App\Models\Relations;


use App\Models\Interval;
use App\Models\PricePlan;
use App\Models\User;

trait HasManyIntervals
{
    /**
     * @property $this \Illuminate\Database\Eloquent\Model
     */
    public function intervals()
    {
        return $this->hasMany(Interval::class);
    }

    public function getLatestIntervalAttribute()
    {
        return $this->intervals()->latest()->first();
    }
}
