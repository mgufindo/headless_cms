<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('categories')->paginate(10);
        return ApiResponse::success($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $post = Post::create($data);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return ApiResponse::success($post, 'Post created successfully', 201);
    }

    public function show($id)
    {
        $post = Post::with('categories')->find($id);

        if (!$post) {
            return ApiResponse::error('Post not found', 404);
        }

        return ApiResponse::success($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return ApiResponse::error('Post not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'sometimes|in:draft,published',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation Error', 422, $validator->errors());
        }

        $data = $request->all();
        if ($request->has('title')) {
            $data['slug'] = Str::slug($request->title);
        }

        $post->update($data);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return ApiResponse::success($post, 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return ApiResponse::error('Post not found', 404);
        }

        $post->delete();

        return ApiResponse::success(null, 'Post deleted successfully');
    }
}
