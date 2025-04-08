<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        return response()->json([
          'posts'=>Post::all()
        ]);
    }
    public function store(CreatePostRequest $request) {
        try {
            $post = Post::create([
                'title' => $request->title ,
                'content' =>$request->content ,
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'post'=>$post ,
                'message'=>'post created'
            ],201);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create post',
                'error' => $e->getMessage(),

            ],500);
        }

    }

    public function update(CreatePostRequest $request , $id ) {
        $post = Post::findOrFail($id) ;
        try {
            if ($post->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'You are not authorized to update this post.'
                ], 403);
            }
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
            return response()->json([
                'post' => $post,
                'message' => 'Post updated successfully',
            ], 200);


        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create post',
                'error' => $e->getMessage(),

            ],500);
        }

    }

    public function delete($id)
    {
        $post = Post::findOrFail($id) ;
        $post->where('user_id',Auth::id())->delete();
        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
