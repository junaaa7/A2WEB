<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    // Menampilkan halaman Landing Page
    public function index()
    {
        // Ambil 6 proyek terbaru dari database
        $projects = Project::latest()->take(6)->get();

        return view('index', compact('projects'));
    }

    // Menangani submission form pemesanan
    public function storeOrder(Request $request)
    {
        // Tentukan batas minimal hari pengerjaan sesuai kategori layanan
        $days = match ($request->input('service_category')) {
            'Web UMKM / Profil Bisnis' => 7,
            'Web Sistem / E-Commerce' => 28,
            'Joki / Pendampingan Skripsi IT' => 21,
            default => 1,
        };

        $minDate = now()->setTimezone('Asia/Jakarta')->addDays($days)->format('Y-m-d');

        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'service_category' => 'required|string|in:Web UMKM / Profil Bisnis,Web Sistem / E-Commerce,Joki / Pendampingan Skripsi IT',
            'description' => 'required|string',
            'deadline_date' => [
                'required',
                'date',
                'after_or_equal:'.$minDate,
            ],
        ], [
            'service_category.in' => 'Kategori layanan tidak valid.',
            'deadline_date.after_or_equal' => "Deadline untuk layanan {$request->input('service_category')} minimal adalah {$days} hari dari tanggal pemesanan (paling cepat ".now()->setTimezone('Asia/Jakarta')->addDays($days)->translatedFormat('d F Y').').',
        ]);

        // 2. Simpan pesanan ke database (sebagai Leads/Data Historis Admin)
        Order::create($validated);

        // 3. Generate Link Direct-to-WhatsApp
        $adminPhone = '6281319233505';

        $formattedDeadline = Carbon::parse($validated['deadline_date'])->translatedFormat('d F Y');

        $message = "Halo *A2Web*, saya tertarik dengan layanan Anda!\n\n"
                 ."*Nama:* {$validated['name']}\n"
                 ."*Layanan:* {$validated['service_category']}\n"
                 ."*Kebutuhan:* {$validated['description']}\n"
                 ."*Deadline:* {$formattedDeadline}\n\n"
                 .'Mohon info lebih lanjut untuk diskusi teknis dan harga. Terima kasih!';

        // Encode URL agar format spasi dan enter terbaca di WA
        $waUrl = 'https://api.whatsapp.com/send?phone='.$adminPhone.'&text='.urlencode($message);

        // 4. Redirect user langsung ke WhatsApp
        return redirect()->away($waUrl);
    }
}
