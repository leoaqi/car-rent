<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    //
    use HasFactory;

    protected $guarded = [];

    protected $table = 'cars';

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function images(){
        return $this->hasMany(CarImage::class);
    }

    public function prices(){
        return $this->hasMany(Price::class);
    }

    public function saveImages(array $images): void
    {
        foreach ($images as $image) {
            $this->images()->create([
                'car_id' => $this->id,
                'image' => $image,
            ]);
        }
    }
}
