<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set the user's address.
     *
     * @param  array  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Gets the profile of a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    /**
     * Get all the appointments a doctor got from patients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentsAsDoctor()
    {
        $this->mustBeDoctor();
        return $this->hasMany('App\Appointment', 'doctor_id', 'id');
    }

    /**
     * Get all the appointments a patient have created
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentsAsPatient()
    {
        $this->mustBePatient();
        return $this->hasMany('App\Appointment', 'patient_id', 'id');
    }

    /**
     * Get all the treatments a doctor has provided
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function treatmentsAsDoctor()
    {
        $this->mustBeDoctor();
        return $this->hasMany('App\Treatment', 'doctor_id', 'id');
    }

    /**
     * Get all the treatments a patient have taken
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function treatmentsAsPatient()
    {
        $this->mustBePatient();
        return $this->belongsToMany('App\Treatment', 'patient_id', 'id');
    }


    /**
     * Get the schedule of a doctor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function schedule()
    {
        $this->mustBeDoctor();
        return $this->hasOne('App\DoctorSchedule', 'doctor_id', 'id');
    }

    // Ensures the current instance is a doctor
    private function mustBeDoctor()
    {
        throw_if(!$this->hasRole('doctor'), 'You must be a doctor to access this property');
    }

    // Ensures the current instance is a patient
    private function mustBePatient()
    {
        throw_if(!$this->hasRole('patient'), 'You must be a patient to access this property');
    }
}