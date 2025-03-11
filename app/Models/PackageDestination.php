<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageDestination extends Model
{
    //
    protected $table = 'package_destinations';

    protected $fillable = [
        'package_id',
        'destination_id'
    ];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

}
