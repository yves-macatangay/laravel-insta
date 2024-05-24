<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //you can use: save(), create(), createMany()
        //insert()

        $categories = [
            [
                'name' => 'Theatre',
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
            [
                'name' => 'Carnival',
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
            [
                'name' => 'Outdoors',
                'updated_at' => NOW(),
                'created_at' => NOW()
            ]
        ];

        $this->category->insert($categories);
    }
}
