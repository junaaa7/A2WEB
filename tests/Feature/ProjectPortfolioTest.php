<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectPortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_projects_and_images(): void
    {
        $projectWithImage = Project::create([
            'title' => 'Web App E-Commerce',
            'slug' => 'web-app-e-commerce',
            'category' => 'E-Commerce',
            'description' => 'Toko online modern',
            'tech_stack' => ['Laravel', 'Tailwind'],
            'image_path' => 'projects/sample.png',
            'images' => ['projects/sample.png', 'projects/sample2.png'],
        ]);

        $projectWithoutImage = Project::create([
            'title' => 'Mobile App Android',
            'slug' => 'mobile-app-android',
            'category' => 'Mobile Apps',
            'description' => 'Aplikasi kasir',
            'tech_stack' => ['Flutter'],
            'image_path' => null,
            'images' => null,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Web App E-Commerce');
        $response->assertSee('storage/projects/sample.png');
        $response->assertSee('Mobile App Android');
        $response->assertSee('No Image');
        $response->assertSee('openModal(');
        $response->assertSee('2 Foto');
        $response->assertSee('Kunjungi Proyek / Live Demo');
        $response->assertSee('Deskripsi Lengkap');
        $response->assertSee('portfolio-filter-btn');
        $response->assertSee("selectServicePackage('Web UMKM / Profil Bisnis')", false);
        $response->assertSee("selectServicePackage('Web Sistem / E-Commerce')", false);
        $response->assertSee("selectServicePackage('Joki / Pendampingan Skripsi IT')", false);
        $response->assertSee('Space Grotesk');
        $response->assertSee('Plus Jakarta Sans');
        $response->assertSee('JetBrains Mono');
        $response->assertSee('Alur Pengerjaan');
        $response->assertSee('dark-frontend');
    }

    public function test_homepage_displays_faq_section(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Pertanyaan yang Sering Diajukan');
        $response->assertSee('Berapa lama estimasi pengerjaan website atau sistem skripsi?');
        $response->assertSee('Apakah saya akan mendapatkan 100% source code dan database?');
        $response->assertSee('Bagaimana alur dan sistem pembayarannya?');
    }

    public function test_admin_can_store_project_with_multiple_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $file1 = UploadedFile::fake()->image('img1.jpg');
        $file2 = UploadedFile::fake()->image('img2.jpg');
        $file3 = UploadedFile::fake()->image('img3.jpg');

        $response = $this->actingAs($user)->post(route('admin.projects.store'), [
            'title' => 'Portfolio Multi Image',
            'category' => 'E-Commerce',
            'description' => 'Deskripsi portfolio multi image',
            'tech_stack' => 'Laravel, Vue, MySQL',
            'images' => [$file1, $file2, $file3],
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $response->assertSessionHas('success');

        $project = Project::where('title', 'Portfolio Multi Image')->first();
        $this->assertNotNull($project);
        $this->assertCount(3, $project->images);
        $this->assertEquals($project->images[0], $project->image_path);

        foreach ($project->images as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_admin_can_update_project_and_add_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $project = Project::create([
            'title' => 'Proyek Awal',
            'slug' => 'proyek-awal',
            'category' => 'Sistem Manajemen',
            'description' => 'Deskripsi lama',
            'tech_stack' => ['Laravel'],
            'image_path' => 'projects/old1.jpg',
            'images' => ['projects/old1.jpg'],
        ]);

        $newFile = UploadedFile::fake()->image('new2.jpg');

        $response = $this->actingAs($user)->put(route('admin.projects.update', $project), [
            'title' => 'Proyek Diupdate',
            'category' => 'E-Commerce',
            'description' => 'Deskripsi baru yang diperbarui',
            'tech_stack' => 'Laravel, Tailwind, MySQL',
            'images' => [$newFile],
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $response->assertSessionHas('success');

        $project->refresh();
        $this->assertSame('Proyek Diupdate', $project->title);
        $this->assertSame('E-Commerce', $project->category);
        $this->assertCount(2, $project->all_images);
        $this->assertEquals(['Laravel', 'Tailwind', 'MySQL'], $project->tech_stack);
    }

    public function test_admin_can_delete_individual_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $img1 = 'projects/img1_to_delete.png';
        $img2 = 'projects/img2_keep.png';

        Storage::disk('public')->put($img1, 'content 1');
        Storage::disk('public')->put($img2, 'content 2');

        $project = Project::create([
            'title' => 'Proyek Galeri',
            'slug' => 'proyek-galeri',
            'category' => 'E-Commerce',
            'description' => 'Deskripsi',
            'tech_stack' => ['Laravel'],
            'image_path' => $img1,
            'images' => [$img1, $img2],
        ]);

        $response = $this->actingAs($user)->delete(route('admin.projects.images.destroy', $project), [
            'image' => $img1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $project->refresh();
        Storage::disk('public')->assertMissing($img1);
        Storage::disk('public')->assertExists($img2);

        $this->assertCount(1, $project->images);
        $this->assertEquals($img2, $project->image_path);
    }

    public function test_admin_can_delete_project_and_its_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $imagePath1 = 'projects/delete1.png';
        $imagePath2 = 'projects/delete2.png';
        Storage::disk('public')->put($imagePath1, 'fake-content-1');
        Storage::disk('public')->put($imagePath2, 'fake-content-2');

        $project = Project::create([
            'title' => 'Project Akan Dihapus',
            'slug' => 'project-akan-dihapus',
            'category' => 'Sistem Manajemen',
            'description' => 'Deskripsi',
            'tech_stack' => ['Laravel'],
            'image_path' => $imagePath1,
            'images' => [$imagePath1, $imagePath2],
        ]);

        $response = $this->actingAs($user)->delete(route('admin.projects.destroy', $project));

        $response->assertRedirect();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        Storage::disk('public')->assertMissing($imagePath1);
        Storage::disk('public')->assertMissing($imagePath2);
    }

    public function test_project_model_cleans_duplicate_storage_prefixes_and_generates_correct_urls(): void
    {
        $project = Project::create([
            'title' => 'Test URL Cleaning',
            'slug' => 'test-url-cleaning',
            'category' => 'Mobile Apps',
            'description' => 'Test',
            'tech_stack' => ['PHP'],
            'image_path' => '/storage/projects/leading_slash.jpg',
            'images' => [
                'storage/projects/leading_slash.jpg',
                'projects/clean.png',
                'https://example.com/external.webp',
            ],
        ]);

        $this->assertContains('projects/leading_slash.jpg', $project->all_images);
        $this->assertContains('projects/clean.png', $project->all_images);

        $urls = $project->all_image_urls;
        $this->assertStringNotContainsString('storage/storage', $urls[0]);
        $this->assertStringEndsWith('storage/projects/leading_slash.jpg', $urls[0]);
        $this->assertSame($urls[0], $project->first_image_url);
        $this->assertContains('https://example.com/external.webp', $urls);
    }

    public function test_admin_can_store_project_with_gif_and_empty_images(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        // Upload with GIF image
        $gif = UploadedFile::fake()->image('animation.gif');
        $response = $this->actingAs($user)->post(route('admin.projects.store'), [
            'title' => 'Project with GIF',
            'category' => 'E-Commerce',
            'description' => 'GIF test',
            'tech_stack' => 'Laravel, Vue',
            'images' => [$gif],
        ]);

        $response->assertRedirect(route('admin.projects.index'));
        $project = Project::where('title', 'Project with GIF')->first();
        $this->assertNotNull($project);
        $this->assertCount(1, $project->images);

        // Upload without images (nullable)
        $responseNoImg = $this->actingAs($user)->post(route('admin.projects.store'), [
            'title' => 'Project No Images',
            'category' => 'Sistem Manajemen',
            'description' => 'No image project',
            'tech_stack' => 'Laravel',
            'images' => null,
        ]);

        $responseNoImg->assertRedirect(route('admin.projects.index'));
        $projectNoImg = Project::where('title', 'Project No Images')->first();
        $this->assertNotNull($projectNoImg);
        $this->assertNull($projectNoImg->image_path);
        $this->assertNull($projectNoImg->images);
    }

    public function test_admin_projects_index_shows_list_without_create_form(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('admin.projects.index'));

        $response->assertOk();
        $response->assertSee('Daftar Portofolio');
        $response->assertSee('+ Tambah Portofolio Baru');
        $response->assertSee(route('admin.projects.create'));
        $response->assertDontSee('projectUploadHandler()');
        $response->assertDontSee('Simpan Portofolio');
        $response->assertSee('border-cyan-400');
    }

    public function test_admin_can_access_create_project_page_and_see_active_nav(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('admin.projects.create'));

        $response->assertOk();
        $response->assertSee('Tambah Portofolio Baru');
        $response->assertSee(route('admin.projects.index'));
        $response->assertSee(route('admin.projects.store'));
        $response->assertSee('enctype="multipart/form-data"', false);
        $response->assertSee('name="images[]"', false);
        $response->assertSee('projectUploadHandler()');
        $response->assertSee('border-cyan-400');
    }

    public function test_admin_auth_and_profile_pages_use_a2web_dark_theme_and_branding(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $project = Project::create([
            'title' => 'Sistem Dark Theme',
            'slug' => 'sistem-dark-theme',
            'category' => 'Sistem Manajemen',
            'description' => 'Deskripsi proyek',
            'tech_stack' => ['Laravel', 'Tailwind'],
        ]);

        $loginResponse = $this->get(route('login'));
        $loginResponse->assertOk();
        $loginResponse->assertSee('dark-theme');
        $loginResponse->assertSee('A2<span class="text-cyan-400">Web</span>', false);
        $loginResponse->assertSee('Admin', false);
        $loginResponse->assertSee('Space Grotesk');
        $loginResponse->assertSee('Plus Jakarta Sans');
        $loginResponse->assertDontSee('Porto Juns');
        $loginResponse->assertDontSee('bg-white');

        foreach ([
            route('admin.dashboard'),
            route('admin.projects.index'),
            route('admin.projects.create'),
            route('admin.projects.edit', $project),
            route('admin.orders.index'),
            route('profile.edit'),
        ] as $url) {
            $response = $this->actingAs($user)->get($url);
            $response->assertOk();
            $response->assertSee('dark-theme');
            $response->assertSee('Space Grotesk');
            $response->assertSee('Plus Jakarta Sans');
            $response->assertSee('Lihat Website');
            $response->assertSee('bg-[#060919]', false);
            $response->assertDontSee('Porto Juns');
            $response->assertDontSee('bg-white');
            $response->assertDontSee('bg-gray-100');
        }
    }

    public function test_guest_cannot_access_admin_project_pages(): void
    {
        $this->get(route('admin.projects.index'))->assertRedirect(route('login'));
        $this->get(route('admin.projects.create'))->assertRedirect(route('login'));
    }

    public function test_create_project_validation_failure_preserves_old_input(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->from(route('admin.projects.create'))
            ->post(route('admin.projects.store'), [
                'title' => 'Judul Tersimpan',
                'category' => 'E-Commerce',
                'tech_stack' => 'Laravel',
                'description' => '',
            ]);

        $response->assertRedirect(route('admin.projects.create'));
        $response->assertSessionHasErrors('description');
        $this->assertSame('Judul Tersimpan', session()->getOldInput('title'));
    }

    public function test_all_layouts_include_a2web_favicon_tags(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        foreach ([
            $this->get('/'),
            $this->get(route('login')),
            $this->actingAs($user)->get(route('admin.projects.index')),
        ] as $response) {
            $response->assertOk();
            $response->assertSee('favicon-32x32.png');
            $response->assertSee('favicon-16x16.png');
            $response->assertSee('favicon.ico');
            $response->assertSee('apple-touch-icon.png');
            $response->assertDontSee('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwC');
        }
    }
}
