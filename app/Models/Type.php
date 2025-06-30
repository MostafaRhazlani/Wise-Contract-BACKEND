<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'logo',
        'color'
    ];

    public function templates()
    {
        return $this->hasMany(Template::class);
    }
}
