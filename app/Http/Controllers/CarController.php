<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {

        $perPage = $request->input('per_page', 5);
        $cars = Car::with(['category', 'brand', 'images', 'prices'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->paginate($perPage);

        return Inertia::render('Cms/Car/Index', [
            'data' => $cars,
        ]);
    }

    public function delete($id)
    {
        try {
            $car = Car::with('images')->findOrFail($id);

            foreach ($car->images as $image) {
                if (Storage::exists($image->image)) {
                    Storage::delete($image->image);
                }
            }
            $car->delete();
            return redirect()->back()->with('success', 'Car deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function add()
    {
        return Inertia::render('Cms/Car/AddCar', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'cc' => 'required',
            'year' => 'required',
            'capacity' => 'required',
            'brand_id' => 'required',
            'images' => 'required|array',
            'prices' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $car = Car::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'cc' => $request->cc,
            'year' => $request->year,
            'capacity' => $request->capacity,
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 1000) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('car', $imageName, 'public');
                $car->images()->create([
                    'image' => $path,
                    'car_id' => $car->id
                ]);
            }
        }

        if ($request->has('prices')) {
            foreach ($request->prices as $price) {
                $car->prices()->create([
                    'price' => $price['amount'],
                    'car_id' => $car->id,
                    'type' => $price['type']['value'],
                    'is_active' => true
                ]);
            }
        }
    }
}
