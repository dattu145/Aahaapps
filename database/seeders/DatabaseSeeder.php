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
                'content' => "Welcome to the {$item['label']} page.\n\nManage your {$item['label']} effectively with Aaha Apps. Sign up now to get started!",
                'is_active' => true,
                'meta_description' => "Explore our {$item['label']} solutions.",
                'cta_text' => "Get Started with {$item['label']}",
                'cta_url' => 'https://profile.aahaapps.com/',
            ]);
        }

        \App\Models\Setting::set('logo', null);

        // Services
        $serviceItems = [
            ['name' => 'Web Development', 'description' => 'Custom websites tailored to your needs.', 'order' => 1],
            ['name' => 'App Development', 'description' => 'Native and hybrid mobile applications.', 'order' => 2],
            ['name' => 'SEO Optimization', 'description' => 'Improve your search engine rankings.', 'order' => 3],
            ['name' => 'Digital Marketing', 'description' => 'Reach your audience effectively.', 'order' => 4],
            ['name' => 'Cloud Solutions', 'description' => 'Scalable cloud infrastructure management.', 'order' => 5],
            ['name' => 'Business Consulting', 'description' => 'Expert advice for growing your business.', 'order' => 6],
        ];

        foreach ($serviceItems as $item) {
            \App\Models\Service::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'is_active' => true,
                'order' => $item['order'],
            ]);
        }
    }
}
