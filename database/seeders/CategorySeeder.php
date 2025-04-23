<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name'=>'ريادة الاعمال ']);
        Category::create(['name'=>'البرمجة']);
        Category::create(['name'=>'الذكاء الاصطناعي']);
        Category::create(['name'=>'المحاسبة']);
        Category::create(['name'=>'التربية']);
        Category::create(['name'=>'الرياضيات']);
    }
}
