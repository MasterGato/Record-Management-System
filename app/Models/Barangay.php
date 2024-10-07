<?php

// app/Models/Barangay.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['barangay_name', 'municipality_id'];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
