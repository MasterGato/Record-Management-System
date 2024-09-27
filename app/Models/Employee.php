<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'gender',
        'contact',
        'email',
        'password',
        'role',
        'status',
        'branch_id'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
