<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function destinations(){
        return $this->hasMany(PackageDestination::class, 'package_id');
    }

    public function destinationList(){
        return $this->belongsToMany(Destination::class, 'package_destinations', 'package_id', 'destination_id');
    }

    public function images(){
        return $this->hasMany(PackageImage::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
