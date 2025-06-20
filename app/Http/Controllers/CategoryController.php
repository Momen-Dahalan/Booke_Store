<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $categories = Category::all();
    return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $category = new Category();
        $category->name = $request->name ;
        $category->description = $request->description;

        $category->save();

        session()->flash('flash_message' , 'تمت اضافة التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit' , compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $category->name = $request->name ;
        $category->description = $request->description;

        $category->save();

        session()->flash('flash_message' , 'تم تعديل التصنيف بنجاح');
        return redirect(route('categories.index' , $category));
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('flash_message','تم حذف التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    public function view_category(){
        $categories = Category::all()->sortBy('name');
        $title = 'التصنيفات';
        return view('categories.index' , compact(['categories' , 'title']));
     }
 

    public function show_category(Category $category){
            $books = $category->books()->Paginate(12);
            $title = 'الكتب التابعة لتصنيف :'.$category->name;
            return view('gallery' , compact(['books' , 'title']));
    }

    public function search(Request $request)
    {
        $term = $request->input('term');
        $categories = Category::where('name', 'LIKE', '%' . $term . '%')->get();
        $title = 'نتائج البحث عن: ' . $term;
    
        return view('categories.index', compact('categories', 'title'));
    }
 
   
}
