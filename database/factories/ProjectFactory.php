<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => $this->faker->randomElement(['E-Commerce', 'Sistem Manajemen', 'Mobile Apps']),
            'description' => $this->faker->paragraph(),
            'tech_stack' => ['Laravel 13', 'Tailwind CSS', 'MySQL', 'PHP 8.5'],
            'image_path' => null, // Nanti kita buat default image di frontend
            'url_link' => 'https://github.com/portojunsweb',
        ];
    }
}