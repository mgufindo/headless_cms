<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::paginate(10);
        return ApiResponse::success($pages);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $page = Page::create($data);

        return ApiResponse::success($page, 'Page created successfully', 201);
    }

    public function show($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return ApiResponse::error('Page not found', 404);
        }

        return ApiResponse::success($page);
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return ApiResponse::error('Page not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
            'status' => 'sometimes|in:0,1'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->all();
        if ($request->has('title')) {
            $data['slug'] = Str::slug($request->title);
        }

        $page->update($data);

        return ApiResponse::success($page, 'Page updated successfully');
    }

    public function destroy($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return ApiResponse::error('Page not found', 404);
        }

        $page->delete();

        return ApiResponse::success(null, 'Page deleted successfully');
    }
}
