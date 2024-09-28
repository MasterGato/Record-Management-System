<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_MANAGER = 'MANAGER';
    const ROLE_CLERK = 'CLERK';
    const ROLE_APPLICANT = 'APPLICANT';
    const ROLE_USER = 'USER';


    const ROLE_DEFAULT =self::ROLE_USER;

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_MANAGER => 'Manager',
        self::ROLE_CLERK => 'Clerk',
        self::ROLE_APPLICANT => 'Applicant',
        self::ROLE_USER => 'User'
    ];
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isManager() ||  $this->isApplicant()||  $this->isUser()||  $this->isClerk();
 
    }
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
    public function isManager()
    {
        return $this->role === self::ROLE_MANAGER;
    }
    public function isClerk()
    {
        return $this->role === self::ROLE_CLERK;
    }
    public function isApplicant()
    {
        return $this->role === self::ROLE_APPLICANT;
    }
    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }


    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
