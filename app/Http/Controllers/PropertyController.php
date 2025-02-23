<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $trending_properties = Property::where('status', 'Available')->withCount('bookings')
                        ->orderBy('bookings_count', 'desc')
                        ->take(20)
                        ->get();

        return view('apartments.index', compact('trending_properties'));
    }

    public function checkIn()
    {

        return view('apartments.check-in' );
    }
}
