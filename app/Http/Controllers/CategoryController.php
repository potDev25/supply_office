<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Category::orderBy('created_at', 'ASC')->paginate($request->limit);
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $payload = $request->validated();

        DB::transaction(function () use($payload) {
            Category::create($payload);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $id)
    {
        return response($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $id)
    {
        $payload = $request->validated();
        DB::transaction(function () use($payload, $id){
            $id->update($payload);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
