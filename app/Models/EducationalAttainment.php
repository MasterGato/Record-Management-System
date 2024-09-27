<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalAttainment extends Model
{
    use HasFactory;

    // The table associated with the model (optional if naming convention is followed)
    protected $table = 'educational_attainment';

    // Mass-assignable fields
    protected $fillable = [
        'Level',
        'Institution',
        'Inclusivedate',
        'applicant_id'
    ];

    // Define the relationship with the Applicant model
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
