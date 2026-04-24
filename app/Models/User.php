<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'employee_id',
        'username',
        'email',
        'password',
        'full_name',
        'avatar_url',
        'phone',
        'department_id',
        'is_active',
        'last_login_at',
        'preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'preferences' => 'array',
        'is_active' => 'boolean',
    ];

    // RELASI
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function headOfDepartments()
    {
        return $this->hasMany(Department::class, 'head_user_id');
    }
}
