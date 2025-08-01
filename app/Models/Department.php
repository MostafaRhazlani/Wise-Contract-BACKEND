<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_department');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
