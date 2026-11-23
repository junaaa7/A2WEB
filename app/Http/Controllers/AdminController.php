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
            'images' => 'nullable|array|max:15',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120', // Kompatibilitas mundur
            'url_link' => 'nullable|url',
        ], [
            'images.max' => 'Maksimal 15 gambar yang dapat diunggah sekaligus.',
            'images.*.image' => 'Setiap file yang diunggah harus berupa file gambar valid.',
            'images.*.mimes' => 'Format gambar harus berupa jpeg, png, jpg, webp, atau gif.',
            'images.*.max' => 'Ukuran maksimal setiap gambar adalah 5MB (5120 KB).',
        ]);

        // Generate Slug agar URL friendly
        $validated['slug'] = Str::slug($validated['title']).'-'.time();

        // Ubah tech_stack dari string ("Laravel, Tailwind") menjadi array
        $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));

        // Proses multiple upload gambar
        $storedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $storedImages[] = $file->store('projects', 'public');
                }
            }
        } elseif ($request->hasFile('image')) {
            $storedImages[] = $request->file('image')->store('projects', 'public');
        }

        if (! empty($storedImages)) {
            $validated['images'] = $storedImages;
            $validated['image_path'] = $storedImages[0];
        } else {
            $validated['images'] = null;
            $validated['image_path'] = null;
        }

        unset($validated['image']);

        Project::create($validated);

        return back()->with('success', 'Portofolio berhasil ditambahkan!');
    }

    public function editProject(Project $project)
    {
        return view('admin.projects-edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'tech_stack' => 'required|string',
            'images' => 'nullable|array|max:15',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'url_link' => 'nullable|url',
        ], [
            'images.max' => 'Maksimal 15 gambar baru yang dapat diunggah sekaligus.',
            'images.*.image' => 'Setiap file yang diunggah harus berupa file gambar valid.',
            'images.*.mimes' => 'Format gambar harus berupa jpeg, png, jpg, webp, atau gif.',
            'images.*.max' => 'Ukuran maksimal setiap gambar adalah 5MB (5120 KB).',
        ]);

        // Update slug jika title berubah
        if ($project->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']).'-'.time();
        }

        // Ubah tech_stack dari string menjadi array
        $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));

        // Ambil gambar yang sudah ada
        $currentImages = $project->all_images;

        // Tambah gambar baru jika diunggah
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file->isValid()) {
                    $currentImages[] = $file->store('projects', 'public');
                }
            }
        }

        $allUniqueImages = array_values(array_unique(array_filter($currentImages)));
        $validated['images'] = ! empty($allUniqueImages) ? $allUniqueImages : null;
        $validated['image_path'] = $allUniqueImages[0] ?? null;

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Portofolio berhasil diperbarui!');
    }

    public function destroyProjectImage(Request $request, Project $project)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $imageToDelete = $request->input('image');
        $currentImages = $project->all_images;

        // Hapus file fisik jika ada di disk public
        if (Storage::disk('public')->exists($imageToDelete)) {
            Storage::disk('public')->delete($imageToDelete);
        }

        // Filter daftar gambar
        $updatedImages = array_values(array_filter($currentImages, function ($img) use ($imageToDelete) {
            return $img !== $imageToDelete;
        }));

        $project->images = ! empty($updatedImages) ? $updatedImages : null;
        $project->image_path = $updatedImages[0] ?? null;
        $project->save();

        return back()->with('success', 'Gambar berhasil dihapus dari portofolio!');
    }

    public function destroyProject(Project $project)
    {
        $allImages = $project->all_images;

        foreach ($allImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
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
