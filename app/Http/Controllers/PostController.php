<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/images/';
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        $all_posts = $this->post->latest()->simplePaginate(5);
        return view('posts.index')->with('all_posts', $all_posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        # 1. Validate the request
        $request->validate([
            'title' => 'required | max:50',
            'body' => 'required | max:1000',
            'image' => 'required | mimes:jpeg,jpg,png,gif | max:1048'
        ]);
        # mime - multipurpose internet extensions

        # 2. Save the form data to the database
        $this->post->user_id = Auth::user()->id;
        // OWNER OF THE POST = ID OF THE LOGGED IN USER
        $this->post->title = $request->title;
        $this->post->body = $request->body;
        $this->post->image = $this->saveImage($request);
        $this->post->save();
        
        # 3. return to homepage
        return redirect()->route('index');
    }

    private function saveImage($request)
    {
        // change the name of the image to CURRENT TIME ti avoid overlapping
        $image_name = time() . "." . $request->image->extension();
        // save the image inside storage/app/public/images
        $request->image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);
        return view('posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        if($post->user->id != Auth::user()->id) {
            return redirect()->route('index');
        }
        
        return view('posts.edit')->with('post', $post);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required | max:50',
            'body' => 'required | max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif | max:1048'
        ]);

        $post = $this->post->findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;

        if($request->image) {
            # delete the previous image from the storage/images
            $this->deleteImage($post->image);

            # move the new image to local storage
            $post->image = $this->saveImage($request);
        }

        $post->save();

        return redirect()->route('post.show', $post->id);
    }

    private function deleteImage($image_name)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image_name;

        if(Storage::disk('local')->exists($image_path)) {
            Storage::disk('local')->delete($image_path);
        }
    }

    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $this->post->destroy($id);
        $this->deleteImage($post->image);

        return redirect()->back();
    }
}
