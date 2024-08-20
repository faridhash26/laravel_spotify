<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;
    const ROLE_ADMINISTRATOR = 1;
    const ROLE_USER = 2;
    
    protected $fillable = ['name' ,'alias' , 'guard_name'];
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
