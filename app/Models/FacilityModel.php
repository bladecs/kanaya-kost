<?php

// app/Models/Facility.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FacilityModel extends Model
{
    protected $table = 'facilities';
    protected $fillable = ['name', 'slug'];

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(RoomModels::class, 'facility_room');
    }
}
