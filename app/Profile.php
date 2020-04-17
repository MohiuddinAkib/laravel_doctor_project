<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    /**
     * Set the user's address.
     *
     * @param  array  $value
     * @return void
     */
    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = json_encode($value);
    }


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'address' => 'array',
    ];

    /**
     * Gets the user of a profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Gets the category of a doctor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctorCategory()
    {
        // $this->mustBeDoctor();
        return $this->belongsTo('App\DoctorCategory', 'category_id', 'id');
    }

    // Ensures the current instance is a doctor
    private function mustBeDoctor()
    {
        throw_if(!$this->user->hasRole('doctor'), 'You must be a doctor to access this property');
    }
}