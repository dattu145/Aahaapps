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
        
        $items = [
            ['label' => 'About', 'url' => '/about', 'order' => 2],
            ['label' => 'Contact', 'url' => '/contact', 'order' => 3],
            ['label' => 'Store', 'url' => '/store', 'order' => 4],
            ['label' => 'ERP', 'url' => '/erp', 'order' => 5],
            ['label' => 'CRM', 'url' => '/crm', 'order' => 6],
            ['label' => 'Blog', 'url' => '/blog', 'order' => 7],
        ];

        foreach ($items as $item) {
            \App\Models\MenuItem::create([
                'label' => $item['label'],
                'url' => $item['url'],
                'order' => $item['order'],
                'is_active' => true,
            ]);

            // Also create a page for each so links don't 404
            \App\Models\Page::create([
                'title' => $item['label'],
                'slug' => strtolower($item['label']),
                'content' => "Welcome to the {$item['label']} page. Content coming soon.",
                'is_active' => true,
            ]);
        }

        \App\Models\Setting::set('logo', null);
    }
}
