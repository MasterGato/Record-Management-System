<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'middlename',
        'gender',
        'contact',
        'email',
        'password',
        'role',
        'status',
        'branch_id',
    ];
}
