<?php


namespace App\Models\Relations;

use App\Models\Workout;
use App\Models\Xray;

trait HasManyXrays
{
    /**
     * @property $this \Illuminate\Database\Eloquent\Model
     */
    public function xrays()
    {
        return $this->hasMany(Xray::class);
    }

    public function getLatestXrayAttribute()
    {
        return $this->xrays()->latest()->first();
    }
}
