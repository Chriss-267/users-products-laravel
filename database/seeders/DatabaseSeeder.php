<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(3)->create();
        // Distributors::factory(3)->create();
        // Product_categories::factory(3)->create();
        // Products::factory(3)->create();
        // Reviews::factory(3)->create();

        //User::factory()->create([
          //  'name' => 'Test User',
            //'email' => 'test@example.com',
        //]);

        $this->call([
            ProductCategorySeeder::class,
            DistributorSeeder::class,
            ProductSeeder::class,
            
            
        ]);
    }
}
