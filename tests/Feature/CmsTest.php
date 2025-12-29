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
}
