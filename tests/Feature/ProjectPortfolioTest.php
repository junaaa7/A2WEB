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

        $response->assertRedirect();
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

        $response->assertRedirect();
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

        $responseNoImg->assertRedirect();
        $projectNoImg = Project::where('title', 'Project No Images')->first();
        $this->assertNotNull($projectNoImg);
        $this->assertNull($projectNoImg->image_path);
        $this->assertNull($projectNoImg->images);
    }
}
