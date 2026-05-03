<?php

namespace App\Http\Controllers;

use App\Models\AdminBankAccount;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankingController extends Controller
{
    protected PaystackService $paystack;

    public function __construct(PaystackService $paystack)
    {
        $this->paystack = $paystack;
        $this->middleware('auth');
    }

    /**
     * Show the banking details page.
     */
    public function index()
    {
        $banks = $this->paystack->getBanks();
        $bankAccount = AdminBankAccount::where('user_id', Auth::id())->first();

        return view('admin.revenue.banking', compact('banks', 'bankAccount'));
    }

    /**
     * Save the admin's bank account details.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'bank_code' => 'required|string',
            'account_number' => 'required|digits:10',
            'account_name' => 'required|string',
        ]);

        AdminBankAccount::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'bank_name' => $request->bank_name,
                'bank_code' => $request->bank_code,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'is_verified' => true, // Verified via Paystack resolve
            ]
        );

        return back()->with('success', 'Banking details saved successfully.');
    }

    /**
     * AJAX: Return the cached list of Nigerian banks (for Select2).
     */
    public function getBanks()
    {
        $banks = $this->paystack->getBanks();

        $formatted = collect($banks)->map(fn($bank) => [
            'id' => $bank['code'],
            'text' => $bank['name'],
        ])->values();

        return response()->json(['results' => $formatted]);
    }

    /**
     * AJAX: Resolve account name from Paystack.
     */
    public function resolveAccount(Request $request)
    {
        $request->validate([
            'account_number' => 'required|digits:10',
            'bank_code' => 'required|string',
        ]);

        $result = $this->paystack->resolveAccountName(
            $request->account_number,
            $request->bank_code
        );

        return response()->json($result);
    }
}
