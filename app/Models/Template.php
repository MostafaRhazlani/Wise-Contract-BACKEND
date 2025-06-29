<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_json',
        'company_id'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
