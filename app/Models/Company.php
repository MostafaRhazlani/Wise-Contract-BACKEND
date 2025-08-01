<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'email',
        'address',
        'company_logo',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'company_department');
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function gallery() {
        return $this->hasMany(CompanyGallery::class);
    }
}