<?php


namespace App\Models\Relations;


use App\Models\Patient;
use App\Models\User;

trait HasOnePatient
{
    /**
     * @property $this \Illuminate\Database\Eloquent\Model
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
