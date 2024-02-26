<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Products') -> insert([
            'name' => "coat",
            'price' => 3000,
            'category_id' => 1
        ]);

        DB::table('Products') -> insert([
            'name' => "T-shirt",
            'price' => 1200,
            'category_id' => 1
        ]);

        DB::table('Products') -> insert([
            'name' => "jacket",
            'price' => 6300,
            'category_id' => 1
        ]);

        DB::table('Products') -> insert([
            'name' => "jeans",
            'price' => 3500,
            'category_id' => 2
        ]);

        DB::table('Products') -> insert([
            'name' => Str::random(6),
            'price' => rand(1,999),
            'category_id' => 1
        ]);
    }
}
