<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_settings_page()
    {
        $user = User::factory()->create(['role' => 'super-admin']);

        $response = $this->actingAs($user)->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('Settings');
    }

    public function test_admin_can_upload_logo_file()
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'super-admin']);
        $file = UploadedFile::fake()->image('logo.jpg');

        $response = $this->actingAs($user)->post(route('admin.settings.update'), [
            'logo' => $file,
        ]);

        $response->assertRedirect();
        
        $storedPath = Setting::get('logo');
        Storage::disk('public')->assertExists($storedPath);
        
        $this->assertNull(Setting::get('logo_url'));
    }

    public function test_admin_can_set_logo_url()
    {
        $user = User::factory()->create(['role' => 'super-admin']);
        $url = 'https://example.com/logo.png';

        $response = $this->actingAs($user)->post(route('admin.settings.update'), [
            'logo_url' => $url,
        ]);

        $response->assertRedirect();
        $this->assertEquals($url, Setting::get('logo_url'));
    }

    public function test_admin_can_upload_cropped_base64_image()
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'super-admin']);
        
        // simple 1x1 transparent png base64
        $base64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

        $response = $this->actingAs($user)->post(route('admin.settings.update'), [
            'cropped_image_data' => $base64,
        ]);

        $response->assertRedirect();
        
        $storedPath = Setting::get('logo');
        Storage::disk('public')->assertExists($storedPath);
        $this->assertNull(Setting::get('logo_url'));
    }

    public function test_file_upload_clears_logo_url()
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'super-admin']);
        
        Setting::set('logo_url', 'https://old.com/logo.png');

        $file = UploadedFile::fake()->image('new.jpg');
        $this->actingAs($user)->post(route('admin.settings.update'), [
            'logo' => $file,
        ]);

        $this->assertNull(Setting::get('logo_url'));
        $this->assertNotNull(Setting::get('logo'));
    }
}
