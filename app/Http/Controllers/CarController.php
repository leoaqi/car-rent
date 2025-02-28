<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 5);
        $cars = Car::with(['category', 'brand', 'images', 'prices'])
            ->when($request->search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('brand', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->paginate($perPage);

        return Inertia::render('Cms/Car/Index', [
            'data' => $cars,
        ]);
    }
}
