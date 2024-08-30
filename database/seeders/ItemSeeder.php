<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'name'=> "Laptop",
            'price'=> 1200,
            'quantity'=> 10,
            'image'=> "image.jpeg",
            'category_id' => "1",
        ]);

        Item::create([
            'name'=> "Meja",
            'price'=> 1200,
            'quantity'=> 10,
            'image'=> "image.jpeg",
            'category_id' => "2",
        ]);

        Item::create([
            'name'=> "Baju",
            'price'=> 1200,
            'quantity'=> 10,
            'image'=> "image.jpeg",
            'category_id' => "3",
        ]);
    }
}
