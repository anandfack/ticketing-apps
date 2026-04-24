<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'parent_id',
        'head_user_id',
    ];

    // RELASI USERS
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // HEAD DEPARTMENT
    public function head()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    // SELF REFERENCE
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }
}
