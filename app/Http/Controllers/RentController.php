<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Inertia\Inertia;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $rents = Rent::with(['car.brand', 'car.category'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return Inertia::render('Cms/Rent/Index', [
            'data' => $rents,
        ]);
    }
}
