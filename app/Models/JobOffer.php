<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'Job',
        'status',
        'country_id'
    ];
    public function getJobWithCountryAttribute()
    {
        return "{$this->Job} - {$this->country->name}";
    }
    public function country()
    {
        return $this->belongsTo(country::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
