<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use View;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['isDeleted'] = 0;
        $data['products'] = Product::orderBy('id', 'desc')->get();
        return view('admin.product.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['isEdit'] = 0;
        $data['categories'] = Category::orderBy('id', 'desc')->get();
        $data['action'] = route('products.store');
        return view('admin.product.edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->status = $request->status;
        if($product->save()) {
            $request->session()->flash('status', 'Product created successfully!');
        } else {
            $request->session()->flash('status', 'Product not created!');
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data['categories'] = Category::orderBy('id', 'desc')->get();
        $data['action'] = route('products.update',$id);
        $data['product'] = Product::find($id);
        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->status = $request->status;
        if($product->save()) {
            $request->session()->flash('status', 'Product updated successfully!');
        } else {
            $request->session()->flash('status', 'Product not updated!');  
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find( $id );
        $product ->delete();
        Session::flash('status', 'Deleted successfully!');
        return redirect()->route('products.index');
    }

    public function trashList() {
        $data = array();
        $data['products'] = Product::onlyTrashed()->get();
        $data['isDeleted'] = 1;
        return view('admin.product.list',$data);
    }

    public function restoreDeleted($id) {
        Product::withTrashed()->where('id', $id)->restore();
        Session::flash('status', 'Restored successfully!');
        return redirect()->route('products.index');
    }

    public function permanentDelete ($id) {
        Product::where('id', $id)->forceDelete();
        Session::flash('status', 'Deleted successfully!');
        return redirect()->route('products.index');
    }
}
