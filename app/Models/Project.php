<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category', 'description', 
        'tech_stack', 'image_path', 'url_link'
    ];

    // Casting JSON dari database menjadi Array di PHP
    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
        ];
    }
}