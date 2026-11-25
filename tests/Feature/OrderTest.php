<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_fails_when_deadline_is_too_early_for_profil_bisnis(): void
    {
        $response = $this->post(route('order.store'), [
            'name' => 'Budi',
            'phone' => '081234567890',
            'service_category' => 'Web UMKM / Profil Bisnis',
            'description' => 'Website toko kelontong',
            'deadline_date' => now()->setTimezone('Asia/Jakarta')->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('deadline_date');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_succeeds_when_deadline_is_at_least_7_days_for_profil_bisnis(): void
    {
        $deadline = now()->setTimezone('Asia/Jakarta')->addDays(7)->format('Y-m-d');

        $response = $this->post(route('order.store'), [
            'name' => 'Budi',
            'phone' => '081234567890',
            'service_category' => 'Web UMKM / Profil Bisnis',
            'description' => 'Website toko kelontong',
            'deadline_date' => $deadline,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('orders', [
            'name' => 'Budi',
            'service_category' => 'Web UMKM / Profil Bisnis',
        ]);
        $order = Order::first();
        $this->assertEquals($deadline, $order->deadline_date->format('Y-m-d'));
        $location = $response->headers->get('Location');
        $this->assertTrue(str_starts_with($location, 'https://api.whatsapp.com/send?phone=6281319233505&text='));
        $this->assertStringContainsString('A2Web', $location);
        $this->assertStringNotContainsString('6281234567890', $location);
        $this->assertStringNotContainsString('Porto', $location);
    }

    public function test_order_fails_when_deadline_is_too_early_for_ecommerce(): void
    {
        $response = $this->post(route('order.store'), [
            'name' => 'Siti',
            'phone' => '081234567891',
            'service_category' => 'Web Sistem / E-Commerce',
            'description' => 'Marketplace baju',
            'deadline_date' => now()->setTimezone('Asia/Jakarta')->addDays(14)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('deadline_date');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_succeeds_when_deadline_is_at_least_4_weeks_for_ecommerce(): void
    {
        $deadline = now()->setTimezone('Asia/Jakarta')->addDays(28)->format('Y-m-d');

        $response = $this->post(route('order.store'), [
            'name' => 'Siti',
            'phone' => '081234567891',
            'service_category' => 'Web Sistem / E-Commerce',
            'description' => 'Marketplace baju',
            'deadline_date' => $deadline,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('orders', [
            'name' => 'Siti',
            'service_category' => 'Web Sistem / E-Commerce',
        ]);
        $order = Order::first();
        $this->assertEquals($deadline, $order->deadline_date->format('Y-m-d'));
    }

    public function test_order_fails_when_deadline_is_too_early_for_skripsi(): void
    {
        $response = $this->post(route('order.store'), [
            'name' => 'Joko',
            'phone' => '081234567892',
            'service_category' => 'Joki / Pendampingan Skripsi IT',
            'description' => 'Sistem pakar diagnosa penyakit',
            'deadline_date' => now()->setTimezone('Asia/Jakarta')->addDays(10)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('deadline_date');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_succeeds_when_deadline_is_at_least_3_weeks_for_skripsi(): void
    {
        $deadline = now()->setTimezone('Asia/Jakarta')->addDays(21)->format('Y-m-d');

        $response = $this->post(route('order.store'), [
            'name' => 'Joko',
            'phone' => '081234567892',
            'service_category' => 'Joki / Pendampingan Skripsi IT',
            'description' => 'Sistem pakar diagnosa penyakit',
            'deadline_date' => $deadline,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('orders', [
            'name' => 'Joko',
            'service_category' => 'Joki / Pendampingan Skripsi IT',
        ]);
        $order = Order::first();
        $this->assertEquals($deadline, $order->deadline_date->format('Y-m-d'));
    }
}
