<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Admin
        User::factory()->create([
            'name' => 'Admin Juns',
            'email' => 'admin@portojuns.web',
            'password' => Hash::make('password123'),
        ]);

        // Buat 6 dummy project untuk showcase
        Project::factory(6)->create();

        // Buat dummy order (opsional, jika ingin melihat tabel leads ada isinya)
        Order::create([
            'name' => 'Mahasiswa Pusing',
            'phone' => '081234567890',
            'service_category' => 'Joki / Pendampingan Skripsi IT',
            'description' => 'Bantu saya membuat sistem SPK metode AHP',
            'deadline_date' => now()->addMonths(2),
            'status' => 'pending'
        ]);
    }
}