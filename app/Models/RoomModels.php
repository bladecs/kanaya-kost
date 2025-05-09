<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomModels extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'nama', 
        'price', 
        'lantai', 
        'description', 
        'available', 
        'rating'
    ];

    /**
     * Relasi many-to-many dengan Facility
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            FacilityModel::class, // relasi ke model fasilitas
            'facility_room',      // nama tabel pivot
            'room_id',            // foreign key untuk RoomModels di tabel pivot
            'facility_id'         // foreign key untuk FacilityModel di tabel pivot
        );
    }
}