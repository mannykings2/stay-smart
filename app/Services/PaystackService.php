<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected $secretKey;
    protected $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret') ?? env('PAYSTACK_SECRET');
    }

    /**
     * Initialize a transaction.
     */
    public function initializeTransaction(array $data)
    {
        try {
            if (!$this->secretKey) {
                Log::error('Paystack secret not configured.');
                return ['status' => false, 'message' => 'Payment provider not configured.'];
            }

            $response = Http::withToken($this->secretKey)
                ->withoutVerifying()
                ->post($this->baseUrl . '/transaction/initialize', $data);

            if (!$response->ok()) {
                Log::error('Paystack initialize failed', ['response' => $response->body()]);
                return ['status' => false, 'message' => 'Failed to initialize payment.'];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception while initializing Paystack', ['message' => $e->getMessage()]);
            return ['status' => false, 'message' => 'An error occurred during payment initialization.'];
        }
    }

    /**
     * Verify a transaction.
     */
    public function verifyTransaction($reference)
    {
        try {
            if (!$this->secretKey) {
                Log::error('Paystack secret not configured.');
                return ['status' => false, 'message' => 'Payment provider not configured.'];
            }

            $response = Http::withToken($this->secretKey)
                ->withoutVerifying()
                ->get($this->baseUrl . '/transaction/verify/' . $reference);

            if (!$response->ok()) {
                Log::error('Paystack verify request failed', ['response' => $response->body()]);
                return ['status' => false, 'message' => 'Failed to verify payment.'];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception while verifying Paystack', ['message' => $e->getMessage()]);
            return ['status' => false, 'message' => 'An error occurred during payment verification.'];
        }
    }
    /**
     * Get list of Nigerian banks from Paystack.
     * Cached for 24 hours to avoid repeated API hits.
     */
    public function getBanks(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('paystack_banks', 86400, function () {
            try {
                $response = Http::withToken($this->secretKey)
                    ->withoutVerifying()
                    ->get($this->baseUrl . '/bank', ['country' => 'nigeria', 'perPage' => 200]);

                if ($response->successful()) {
                    return $response->json('data') ?? [];
                }
            } catch (\Exception $e) {
                Log::error('Paystack getBanks failed', ['message' => $e->getMessage()]);
            }
            return [];
        });
    }

    /**
     * Resolve an account name from a bank code and account number.
     */
    public function resolveAccountName(string $accountNumber, string $bankCode): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->withoutVerifying()
                ->get($this->baseUrl . '/bank/resolve', [
                    'account_number' => $accountNumber,
                    'bank_code' => $bankCode,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'account_name' => $response->json('data.account_name'),
                ];
            }

            return ['success' => false, 'message' => $response->json('message') ?? 'Could not resolve account.'];
        } catch (\Exception $e) {
            Log::error('Paystack resolveAccountName failed', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => 'An error occurred.'];
        }
    }
}
