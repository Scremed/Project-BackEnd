<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category_name'=> "Elektronik",
        ]);
        Category::create([
            'category_name'=> "Furniture",
        ]);
        Category::create([
            'category_name'=> "Pakaian",
        ]);
    }
}
