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
}
