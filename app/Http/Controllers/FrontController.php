<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Order;
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
        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'service_category' => 'required|string',
            'description' => 'required|string',
            'deadline_date' => 'required|date',
        ]);

        // 2. Simpan pesanan ke database (sebagai Leads/Data Historis Admin)
        Order::create($validated);

        // 3. Generate Link Direct-to-WhatsApp
        $adminPhone = '6281234567890'; // TODO: Ganti dengan nomor WhatsApp Anda yang aktif
        
        $message = "Halo *Porto Juns*, saya tertarik dengan layanan Anda!\n\n"
                 . "*Nama:* {$validated['name']}\n"
                 . "*Layanan:* {$validated['service_category']}\n"
                 . "*Kebutuhan:* {$validated['description']}\n"
                 . "*Deadline:* {$validated['deadline_date']}\n\n"
                 . "Mohon info lebih lanjut untuk diskusi teknis dan harga. Terima kasih!";
        
        // Encode URL agar format spasi dan enter terbaca di WA
        $waUrl = "https://api.whatsapp.com/send?phone={$adminPhone}&text=" . urlencode($message);

        // 4. Redirect user langsung ke WhatsApp
        return redirect()->away($waUrl);
    }
}