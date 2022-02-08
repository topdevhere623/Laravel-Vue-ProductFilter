<?php


namespace App\Models\Relations;


use App\Models\PricePlan;
use App\Models\User;
use App\Models\Workout;

trait HasManyWorkouts
{
    /**
     * @property $this \Illuminate\Database\Eloquent\Model
     */
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    public function getLatestWorkoutAttribute()
    {
        return $this->workouts()->latest()->first();
    }
}
