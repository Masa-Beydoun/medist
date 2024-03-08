<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
                ['en' => 'Pain Killers', 'ar' => 'مسكنات', 'img' => 'public\category_images\brain.png'],
                ['en' => 'Antibiotics', 'ar' => 'مضادات حيوية', 'img' => 'public\category_images\anti.png'],
                ['en' => 'Food Supplements', 'ar' => 'مكملات غذائية', 'img' => 'public\category_images\vitamins.png'],
                ['en' => 'Cardiovascular Medications', 'ar' => 'ادوية قلبية', 'img' => 'public\category_images\heart.png'],
                ['en' => 'Respiratory Medications', 'ar' => 'ادوية تنفسية', 'img' => 'public\category_images\lungs.png'],
                ['en' => 'Intestinal Medications', 'ar' => 'ادوية معوية', 'img' => 'public\category_images\stomach.png'],
                ['en' => 'Endocrine Medications', 'ar' => 'ادوية غدية', 'img' => 'public\category_images\pancreas.png'],
                ['en' => 'Dermatology Medications', 'ar' => 'ادوية جلدية', 'img' => 'public\category_images\allergy.png'],
            ];
        foreach($names as $name) {
            $category = Category::create([
                'name' => [
                    'en' => $name['en'],
                    'ar' => $name['ar']
                ]
            ]);
            $category->addMedia($name['img'])->preservingOriginal()->toMediaCollection('categories');
        }
    }
}
