<?php

namespace App\Http\Controllers;

use App\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|min:5',
            'title' => 'required'
        ]);

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'content' => $request->content,
            'title' => $request->title,
        ]);

        $response = fractal()
            ->item($post)
            ->transformWith(new PostTransformer)
            ->toArray();

        return response()->json($response, 201);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $response = fractal()->item($post)->transformWith(new PostTransformer)->toArray();

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $this->authorize('update', $post);

        $this->validate($request,[
            'content' => 'min:5'
        ]);

        $post->content = $request->get('content', $post->content);
        $post->title = $request->get('title', $post->title);

        $post->save();


        $response = fractal()->item($post)->transformWith(new PostTransformer)->toArray();

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post Deleted'
        ]);
        //

    }
}
