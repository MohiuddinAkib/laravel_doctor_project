<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorCategory extends Model
{
    /**
     * Get all the doctors this category has
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doctors()
    {
        return $this->hasMany('App\User', 'category_id', 'id');
    }
}