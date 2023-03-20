<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = Product::when($request->q, function($product) use($request) {
            $product->where('name', 'LIKE', '%' . $request->q . '%');
        })->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $product]);
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
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:500',
            'enable' => 'required|boolean'
        ]);
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'enable' => $request->enable
        ]);
        return response()->json(['status' => '200', 'message'=>'Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:150',
            'description' => 'required|string|max:500',
            'enable' => 'required|boolean'
        ]);

        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'enable' => $request->enable
        ]);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['status' => '200', 'message'=>'Success']);
    }
}
