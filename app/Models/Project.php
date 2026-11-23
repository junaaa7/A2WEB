<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category', 'description',
        'tech_stack', 'image_path', 'images', 'url_link',
    ];

    // Casting JSON dari database menjadi Array di PHP
    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'images' => 'array',
        ];
    }

    /**
     * Menggabungkan image_path dan images menjadi satu array unik tanpa duplikasi dan bersih dari format path ganda.
     *
     * @return array<int, string>
     */
    public function getAllImagesAttribute(): array
    {
        $all = [];

        $images = $this->images;
        if (is_string($images)) {
            $decoded = json_decode($images, true);
            if (is_array($decoded)) {
                $images = $decoded;
            }
        }

        if (is_array($images)) {
            $all = $images;
        }

        if ($this->image_path && ! in_array($this->image_path, $all, true)) {
            array_unshift($all, $this->image_path);
        }

        $cleaned = array_map(function ($path) {
            if (! is_string($path)) {
                return null;
            }

            $clean = ltrim(trim($path), '/');
            if (str_starts_with($clean, 'storage/')) {
                $clean = substr($clean, 8);
            }

            return $clean !== '' ? $clean : null;
        }, $all);

        return array_values(array_unique(array_filter($cleaned)));
    }

    /**
     * Mengembalikan seluruh URL gambar publik untuk frontend/modal.
     *
     * @return array<int, string>
     */
    public function getAllImageUrlsAttribute(): array
    {
        return array_map(function ($path) {
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }

            return asset('storage/'.ltrim($path, '/'));
        }, $this->all_images);
    }

    /**
     * Mengembalikan URL gambar cover utama (gambar pertama) atau null.
     */
    public function getFirstImageUrlAttribute(): ?string
    {
        $urls = $this->all_image_urls;

        return $urls[0] ?? null;
    }
}
