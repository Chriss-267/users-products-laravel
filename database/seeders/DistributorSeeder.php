<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorSeeder extends Seeder
{
    public function run()
    {
        DB::table('distributors')->insert([
            [
                "name" => "Tech Solutions Inc.",
                "email" => "contact@techsolutions.com",
                "phone" => "555-1234",
                "address" => "Av. Principal 123, Ciudad A",
                "status" => "active"
            ],
            [
                "name" => "GamerZone",
                "email" => "ventas@gamerzone.com",
                "phone" => "555-5678",
                "address" => "Calle 45, Zona B",
                "status" => "active"
            ],
            [
                "name" => "Digital Store",
                "email" => "info@digitalstore.com",
                "phone" => "555-9876",
                "address" => "Boulevard Central, Edificio C",
                "status" => "inactive"
            ],
        ]);
    }
}
