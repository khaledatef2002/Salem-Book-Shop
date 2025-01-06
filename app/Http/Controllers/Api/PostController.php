<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "content" => "required|string",
            "category" => "required|string",
            "imageUrl" => "required|url",
            "source" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
            'errors' => $validator->errors()
            ], 422);
        }
        
        $post = ApiPost::create($validator->validated());
        if($post)
        {
            return response()->json([
                'message' => 'Post added successfully',
                'post' => $post
            ], 201);
        }
    }
}
