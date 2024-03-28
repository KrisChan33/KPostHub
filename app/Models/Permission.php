<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [

        'name', 'description'

    ];

    public function permission()
    {
        return $this->belongsToMany(Role::class);
    }
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }
}
