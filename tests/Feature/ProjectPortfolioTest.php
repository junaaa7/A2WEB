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
        ]);

        $projectWithoutImage = Project::create([
            'title' => 'Mobile App Android',
            'slug' => 'mobile-app-android',
            'category' => 'Mobile Apps',
            'description' => 'Aplikasi kasir',
            'tech_stack' => ['Flutter'],
            'image_path' => null,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Web App E-Commerce');
        $response->assertSee('storage/projects/sample.png');
        $response->assertSee('Mobile App Android');
        $response->assertSee('No Image');
    }

    public function test_admin_can_store_project_with_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $file = UploadedFile::fake()->image('project_screenshot.jpg');

        $response = $this->actingAs($user)->post(route('admin.projects.store'), [
            'title' => 'Portfolio Keren',
            'category' => 'E-Commerce',
            'description' => 'Deskripsi portfolio keren',
            'tech_stack' => 'Laravel, Vue, MySQL',
            'image' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $project = Project::where('title', 'Portfolio Keren')->first();
        $this->assertNotNull($project);
        $this->assertNotNull($project->image_path);
        $this->assertEquals(['Laravel', 'Vue', 'MySQL'], $project->tech_stack);

        Storage::disk('public')->assertExists($project->image_path);
    }

    public function test_admin_can_delete_project_and_its_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $imagePath = 'projects/test_to_delete.png';
        Storage::disk('public')->put($imagePath, 'fake-content');

        $project = Project::create([
            'title' => 'Project Akan Dihapus',
            'slug' => 'project-akan-dihapus',
            'category' => 'Sistem Manajemen',
            'description' => 'Deskripsi',
            'tech_stack' => ['Laravel'],
            'image_path' => $imagePath,
        ]);

        $response = $this->actingAs($user)->delete(route('admin.projects.destroy', $project));

        $response->assertRedirect();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }
}
