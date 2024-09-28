<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return "{$this->Firstname} {$this->Middleinitial} {$this->Lastname}";
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
