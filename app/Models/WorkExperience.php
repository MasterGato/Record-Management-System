<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    // The table associated with the model (optional if naming convention is followed)
    protected $table = 'work_experience';

    // Mass-assignable fields
    protected $fillable = [
        'Company',
        'Work',
        'Years',
        'applicant_id'
    ];

    // Define the relationship with the Applicant model
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
