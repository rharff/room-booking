<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingStatusUpdatedNotification;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'approved']);

        // Notify user
        Notification::send($booking->user, new BookingStatusUpdatedNotification($booking));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking approved successfully.');
    }

    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'rejected']);

        // Notify user
        Notification::send($booking->user, new BookingStatusUpdatedNotification($booking));

        return redirect()->route('admin.bookings.index')->with('success', 'Booking rejected successfully.');
    }
}
