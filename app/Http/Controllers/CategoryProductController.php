<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = CategoryProduct::when($request->q, function($category) use($request) {
            $category->where('id', 'LIKE', '%' . $request->q . '%');
        })->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id'=>'required|numeric|min:1',
            'category_id'=>'required|numeric|min:1',
        ]);
        CategoryProduct::create([
            'product_id' => $request->product_id,
            'category_id' => $request->category_id
        ]);
        return response()->json(['status' => '200', 'message'=>'Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = CategoryProduct::find($id);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id'=>'required|numeric|min:1',
            'category_id'=>'required|numeric|min:1',
        ]);

        $category = CategoryProduct::find($id);
        $category->update([
            'product_id' => $request->product_id,
            'category_id' => $request->category_id
        ]);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = CategoryProduct::find($id);
        $category->delete();
        return response()->json(['status' => '200', 'message'=>'Success']);
    }
}
