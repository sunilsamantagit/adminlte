<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use View;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $data = array();
        $data['categories'] = Category::orderBy('id', 'desc')->get();
        $data['isDeleted'] = 0;
        return view('admin.category.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['isEdit'] = 0;
        $data['action'] = route('categories.store');
        return view('admin.category.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    { 
        $category = new Category;
        $category->name = $request->name;
        $category->display_in_menu = $request->display_in_menu;
        $category->status = $request->status;
        if($category->save()) {
            $request->session()->flash('status', 'Category created successfully!');
        } else {
            $request->session()->flash('status', 'Category not created!');
        }
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['isDeleted'] = 0;
        $data['products'] = Product::where('category_id',$id)->get();
        return view('admin.product.list',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['isEdit']=1;
        $data['action'] = route('categories.update',$id);
        $data['category'] = Category::find($id);
        return view('admin.category.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {  
        $category = Category::find($id);
        $category->name = $request->name;
        $category->display_in_menu = $request->display_in_menu;
        $category->status = $request->status;
        if($category->save()) {
            $request->session()->flash('status', 'Category updated successfully!');
        } else {
            $request->session()->flash('status', 'Category not updated!');  
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find( $id );
        $category ->delete();
        Session::flash('status', 'Deleted successfully!');
        return redirect()->route('categories.index');
    }

    public function trashList() {
        $data = array();
        $data['categories'] = Category::onlyTrashed()->get();
        $data['isDeleted'] = 1;
        return view('admin.category.list',$data);
    }

    public function restoreDeleted($id) {
        $category = Category::withTrashed()->find( $id );
        $category->restore();
        Session::flash('status', 'Restored successfully!');
        return redirect()->route('categories.index');
    }

    public function PermanentDelete ($id) {
        Category::where('id', $id)->forceDelete();
        Session::flash('status', 'Deleted successfully!');
        return redirect()->route('categories.index');
    }
}
