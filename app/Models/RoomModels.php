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
        'tenant',
        'available',
        'rating'
    ];

    /**
     * Relasi many-to-many dengan Facility
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            FacilityModel::class,
            'facility_room',
            'room_id',
            'facility_id'
        );
    }
    public function payment(){
        return $this->belongsTo(PaymentModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'tenant');
    }
}
