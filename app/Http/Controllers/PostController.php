<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\Http\Requests;
use App\Post;
use App\User;
use InterventionImage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['post_index']);
    }
    
    
    public function add()
    {
        return view('post.create');
    }
    
    
    public function create(Request $request)
    {
      $this->validate($request, Post::$rules);
      
      $posts = new Post;
      //ユーザー情報取得
      $user = \Auth::user();
     
      $form = $request->all();
      // formに画像があれば、保存する
        if (isset($form['image'])) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalname();
            //画像をリサイズ
            $image = InterventionImage::make($image)
	        ->resize(300, 300, function ($constraint) {
	            $constraint->aspectRatio();
	        })
	        ->save(public_path() . '/storage/image/' . $filename);
	        $posts->image_path = basename($filename);

      } else {
         $posts->image_path = null;
      }
      
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);
      
      $posts->user_id = $user->id;
      $posts->user_name = $user->user_name;
     
      // データベースに保存する
      $posts->fill($form);
      $posts->save();
      
     return redirect('post');
    }


    public function post_index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            $posts= Post::where('title', $cond_title)->get();
        } else {
            $posts = Post::all();
        }
        
        
         //更新順に並び替え
        $posts = Post::all()->sortByDesc('created_at');
        
        return view('post.post_index', ['posts' => $posts, 'cond_title' => $cond_title,]);
    }
    
    
    public function edit(Request $request)
    {
        $posts = Post::find($request->id);
        if (empty($posts)) {
            about(404);
        }
        return view('post.edit',['posts_form' => $posts]);
    }
    
    
    public function update(Request $request)
    {
        $this->validate($request, Post::$rules);
        
        $posts = Post::find($request->id);
        
        $posts_form = $request->all();
        if ($request->remove == 'true') {
          $posts_form['image_path'] = null;
          
      } elseif ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalname();
            //画像をリサイズ
            $image = InterventionImage::make($image)
	        ->resize(300, 300, function ($constraint) {
	            $constraint->aspectRatio();
	        })
	        ->save(public_path() . '/storage/image/' . $filename);
	        $posts->image_path = basename($filename);
          
      } else {
          $posts_form['image_path'] = $posts->image_path;
      }
        
        unset($posts_form['image']);
        unset($posts_form['remove']);
        unset($posts_form['_token']);
    
        $posts->fill($posts_form)->save();
    
        return redirect('post');
    }
    
    public function delete(Request $request)
    {
        $posts = Post::find($request->id);
        
        $posts->delete();
        
        return redirect('post');
    }
    
    public function show($id)
    {   
        $authUser = Auth::user(); //認証ユーザー取得
        $post = Post::findOrFail($id);
        
        $like = $post->likes()->where('user_id', Auth::user()->id)->first();

        return view('post.show', ['post' => $post, 'authUser' => $authUser, 'like' => $like]);
    }
}
