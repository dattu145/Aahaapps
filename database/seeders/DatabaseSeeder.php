<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@aahaapps.com',
            'role' => 'super-admin',
            'password' => bcrypt('password'),
        ]);
        // CMS Data
        \App\Models\Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => 'Welcome to Aaha Apps! This content is managed via the CMS.',
            'is_active' => true,
        ]);

        \App\Models\MenuItem::create([
            'label' => 'Home',
            'url' => '/',
            'order' => 1,
            'is_active' => true,
        ]);
        
        \App\Models\Setting::set('logo', null);
    }
}
