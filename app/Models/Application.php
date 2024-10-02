<?php

// app/Models/Application.php

// app/Models/Application.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'Typeofapplication',
        'Dateofapplication',
        'Controlnumber',
        'status',
        'applicant_id',
        'branch_id',
        'job_offer_id',
    ];
    protected static function booted()
{
    static::addGlobalScope('branch', function (Builder $builder) {
        // Ensure the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user is an admin
            if ($user->role === 'ADMIN') {
                // Admin users should see all data, no scope applied
                return;
            }

            // Non-admin users only see data related to their branch
            $builder->where('branch_id', $user->branch_id);
        }
    });
}



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($applicant) {
            // Soft delete related work experiences
            $applicant->workExperiences()->each(function ($workExperience) {
                $workExperience->delete();
            });

            // Soft delete related educational attainments
            $applicant->educationalAttainments()->each(function ($educationalAttainment) {
                $educationalAttainment->delete();
            });
        });
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
