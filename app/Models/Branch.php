<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $primarykey ='branch_id';
    use HasFactory;
    protected $fillable = [
        'branchname',
        'region',
        'province',
        'city',
        'status'
    ];
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
