<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use LaravelArchivable\Archivable;

class Application extends Model
{
    use HasFactory, Archivable,Notifiable;

    protected $fillable = [
        'Typeofapplication',
        'applicant_id',
        'job_offer_id',
        'branch_id',
        'Dateofapplication',
        'Controlnumber', // Ensure this field exists
        'status', // Ensure this field exists
    ];
    
    

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

    public function documents()
    {
        return $this->hasMany(Document::class); // Establish the relationship to the Document model
    }
}
