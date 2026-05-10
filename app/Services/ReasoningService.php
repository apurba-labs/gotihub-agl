<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class ReasoningService
{
    public function analyzeTransaction(string $transactionId, string $auditType): array
    {
        // Fetching from config instead of hardcoding
        $url = config('services.gemma.url');

        $response = Http::timeout(30)->post($url, [
            'transaction_id' => $transactionId,
            'audit_type' => $auditType,
        ]);

        if ($response->failed()) {
            throw new \Exception("Gemma Bridge unreachable at {$url}. Check if Python service is running.");
        }

        return $response->json();
    }
}