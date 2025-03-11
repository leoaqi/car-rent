<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function packageDestinations(){
        return $this->hasMany(PackageDestination::class);
    }

    public function images(){
        return $this->hasMany(DestinationImage::class, 'destination_id', 'id');
    }
}
