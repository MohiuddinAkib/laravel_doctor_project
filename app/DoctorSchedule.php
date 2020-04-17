<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    /**
     * Gets the doctor of a schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo('App\User', 'id', 'doctor');
    }
}