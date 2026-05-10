<?php

namespace App\Services;

use App\Models\AuditLog;

class ApprovalEngine
{
    public function processApproval(string $id, string $step): void
    {
        // Here we will  update our 'transactions' table status
        // For now, we log the engine's internal action
        AuditLog::create([
            'event_type' => 'Workflow',
            'message' => "Approval Engine: Step [{$step}] verified for Transaction {$id}.",
            'status' => 'success'
        ]);
    }

    public function flagForReview(string $id, string $reason): void
    {
        AuditLog::create([
            'event_type' => 'Workflow',
            'message' => "Approval Engine: Flagged {$id} for Manual Review. Reason: {$reason}",
            'status' => 'danger'
        ]);
    }
}