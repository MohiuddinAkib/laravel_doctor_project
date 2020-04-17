<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function sex()
    {
        return [
            0 => 'male',
            1 => 'female'
        ][$this->sex];
    }

    /**
     * Get all the doctors this category has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo('App\User', 'doctor_id', 'id');
    }

    /**
     * Get all the doctors this category has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id', 'id');
    }
}