<?php

namespace Database\Seeders;

use App\Models\Product;
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

        $this->call([
            RolesSeeder::class,
            CategorySeeder::class,
            ProductsSeeder::class
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.test',
            'password' => bcrypt('demo2089'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('Administrador');
    }
}
