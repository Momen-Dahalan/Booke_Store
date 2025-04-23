<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $author = new Author();
        $author->name = $request->name ;
        $author->description = $request->description;

        $author->save();

        session()->flash('flash_message' , 'تمت اضافة المؤلف بنجاح');
        return redirect(route('authors.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit' , compact('author'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $author->name = $request->name ;
        $author->description = $request->description;

        $author->save();

        session()->flash('flash_message' , 'تم تعديل المؤلف بنجاح');
        return redirect(route('authors.index' , $author));    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        session()->flash('flash_message','تم حذف المؤلف بنجاح');
        return redirect(route('authors.index'));    }


    public function view_authors(){
        $authors = Author::all()->sortBy('name');
        $title = "المؤلفين";
        return view('authors.index' , compact(['authors' , 'title']));
    }


    public function show_authors(Author $author){
        $books = $author->books()->Paginate(12);
        $title= 'الكتب التابعة للمؤلف :'.$author->name;
        return view('gallery' , compact(['books' , 'title']));
    }


    public function search(Request $request){
        $term = $request->input('term');
        $authors = Author::where('name', 'LIKE', '%' . $term . '%')->get();
        $title = 'نتائج البحث عن: ' . $term;
    
        return view('authors.index', compact('authors', 'title'));
    }

}
