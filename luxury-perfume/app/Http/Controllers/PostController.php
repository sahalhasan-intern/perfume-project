<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        return Post::all();
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $fields= $request->validate([
            'title'=>'required|max:255',  //
            'body'=>'required'
        ]);

       $post = post::create($fields);
        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        $fields= $request->validate([
            'title'=>'required|max:255',  //
            'body'=>'required'
        
        ]);
    $post->update($fields);
    return $post;
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        $post->delete();
        return['messeage' => 'the post was deleted'];
    }
}
