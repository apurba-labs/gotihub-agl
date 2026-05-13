<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['alumni_name', 'graduation_year', 'student_id', 'status', 'risk_score', 'ai_reasoning', 'proof_id'])]
#[Casts(['risk_score' => 'integer'])]
class AlumniVerification extends Model
{
    use HasFactory;

}
