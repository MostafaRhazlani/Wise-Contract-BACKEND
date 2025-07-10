<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplatePage extends Model
{
    protected $fillable = [
        'page_name',
        'image_path',
        'content_json',
        'template_id',
    ];

    public function template() {
        return $this->belongsTo(Template::class);
    }
}
