<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('product_categories')->insert([
            [
                "name" => "Laptops",
                "description" => "Computadoras portátiles de diferentes marcas y modelos."
            ],
            [
                "name" => "Periféricos",
                "description" => "Accesorios como teclados, mouse y auriculares para PC."
            ],
            [
                "name" => "Almacenamiento",
                "description" => "Discos duros, SSD y unidades USB para almacenamiento de datos."
            ],
        ]);
    }
}
