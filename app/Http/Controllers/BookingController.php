<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index(Request $request){

        $perPage = $request->input('per_page', 5);
        $search = $request->input('search');
        $paymentStatus = $request->input('payment_status');
        $bookingStatus = $request->input('booking_status');
        
        $query = Booking::with(['tourPackage']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%{$search}%")
                ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($paymentStatus || $bookingStatus) {
            $query->where(function($q) use ($paymentStatus, $bookingStatus) {
                if ($paymentStatus && $bookingStatus) {
                    $q->where('payment_status', $paymentStatus)
                      ->where('booking_status', $bookingStatus);
                } elseif ($paymentStatus) {
                    $q->where('payment_status', $paymentStatus);
                } elseif ($bookingStatus) {
                    $q->where('booking_status', $bookingStatus);
                }
            });
        }

        $data = $query
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        return Inertia::render('Cms/TourBooking/Index', [
            'data' => $data
        ]);
    }

    public function edit($id){
        $data = Booking::with(['tourPackage', 'tourPackage.destinationList'])
            ->findOrFail($id);

        Log::info('Data edit', [
            'data'=> $data
        ]);

        return Inertia::render('Cms/TourBooking/FormBooking', [
            'data' => $data
        ]);
    }
}
