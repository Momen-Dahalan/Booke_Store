<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.main');
    })->name('dashboard');
    Route::get('/' , [GalleryController::class, 'index'])->name('gallery.index');
});

Route::get('/' , [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/home' , [GalleryController::class , 'index'])->name('home');
Route::get('/search' , [GalleryController::class , 'search'])->name('search');
Route::get('/book/{book}' , [BookController::class , 'details'])->name('show_book')->middleware('auth');
Route::post('/book/{book}/rate' , [BookController::class , 'rate'])->name('book.rate');


Route::get('/categories' , [CategoryController::class , 'view_category'])->name('view_categories');
Route::get('/categories/{category}', [CategoryController::class, 'show_category'])->name('gallery.categories.show');
Route::get('/search/category' , [CategoryController::class , 'search'])->name('search_category');

Route::get('/publishers', [PublisherController::class, 'view_publisher'])->name('view_publishers');
Route::get('/publishers/search', [PublisherController::class, 'search'])->name('search_publisher');
// عرض معلومات ناشر محدد
Route::get('/publishers/{publisher}', [PublisherController::class, 'show_publisher'])->name('show_publisher');




Route::get('/authors', [AuthorController::class, 'view_authors'])->name('view_author');
Route::get('/authors/search', [AuthorController::class, 'search'])->name('search_author');
Route::get('/authors/{author}', [AuthorController::class, 'show_authors'])->name('show_authors');

Route::prefix('/admin')->middleware('can:isAdmin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/books', BookController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/publishers', PublisherController::class);
    Route::resource('/authors', AuthorController::class);
    Route::resource('/users', UserController::class)->middleware('can:isSuperAdmin');
    Route::get('/admin/allproduct' , [BookController::class , 'allProduct'])->name('all.product');

});

Route::post('/cart' , [CartController::class , 'addToCart'])->name('cart.add')->middleware('auth');
Route::get('/cart' ,[CartController::class , 'view_cart'])->name('cart.view');
Route::post('/removeOne/{book}', [CartController::class , 'removeOne'])->name('remove_one');
Route::post('/removeAll/{book}' , [CartController::class , 'removeAll'])->name('remove_all');



Route::get('/myBooks', [BookController::class, 'myBooks'])->name('myBooks');
