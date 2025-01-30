<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                "name" => "Laptop HP Pavilion",
                "description" => "Laptop con procesador Intel Core i7 y 16GB RAM.",
                "price" => 1200.50,
                "stock" => 50,
                "category_id" => 1,
                "distributor_id" => 1,
                "status" => "available"
            ],
            [
                "name" => "Mouse Inalámbrico Logitech",
                "description" => "Mouse ergonómico con conectividad Bluetooth.",
                "price" => 35.99,
                "stock" => 200,
                "category_id" => 2,
                "distributor_id" => 2,
                "status" => "available"
            ],
            [
                "name" => "Teclado Mecánico Redragon",
                "description" => "Teclado RGB con switches mecánicos y antighosting.",
                "price" => 89.99,
                "stock" => 100,
                "category_id" => 2,
                "distributor_id" => 3,
                "status" => "available"
            ],
        ]);
    }
}
