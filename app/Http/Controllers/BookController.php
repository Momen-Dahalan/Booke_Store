<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rating;
use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();

        return view('admin.books.create' , compact(['authors' , 'categories' , 'publishers']));
    }

    public function store(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'title' => 'required',
            'isbn' => ['required', 'alpha_num', Rule::unique('books', 'isbn')],
            'cover_image'=> ['image', 'required'],
            'category' => 'required ',
            'authors' => 'nullable',
            'publisher' => 'required',
            'description' => 'nullable',
            'publish_year' => 'nullable|numeric',
            'number_of_pages' => 'required|numeric',
            'number_of_copies' => 'required|numeric',  // تصحيح الخطأ الإملائي
            'price' => 'required|numeric'
        ]);
    
        // إنشاء الكتاب الجديد
        $book = new Book();
        $book->title = $request->title;
        $book->isbn = $request->isbn;
        $book->category_id = $request->category;
        $book->publisher_id = $request->publisher;
        $book->description = $request->description;
        $book->publisher_year = $request->publish_year; // تصحيح `publisher_year` إلى `publish_year`
        $book->number_of_pages = $request->number_of_pages;
        $book->number_of_copies = $request->number_of_copies;
        $book->price = $request->price;
    
        // معالجة وتحميل صورة الغلاف
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = public_path('/images/covers');
            $image->move($imagePath, $imageName);
            $book->cover_image = '/images/covers/'.$imageName;
        }
    
        // حفظ الكتاب
        $book->save();
    
        // إضافة المؤلفين
        if ($request->authors) {
            $book->authors()->attach($request->authors);
        }
    
        // رسالة نجاح
        session()->flash('flash_message', 'تمت إضافة الكتاب بنجاح');
    
        // إعادة التوجيه إلى صفحة الكتب
        return redirect()->route('books.show' , $book);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $title = "";
        return view('admin.books.show' , compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();

        return view('admin.books.edit' , compact(['book' ,'authors' , 'categories' , 'publishers']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
               // التحقق من المدخلات
               $request->validate([
                'title' => 'required',
                'isbn' => ['required', 'alpha_num', Rule::unique('books')->ignore($book->id)],
                'cover_image'=> ['image'],
                'category' => 'required ',
                'authors' => 'nullable',
                'publisher' => 'required',
                'description' => 'nullable',
                'publish_year' => 'nullable|numeric',
                'number_of_pages' => 'required|numeric',
                'number_of_copies' => 'required|numeric',  // تصحيح الخطأ الإملائي
                'price' => 'required|numeric'
            ]);
        
        
            $book->title = $request->title;
            $book->isbn = $request->isbn;
            $book->category_id = $request->category;
            $book->publisher_id = $request->publisher;
            $book->description = $request->description;
            $book->publisher_year = $request->publish_year; // تصحيح `publisher_year` إلى `publish_year`
            $book->number_of_pages = $request->number_of_pages;
            $book->number_of_copies = $request->number_of_copies;
            $book->price = $request->price;
        
            // معالجة وتحميل صورة الغلاف
            if ($request->hasFile('cover_image')) {
                Storage::disk('public')->delete($book->cover_image);
                $image = $request->file('cover_image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $imagePath = public_path('/images/covers');
                $image->move($imagePath, $imageName);
                $book->cover_image = '/images/covers/'.$imageName;
            }
        
            // حفظ الكتاب
            $book->save();
        
            // إضافة المؤلفين
            $book->authors()->detach();
            if ($request->authors) {
                $book->authors()->attach($request->authors);
            }
        
            // رسالة نجاح
            session()->flash('flash_message', 'تمت تعديل الكتاب بنجاح');
        
            // إعادة التوجيه إلى صفحة الكتب
            return redirect()->route('books.show' , $book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Storage::disk('public')->delete($book->cover_image);
        $book->delete();
        session()->flash('flash_message' , 'تم حذف الكتاب بنجاح');
        return redirect(route('books.index'));
    }

    public function details(Book $book){

        $findBook= 0;
        if(Auth::check()){
            $findBook = auth()->user()->ratedPurches()->where('book_id' , $book->id)->first();
        }

        $title = "عرض تفاصيل الكتاب ";
        return view('books.show' , compact(['book' , 'title' , 'findBook']));
    }

    public function rate(Request $request , Book $book){
        if(auth()->user()->rated($book)){
            $rating = Rating::where(['user_id' => auth()->id() , 'book_id' =>$book->id])->first();
            $rating->value = $request->value;
            $rating->save();
        } else{
            $rating = new Rating();
            $rating->user_id = auth()->id();
            $rating->book_id = $book->id;
            $rating->value = $request->value;
            $rating->save();
        }
        return back();
       
    }

    public function myBooks()
{
    $user = auth()->user(); // جلب المستخدم الحالي
    $myBooks = $user->purchedProduct; // استخدام العلاقة لتعريف الكتب المشتراة

    return view('books.myProduct', compact('myBooks')); // إرجاع عرض للكتب المشتراة
}

public function allProduct(){
    $allBooks = Shopping::with(['user' , 'book'])->where('bought' , true)->get();
    return view('admin.books.allProduct' , compact('allBooks'));
}



}
