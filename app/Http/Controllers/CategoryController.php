<?php

namespace App\Http\Controllers;

use App\Http\Resources\Extras\CategoryCollection;
use App\Models\Extras\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Extras\Category as CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\
     * @return Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all() ,[
            "name" => "required|string|max:255"
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        $category = Category::create([
            "name" => $request->name
        ]);

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $validation = Validator::make($request->all() ,[
            "name" => "required|string|max:255"
        ]);

        if ($validation->fails()) {
            return response(["errors" => $validation->errors()], 422);
        }

        $category->update([
            "name" => $request->name
        ]);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response("Delete Successfully!", 200);
    }
}
