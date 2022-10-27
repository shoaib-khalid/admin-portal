<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    
    protected $table = 'roles';

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
    
}
