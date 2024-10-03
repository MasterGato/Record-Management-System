<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Applicant extends Model
{
    use HasFactory;

    // The table associated with the model (optional if naming convention is followed)
    protected $table = 'applicants';

    // Mass-assignable fields
    protected $fillable = [
        'Firstname',
        'Lastname',
        'Middleinitial',
        'Gender',
        'Contact',
        'Email',
        'Dateofbirth',
        'Citizenship',
        'Region',
        'Province',
        'City',
        'Brgy',
        'Zipcode',
        'Password',
        'branch_id'
    ];
    
    public function getFullNameAttribute()
    {
        return "{$this->Firstname} {$this->Lastname}"; // Adjust according to your field names
    }

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


    // Define the relationship with the Branch model
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Define the relationship with the WorkExperience model
    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    // Define the relationship with the EducationalAttainment model
    public function educationalAttainments()
    {
        return $this->hasMany(EducationalAttainment::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
