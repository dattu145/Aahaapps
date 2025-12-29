<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_home_page_renders_db_content(): void
    {
        Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => 'DB Content',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('DB Content');
    }

    public function test_public_menu_renders_db_items(): void
    {
        // Create Home page so it uses page.blade.php which has the menu loop
        Page::create(['title' => 'Home', 'slug' => 'home', 'content' => 'Home', 'is_active' => true]);

        MenuItem::create([
            'label' => 'Dynamic Link',
            'url' => '/dynamic',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertSee('Dynamic Link');
    }

    public function test_admin_can_update_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'super-admin']);

        $file = UploadedFile::fake()->image('logo.jpg');

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'logo' => $file,
        ]);

        $response->assertSessionHas('success');
        $this->assertNotNull(Setting::get('logo'));
        Storage::disk('public')->assertExists(Setting::get('logo'));
    }

    public function test_admin_can_manage_pages(): void
    {
        $admin = User::factory()->create(['role' => 'super-admin']);

        // Create
        $response = $this->actingAs($admin)->post(route('admin.pages.store'), [
            'title' => 'New Page',
            'content' => 'Page Content',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['slug' => 'new-page']);

        // Edit
        $page = Page::first();
        $response = $this->actingAs($admin)->put(route('admin.pages.update', $page), [
            'title' => 'Updated Page',
            'content' => 'Updated Content',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('pages', ['title' => 'Updated Page']);
    }
    public function test_admin_can_manage_services(): void
    {
        $user = User::factory()->create(['role' => 'super-admin']);

        $response = $this->actingAs($user)->get(route('admin.services.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('admin.services.store'), [
            'name' => 'Web Development',
            'description' => 'We build websites.',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['name' => 'Web Development']);
    }

    public function test_public_home_renders_services(): void
    {
        // Must clear cache/existing pages to ensure clean state if needed, or just create home if not exists
        \App\Models\Page::firstOrCreate(
            ['slug' => 'home'],
            ['title' => 'Home', 'content' => 'Welcome', 'is_active' => true]
        );

        \App\Models\Service::create([
            'name' => 'SEO Services',
            'description' => 'Rank high.',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SEO Services');
        $response->assertSee('Rank high.');
    }
    public function test_dynamic_pages_have_seo_and_cta(): void
    {
        Page::create([
            'title' => 'Store',
            'slug' => 'store',
            'content' => 'Store Content',
            'meta_description' => 'Best Store',
            'cta_text' => 'Go to Store',
            'cta_url' => 'https://store.example.com',
            'is_active' => true,
        ]);

        $response = $this->get('/store');

        $response->assertStatus(200);
        $response->assertSee('Store Content');
        $response->assertSee('Best Store'); // Meta description
        $response->assertSee('Go to Store'); // CTA Text
        $response->assertSee('https://store.example.com'); // CTA URL
    }
}
