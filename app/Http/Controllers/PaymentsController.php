<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $payments = Payment::whereHas('booking.property', function ($q) {
                $q->where('user_id', auth()->id());
            })->get();
        } else {
            $payments = Payment::where('user_id', auth()->id())->get();
        }

        return view('payments.index', compact('payments'));
    }

    public function form()
    {

        return view('payments.form');
    }
}
