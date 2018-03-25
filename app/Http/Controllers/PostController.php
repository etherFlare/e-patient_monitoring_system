<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return IlluminateHttpResponse
     */

    public function home(){
      return view('post.index');
    }

    public function index(Request $request)
    {
 
        $post = Post::where(function($query) use($request) {

            if($request->has('search')){
                $search = trim($request->get('search')); 
                $query->where('title', 'LIKE', '%'. $search .'%')->orWhere('body', 'LIKE', '%'. $search .'%');
            }

        })
        ->orderBy('created_at', 'desc')
        ->paginate($request->get('per_page', 10));

        return $post;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return IlluminateHttpResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IlluminateHttpRequest  $request
     * @return IlluminateHttpResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'title' => 'required',
          'body' => 'required',
        ]);

        $create = Post::create($request->all());
        return response()->json(['status' => 'success','msg'=>'post created successfully']);

    }
    public function get_store(Request $request)
    {
        $this->validate($request, [
          'title' => 'required',
          'body' => 'required',
        ]);

        $create = Post::create($request->all());
        return response()->json(['status' => 'success','msg'=>'post created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return IlluminateHttpResponse
     */
    public function show($id)
    {
        return Post::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return IlluminateHttpResponse
     */
    public function edit($id)
    {
        return Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IlluminateHttpRequest  $request
     * @param  int  $id
     * @return IlluminateHttpResponse
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
      ]);

      $post = Post::find($id);
      if($post->count()){
        $post->update($request->all());
        return response()->json(['statur'=>'success','msg'=>'Post updated successfully']);
      } else {
        return response()->json(['statur'=>'error','msg'=>'error in updating post']);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return IlluminateHttpResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->count()){
          $post->delete();
          return response()->json(['statur'=>'success','msg'=>'Post deleted successfully']);
        } else {
          return response()->json(['statur'=>'error','msg'=>'error in deleting post']);
        }
    }
}