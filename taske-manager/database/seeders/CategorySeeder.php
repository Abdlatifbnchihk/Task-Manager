<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = ['Work', 'Personal', 'Shopping', 'Health', 'Learning'];

        foreach ($categories as $category) {
            Category::create(
                [
                    'name'=> $category,
                    'slug' => Str::slug($category),
                ]
            );
        }
    }
}
