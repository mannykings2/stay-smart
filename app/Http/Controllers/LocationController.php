<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Property::select('city')
            ->where('city', 'like', "%{$query}%")
            ->distinct()
            ->pluck('city')
            ->toArray();

        return response()->json(array_values($results));
    }
}
