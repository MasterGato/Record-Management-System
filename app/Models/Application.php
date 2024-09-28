<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'Typeofapplication',
        'Dateofapplication',
        'Controlnumber',
        'Status',
        'branch_id',
        'applicant_id',
        'job_offer_id' // Ensure consistency with database column naming
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id'); // Specify foreign key if different from the default
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
