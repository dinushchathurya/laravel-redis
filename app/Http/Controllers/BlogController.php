<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    /* get single blog */
    public function index($id)
    {
        $cachedBlog = Redis::get('blog_' . $id);

        if(isset($cachedBlog)) {
            
            $blog = json_decode($cachedBlog, FALSE);

            return response()->json([
                'status_code' => 200,
                'message' => 'Fetched from redis',
                'data' => $blog,
            ]);

        }else {

            $blog = Blog::find($id);
            Redis::set('blog_' . $id, $blog);

            return response()->json([
                'status_code' => 200,
                'message' => 'Fetched from database',
                'data' => $blog,
            ]);
        }
    }

    /* update blog */
    public function update(Request $request, $id) {

        $update = Blog::findOrFail($id)->update($request->all());
        if($update) {

            // Delete blog_$id from Redis
            Redis::del('blog_' . $id);

            $blog = Blog::find($id);
            // Set a new key with the blog id

            Redis::set('blog_' . $id, $blog);

            return response()->json([
                'status_code' => 200,
                'message' => 'Blog updated',
                'data' => $blog,
            ]);
        }

    }

    /* delete blog */
    public function delete($id) {

        Blog::findOrFail($id)->delete();
        Redis::del('blog_' . $id);

        return response()->json([
            'status_code' => 200,
            'message' => 'Blog deleted'
        ]);
    }
}
