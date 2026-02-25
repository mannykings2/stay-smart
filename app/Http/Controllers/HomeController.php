<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bookings = Booking::latest()->get();
        $my_bookings = Booking::where('user_id', auth()->id())->latest()->get();
        $properties = Property::latest()->get();
        $trending_properties = Property::whereIn('status', ['Available', 'Booked', 'Under Maintenance'])->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(20)
            ->get();

        $users = User::count();

        $to_clean = [];
        $cleaned_today = 0;
        $reported_issues = 0;

        $admin_revenue = 0;
        $admin_upcoming_checkins = 0;
        $admin_total_bookings = 0;
        $admin_recent_bookings = [];
        $admin_bookings = [];

        if (auth()->user()->hasRole('Cleaner')) {
            $adminIds = auth()->user()->managingAdmins()->pluck('users.id');

            $to_clean = Property::where('status', 'Under Maintenance')
                ->whereIn('user_id', $adminIds)
                ->get();

            $cleaned_today = Property::where('last_cleaned_by', auth()->id())
                ->whereDate('last_cleaned_at', now()->today())
                ->whereIn('user_id', $adminIds)
                ->count();

            $reported_issues = SupportTicket::where('user_id', auth()->id())->count();
        } elseif (auth()->user()->hasRole('Admin')) {
            $adminProperties = Property::where('user_id', auth()->id())->pluck('id');
            $admin_revenue = Booking::whereIn('property_id', $adminProperties)
                ->where('status', 'Confirmed')
                ->sum('total_price');
            $admin_upcoming_checkins = Booking::whereIn('property_id', $adminProperties)
                ->where('status', 'Confirmed')
                ->whereNotExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('digital_check_ins')
                        ->whereColumn('digital_check_ins.booking_id', 'bookings.id');
                })
                ->count();
            $admin_total_bookings = Booking::whereIn('property_id', $adminProperties)->count();
            $admin_recent_bookings = Booking::whereIn('property_id', $adminProperties)
                ->with(['user', 'property'])
                ->latest()
                ->take(5)
                ->get();
            $admin_bookings = Booking::whereIn('property_id', $adminProperties)
                ->with(['user', 'property'])
                ->latest()
                ->get();
        }

        return view('dashboard', compact('bookings', 'my_bookings', 'properties', 'users', 'trending_properties', 'to_clean', 'cleaned_today', 'reported_issues', 'admin_revenue', 'admin_upcoming_checkins', 'admin_total_bookings', 'admin_recent_bookings', 'admin_bookings'));
    }
}
