<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index(){
        $posts=Post::get();
        return view("pages.index",compact("posts"));
    }
    public function create(){
        return view("pages.create");
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'tags' => 'required|array',
            'category' => 'required|string',
            "status"=>"required|string",
            "featured_image"=>"required|image"
        ]);
        //featured_image processing
        if($request->hasFile("featured_image")){
            $image=$request->file("featured_image");
            $image_name="post_img_".md5(uniqid())."_".time().".".$image->getClientOriginalExtension();
            //image store in public folder
            $imageToStore=$image->move(public_path("uploads/posts"),$image_name);
        }

        Post::create([
            "title"=>$request->title,
            "description"=>$request->description,
            "category"=>$request->category,
            "featured_image"=>"uploads/posts/".$image_name,
            "status"=>$request->status,
            "tags"=>$request->tags
        ]); 

        return redirect()->back()->with("success","Post Created Successfully");
    }


    public function show($id){
        $post=Post::findOrFail($id);
        return view("pages.show",compact("post"));
    }

    public function destroy($id){
        $post=Post::findOrFail($id);
        $removed_file=unlink(public_path($post->featured_image));
        $post->delete();
        return redirect()->back()->with("success","Post Deleted Successfully");
    }

    public function edit($id){
        $post=Post::findOrFail($id);
        return view("pages.edit",compact("post"));
    }

    public function update(Request $request,$id){
        $request->validate([
            'title' => 'required',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'tags' => 'nullable|array',
            'status' => 'required|string',
            'featured_image' => 'nullable|image',
        ]);

        if($request->hasFile('featured_image')){
            // remove existing image if new image is uploaded
            $post=Post::findOrFail($id);
            $removed_file=unlink(public_path($post->featured_image));
            $image = $request->file('featured_image');
            $fileNameToStore = 'post_image_'.md5((uniqid()))."_".time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $fileNameToStore);
        }
        $post=Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'tags' => $request->tags,
            'status' => $request->status,
            'featured_image'=>$request->hasFile('featured_image') ? "/uploads/posts/".$fileNameToStore : $post->featured_image
        ]);
        return redirect()->back()->with('success', 'Post updated Successfully');    
    }
}
