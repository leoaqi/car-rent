<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $destinations = Destination::with(['images'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return Inertia::render('Cms/Destination/Index', [
            'data' => $destinations,
        ]);
    }

    public function add()
    {
        return Inertia::render('Cms/Destination/AddDestination');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'region' => 'required',
                'images' => 'nullable|array',
                'new_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $destination = Destination::create([
                'name' => $request->name,
                'description' => $request->description,
                'region' => $request->region,
            ]);
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $imageName = time() . rand(1, 1000) . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('destination', $imageName, 'public');
                    $destination->images()->create([
                        'image_path' => $path,
                        'alt_text' => $imageName,
                        'destination_id' => $destination->id,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $destination = Destination::with('images')->findOrFail($id);
            foreach ($destination->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            $destination->delete();
            return redirect()->back()->with('success', 'Car deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $destination = Destination::with('images')
            ->findOrFail($id);
        return Inertia::render('Cms/Destination/AddDestination', [
            'destination' => $destination,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            // Basic validation for required fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'region' => 'required',
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
            $destination = Destination::with('images')->findOrFail($id);

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
            foreach ($destination->images as $image) {
                if (!in_array($image->id, $keepImageIds)) {
                    if (Storage::exists('public/' . $image->image)) {
                        Storage::delete('public/' . $image->image);
                    }
                    $image->delete();
                }
            }

            // Update destination basic info
            $destination->update([
                'name' => $request->name,
                'description' => $request->description,
                'region' => $request->region,
                'description' => $request->description
            ]);

            // Add new images
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $imageName = time() . rand(1, 1000) . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('destination', $imageName, 'public');
                    $destination->images()->create([
                        'image_path' => $path,
                        'destination_id' => $destination->id
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Car updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to update car: ' . $th->getMessage())
                ->withInput();
        }
    }
}
