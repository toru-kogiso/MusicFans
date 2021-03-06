<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\Post;
use App\User;
use App\Profile;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function user_index(Request $request)
    {
        $user = Auth::user();//userデータ取得
        
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(9);
        
        return view ('user.user_index',['user' => $user, 'posts' => $posts]);
    }
    
    public function edit() {
        $user = Auth::user();
        
        return view('user.edit',['user' => $user]);
    }
    
    public function update(Request $request) {

        $user_form = $request->all();
        $user = Auth::user();
        //不要な「_token」の削除
        unset($user_form['_token']);
        //保存
        $user->fill($user_form)->save();
        
        return redirect('user');
    }
    
    public function show($id) {
        $user = User::find($id);
        
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(9);
        
        return view('user.show', ['user' => $user, 'posts' => $posts]);
    }
}