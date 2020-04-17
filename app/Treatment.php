<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $guarded = [];

    public function doctor()
    {
        return $this->belongsTo('App\User', 'id', 'doctor');
    }

    /**
     * Get all the treatments a patient have taken
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne('App\User', 'id', 'patient');
    }
}