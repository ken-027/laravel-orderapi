<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::create([
            'name' => 'Mouse',
            'available_stock' => 15,
        ]);
        Product::create([
            'name' => 'Keyboard',
            'available_stock' => 10,
        ]);
        Product::create([
            'name' => 'Monitor',
            'available_stock' => 5,
        ]);
        Product::create([
            'name' => 'CPU',
            'available_stock' => 0,
        ]);
    }
}