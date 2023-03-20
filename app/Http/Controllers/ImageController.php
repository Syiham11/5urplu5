<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use File;
use DB;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $image = Image::when($request->q, function($image) use($request) {
            $image->where('name', 'LIKE', '%' . $request->q . '%');
        })->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $image]);
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

        DB::beginTransaction();
        try {
            $name = NULL;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $name = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/image', $name);
            }
            $image = Image::create([
                'name' => $request->name,
                'enable' => $request->enable,
                'file' => $name
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $image = Image::find($id);
        return response()->json(['status' => '200', 'message'=>'Success', 'data' => $image]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $image = Image::find($id);
            $filename = $image->file;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                File::delete(storage_path('app/public/image/' . $filename));
                $filename = $request->name . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/image', $filename);
            }

            $image->update([
                'name' => $request->name,
                'enable' => $request->enable,
            ]);
            DB::commit();
            return response()->json(['status' => '200', 'message'=>'Success', 'data' => $image]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        return response()->json(['status' => '200', 'message'=>'Success']);
    }
}
