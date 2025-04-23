<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::all();
        return view('admin.publishers.index', compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publishers.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $publisher = new Publisher();
        $publisher->name = $request->name ;
        $publisher->address = $request->address;

        $publisher->save();

        session()->flash('flash_message' , 'تمت اضافة الناشر بنجاح');
        return redirect(route('publishers.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit' , compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $publisher->name = $request->name ;
        $publisher->address = $request->address;

        $publisher->save();

        session()->flash('flash_message' , 'تم تعديل الناشر بنجاح');
        return redirect(route('publishers.index' , $publisher));
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        session()->flash('flash_message','تم حذف الناشر بنجاح');
        return redirect(route('publishers.index'));
    }


    public function view_publisher(){
        $publishers = Publisher::all()->sortBy('name');
        $title = "الناشرين";
        return view('publishers.index' , compact(['publishers' , 'title']));
    }

    public function show_publisher(Publisher $publisher){
        $books = $publisher->books()->Paginate(12);
        $title= 'الكتب التابعة للناشر :'.$publisher->name;
        return view('gallery' , compact(['books' , 'title']));
    }


    public function search(Request $request){
        $term = $request->input('term');
        $publishers = Publisher::where('name', 'LIKE', '%' . $term . '%')->get();
        $title = 'نتائج البحث عن: ' . $term;
    
        return view('publishers.index', compact('publishers', 'title'));
    }
    

}
