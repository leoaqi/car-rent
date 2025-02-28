<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
    //
    protected $fillable = ['image', 'car_id'];

    // Relationship: An image belongs to a car
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
