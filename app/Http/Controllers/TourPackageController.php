<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TourPackageController extends Controller
{
    public function index(Request $request){
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search');
        $query = TourPackage::with(['destinationList', 'destinationList.images']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        $tourPackages = $query->paginate($perPage);

        return Inertia::render('Cms/TourPackage/Index', [
            'data' => $tourPackages,
        ]);
    }

    public function add(){
        $destination = Destination::all();
        return Inertia::render('Cms/TourPackage/AddTour', [
            'destination' => $destination]);
    }

    public function store(Request $request){
        try {
            Log::info('Request data:', $request->all());
            
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'duration' => 'required|numeric',
                'facilities' => 'nullable|array',
                'destinations' => 'required|array'
            ]);
    
            $tourData = [
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'duration_days' => $request->duration,
                'facilities' => json_encode($request->facilities),
                'type'=> 'mixed',
                'status'=> $request->status
            ];
            
            Log::info('Tour data to insert:', $tourData);
            
            $tour = TourPackage::create($tourData);
            
            Log::info('Created tour:', $tour->toArray());

            if ($request->has('destinations')) {
                foreach ($request->destinations as $destination) {
                    Log::info('Processing destination:', $destination['destination_id']);
                    $destinationData = [
                        'destination_id' => $destination['destination_id']['id'],
                        'package_id' => $tour->id,
                    ];
                    Log::info('Creating destination:', $destinationData);
                    $tour->destinations()->create($destinationData);
                }
            }

            return redirect()->back()->with('success', 'Tour package created successfully');
        } catch (\Throwable $th) {
            Log::error('Error creating tour package: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());
            throw $th; // This will help see the error in development
        }
    }

    public function delete($id)
    {
        try {
            $destination = TourPackage::with('destinations')->findOrFail($id);
            $destination->delete();
            return redirect()->back()->with('success', 'Car deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $data = TourPackage::with('destinations', 'destinationList')
            ->findOrFail($id);
            $destination = Destination::all();
        return Inertia::render('Cms/TourPackage/AddTour', [
            'data' => $data,
            'destination' => $destination
        ]);
    }

    public function update(Request $request, $id){
        try {
            $request->validate([
                'name' =>'required|string',
                'description' =>'required|string',
                'price' =>'required|numeric',
                'duration' =>'required|numeric',
                'facilities' => 'nullable|array',
                'destinations' =>'required|array'
            ]);

            $tourData = [
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'duration_days' => $request->duration,
                'facilities' => json_encode($request->facilities),
                'type'=>'mixed',
               'status'=> $request->status
            ];
            $tour = TourPackage::findOrFail($id);
            $tour->update($tourData);
            if ($request->has('destinations')) {
                $tour->destinations()->delete();
                foreach ($request->destinations as $destination) {
                    $destinationData = [
                        'destination_id' => $destination['destination_id']['id'],
                        'package_id' => $tour->id,
                    ];
                    $tour->destinations()->create($destinationData);
                }
            }
            return redirect()->back()->with('success', 'Tour package updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
