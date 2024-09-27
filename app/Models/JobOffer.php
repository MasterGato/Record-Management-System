<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;
    protected $fillable=[
        'job',
        'status',
        'country_id'
    ];
    public function country()
    {
        return $this->belongsTo(country::class);
    }
}
