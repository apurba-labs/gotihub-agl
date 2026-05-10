<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['event_type', 'message', 'status', 'metadata'])]
class AuditLog extends Model
{
    use HasFactory;

    protected $casts = [
        'metadata' => 'array',
    ];
}