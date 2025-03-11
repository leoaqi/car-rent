<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            return redirect()->back()->with('message', 'Car deleted successfully')->with('type', 'success');;
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'Something went wrong')->with('type', 'error');;
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
            'images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
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

    public function edit($id)
    {
        $car = Car::with(['category', 'brand', 'images', 'prices'])
            ->findOrFail($id);
        return Inertia::render('Cms/Car/AddCar', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'car' => $car,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            // Basic validation for required fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required',
                'cc' => 'required',
                'year' => 'required',
                'capacity' => 'required',
                'brand_id' => 'required',
                // Don't validate prices and images as arrays in the initial validation
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Validate new_images separately
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    if (
                        !in_array($image->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg']) ||
                        $image->getSize() > 2048000
                    ) {
                        return redirect()->back()
                            ->withErrors(['new_images' => 'Invalid image file format or size'])
                            ->withInput();
                    }
                }
            }

            // Get the car record
            $car = Car::with('images')->findOrFail($id);

            // Handle existing images
            $keepImageIds = [];
            if ($request->has('images')) {
                // This might be a JSON string or already an array
                $imagesInput = $request->input('images');
                if (is_string($imagesInput)) {
                    // Try to decode if it's a JSON string
                    $keepImageIds = json_decode($imagesInput, true) ?: [];
                } else if (is_array($imagesInput)) {
                    $keepImageIds = $imagesInput;
                }
            }

            // Delete images not in the keep list
            foreach ($car->images as $image) {
                if (!in_array($image->id, $keepImageIds)) {
                    if (Storage::exists('public/' . $image->image)) {
                        Storage::delete('public/' . $image->image);
                    }
                    $image->delete();
                }
            }

            // Update car basic info
            $car->update([
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'cc' => $request->cc,
                'year' => $request->year,
                'capacity' => $request->capacity,
            ]);

            // Add new images
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $imageName = time() . rand(1, 1000) . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('car', $imageName, 'public');
                    $car->images()->create([
                        'image' => $path,
                        'car_id' => $car->id
                    ]);
                }
            }

            // Process prices
            if ($request->has('prices')) {
                $car->prices()->delete(); // Delete existing prices

                // Prices might be a JSON string or already an array
                $pricesInput = $request->input('prices');
                $prices = [];

                if (is_string($pricesInput)) {
                    // Try to decode if it's a JSON string
                    $prices = json_decode($pricesInput, true) ?: [];
                    if (!is_array($prices)) {
                        $prices = [$prices]; // If it's a scalar value, make it an array
                    }
                } else if (is_array($pricesInput)) {
                    $prices = $pricesInput;
                }

                // Handle single price or array of prices
                $prices = isset($prices[0]) ? $prices : [$prices];

                foreach ($prices as $price) {
                    // Handle the nested structure we see in the debug output
                    $type = isset($price['type']) && isset($price['type']['value']) ?
                        $price['type']['value'] : (isset($price['type']) ? $price['type'] : 'unknown');

                    $amount = isset($price['amount']) ? $price['amount'] : 0;

                    $car->prices()->create([
                        'price' => $amount,
                        'car_id' => $car->id,
                        'type' => $type,
                        'is_active' => true
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Car updated successfully');
        } catch (\Throwable $th) {
            Log::error('Car update error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update car: ' . $th->getMessage())
                ->withInput();
        }
    }
}
