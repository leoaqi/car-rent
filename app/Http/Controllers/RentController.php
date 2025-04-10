<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Notifications\RentNotification;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $rents = Rent::with(['car.brand', 'car.category'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return Inertia::render('Cms/Rent/Index', [
            'data' => $rents,
        ]);
    }

    public function rent(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'car_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'town' => 'required',
                'pickup_location' => 'required',
                'pickup_date' => 'required',
                'dropoff_location' => 'required',
                'dropoff_date' => 'required',
                'price' => 'required',
                'type' => 'required',
            ]);

            if ($validate->fails()) {
                Log::error('Rent validation failed', [
                    'errors' => $validate->errors(),
                    'request' => $request->all()
                ]);
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $rent = Rent::create([
                'car_id' => $request->car_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'town' => $request->town,
                'location_pickup' => $request->pickup_location,
                'start_date' => $request->pickup_date,
                'location_delivery' => $request->dropoff_location,
                'end_date' => $request->dropoff_date,
                'price' => $request->price,
                'type' => $request->type,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            if (!$rent) {
                Log::error('Failed to create rent record', [
                    'request' => $request->all()
                ]);
                return redirect()->back()
                    ->with('message', 'Failed to create rent request')
                    ->with('type', 'error');
            }

            Log::info('Rent created successfully', [
                'user' => $request->name,
                'car_id' => $request->car_id,
                'pickup_date' => $request->pickup_date,
                'dropoff_date' => $request->dropoff_date,
                'rent id' => $rent->id,
            ]);

            $message = "New Rent Request:\n" .
                "Name: {$request->name}\n" .
                "Phone: {$request->phone}\n" .
                "Address: {$request->address}\n" .
                "Town: {$request->town}\n" .
                "Pickup Location: {$request->pickup_location}\n" .
                "Pickup Date: {$request->pickup_date}\n" .
                "Dropoff Location: {$request->dropoff_location}\n" .
                "Dropoff Date: {$request->dropoff_date}\n" .
                "Price: Rp " .number_format($request->price, 0, ',', '.') ."\n".
                "Type: {$request->type}\n";

            Notification::route('telegram', env('TELEGRAM_CHAT_ID'))
                ->notify(new RentNotification([
                    'message' => $message,
                    'url' => url("/rent/{$rent->id}")
                ]));

            return redirect()->back()->with('message', 'Rent request submitted successfully')->with('type', 'success');;
        } catch (\Throwable $th) {
            Log::error('Rent creation failed', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()->back()->with('message', 'Something went wrong')->with('type', 'error');;
        }
    }
}
