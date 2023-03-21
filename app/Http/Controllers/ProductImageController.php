<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productimage = ProductImage::when($request->q, function($productimage) use($request) {
            $productimage->where('id', 'LIKE', '%' . $request->q . '%');
        })->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $productimage]);
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
            'image_id'=>'required|numeric|min:1',
        ]);
        ProductImage::create([
            'product_id' => $request->product_id,
            'image_id' => $request->image_id
        ]);
        return response()->json(['status' => '200', 'message'=>'Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $productimage = ProductImage::find($id);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $productimage]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $productimage)
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
            'image_id'=>'required|numeric|min:1',
        ]);

        $productimage = ProductImage::find($id);
        $productimage->update([
            'product_id' => $request->product_id,
            'image_id' => $request->image_id
        ]);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $productimage]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productimage = ProductImage::find($id);
        $productimage->delete();
        return response()->json(['status' => '200', 'message'=>'Success']);
    }
}
