<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'category_id' => Category::where('name' ,'ريادة الاعمال ')->first()->id,
            'publisher_id' =>Publisher::where('name' , 'اكاديمية حسوب')->first()->id,
            'title'=>'التوظيف عن بعد',
            'isbn'=>'10000000',
            'description'=> 'ليت بلكبسين سيبسكمط يبمالن لابنلك يبلم بيلسمنط',
            'publisher_year'=> '2020',
            'number_of_pages'=>'283',
            'number_of_copies' =>'300',
            'price'=>'17',
            'cover_image'=>'images/cover/1.png',

        ]);
        // $book1->authors()->attach(Author::where('name' , 'محمد احمد'))->first();


        Book::create([
            'category_id' => Category::where('name' ,'البرمجة')->first()->id,
            'publisher_id' =>Publisher::where('name' , 'اكاديمية حسوب')->first()->id,
            'title'=>'java programming',
            'isbn'=>'100000000',
            'description'=> 'ليت بلكبسين سيبسكمط يبمالن لابنلك يبلم بيلسمنط',
            'publisher_year'=> '2022',
            'number_of_pages'=>'283',
            'number_of_copies' =>'300',
            'price'=>'30',
            'cover_image'=>'images/cover/2.png',

        ]);
        // $book2->authors()->attach(Author::where('name' , 'محمود خضر'))->first();




        Book::create([
            'category_id' => Category::where('name' ,'الذكاء الاصطناعي')->first()->id,
            'publisher_id' =>Publisher::where('name' , 'اكاديمية حسوب')->first()->id,
            'title'=>'Ai',
            'isbn'=>'200000000',
            'description'=> 'ليت بلكبسين سيبسكمط يبمالن لابنلك يبلم بيلسمنط',
            'publisher_year'=> '2023',
            'number_of_pages'=>'283',
            'number_of_copies' =>'300',
            'price'=>'20',
            'cover_image'=>'images/cover/3.png',

        ]);
        // $book3->authors()->attach(Author::where('name' , 'رافت غطاس'))->first();
    }
}
