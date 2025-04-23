<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $number_of_book = Book::count();
        $number_of_categories = Category::count();
        $number_of_author = Author::count();
        $number_of_publisher = Publisher::count();

        return view('admin.index' , compact(['number_of_book' , 'number_of_categories' ,'number_of_author' ,'number_of_publisher']));
    }
}
