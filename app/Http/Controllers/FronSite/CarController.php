<?php

namespace App\Http\Controllers\FronSite;

use App\Models\Car;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['category', 'brand', 'images', 'prices']);

        // Apply brand filter
        if ($request->has('brands') && !empty($request->brands)) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->whereIn('name', $request->brands);
            });
        }

        // Apply category filter
        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('brand', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $cars = $query->get();

        $carsCount = Car::with(['category', 'brand', 'images', 'prices'])
            ->get();

        // Get brand counts from filtered results
        $brandCount = Brand::all()
            ->mapWithKeys(function ($brand) use ($carsCount) {
                $count = $carsCount->where('brand.id', $brand->id)->count();
                return [$brand->name => $count];
            });

        // Get category counts from filtered results
        $categoryCount = Category::all()
            ->mapWithKeys(function ($category) use ($carsCount) {
                $count = $carsCount->where('category.id', $category->id)->count();
                return [$category->name => $count];
            });

        return Inertia::render('FrontSite/Index', [
            'data' => $cars,
            'brandCount' => $brandCount,
            'categoryCount' => $categoryCount,
            'filters' => $request->only(['brands', 'categories', 'search'])
        ]);
    }

    public function detail($id)
    {
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
