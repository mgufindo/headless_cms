<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return ApiResponse::success($categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $category = Category::create($data);

        return ApiResponse::success($category, 'Category created successfully', 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error('Category not found', 404);
        }

        return ApiResponse::success($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error('Category not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $id
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->all();
        if ($request->has('name')) {
            $data['slug'] = Str::slug($request->name);
        }

        $category->update($data);

        return ApiResponse::success($category, 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiResponse::error('Category not found', 404);
        }

        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}
