<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Menampilkan Dashboard Utama
    public function dashboard()
    {
        $projectCount = Project::count();
        $orderCount = Order::count();

        return view('admin.dashboard', compact('projectCount', 'orderCount'));
    }

    // --- BAGIAN PORTFOLIO (PROJECTS) ---
    public function projects()
    {
        $projects = Project::latest()->get();

        return view('admin.projects', compact('projects'));
    }

    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'tech_stack' => 'required|string', // Input dari frontend berupa string dipisah koma
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_link' => 'nullable|url',
        ]);

        // Generate Slug agar URL friendly
        $validated['slug'] = Str::slug($validated['title']).'-'.time();

        // Ubah tech_stack dari string ("Laravel, Tailwind") menjadi array
        $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($validated);

        return back()->with('success', 'Portofolio berhasil ditambahkan!');
    }

    public function destroyProject(Project $project)
    {
        if ($project->image_path && Storage::disk('public')->exists($project->image_path)) {
            Storage::disk('public')->delete($project->image_path);
        }

        $project->delete();

        return back()->with('success', 'Portofolio berhasil dihapus!');
    }

    // --- BAGIAN LEADS (ORDERS) ---
    public function orders()
    {
        $orders = Order::latest()->get();

        return view('admin.orders', compact('orders'));
    }
}
