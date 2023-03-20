<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = Category::when($request->q, function($category) use($request) {
            $category->where('name', 'LIKE', '%' . $request->q . '%');
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
            'name' => 'required|string|max:150',
            'enable' => 'required|boolean'
        ]);
        Category::create([
            'name' => $request->name,
            'enable' => $request->enable
        ]);
        return response()->json(['status' => '200', 'message'=>'Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
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
            'name' => 'required|string|max:150',
            'enable' => 'required|boolean'
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'enable' => $request->enable
        ]);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['status' => '200', 'message'=>'Success']);
    }
}
