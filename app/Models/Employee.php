<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

     const ROLE_ADMIN = 'ADMIN';
     const ROLE_Editor = 'EDITOR';
     const ROLE_EMPLOYEE = 'EMPLOYEE';

    const ROLES =[
        self::ROLE_ADMIN =>'Admin',
        self::ROLE_Editor =>'Editor',
        self::ROLE_EMPLOYEE =>'Employee'

    ];

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
