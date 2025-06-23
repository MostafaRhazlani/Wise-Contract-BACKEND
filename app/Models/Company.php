<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'owner_id',
        'company_logo',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function templates() {
        return $this->hasMany(Template::class);
    }
}