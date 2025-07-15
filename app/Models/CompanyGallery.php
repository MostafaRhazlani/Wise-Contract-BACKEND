<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyGallery extends Model
{
    protected $fillable = [
        'image_name',
        'image',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
