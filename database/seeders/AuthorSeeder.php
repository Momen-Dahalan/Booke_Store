<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'محمد احمد'
        ]);

        Author::create([
            'name' => 'احمد محمد'
        ]);

        Author::create([
            'name' => 'محمود خضر'
        ]);

        Author::create([
            'name' => 'رافت غطاس'
        ]);

        Author::create([
            'name' => 'انس ابو شعرة'
        ]);

        Author::create([
            'name' => 'فادي صبيح'
        ]);


    }
}
