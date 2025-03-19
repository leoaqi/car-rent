<?php

namespace App\Http\Controllers\FronSite;

use App\Models\Car;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    public function index(){
        $cars = Car::with(['category', 'brand', 'images', 'prices'])
            ->get();
        Log::info('Cars', [
            'cars' => $cars
        ]);
        return Inertia::render('FrontSite/Index', [
            'data' => $cars
        ]);
    }

    public function detail($id){
        try {
            $car = Car::with(['category', 'brand', 'images', 'prices'])
                ->findOrFail($id);

            return Inertia::render('FrontSite/Detail', [
                'data' => $car
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Car not found', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return Inertia::render('FrontSite/NotFound', [
                'status' => 404,
                'message' => 'Car not found'
            ]);
        }
    }
}
