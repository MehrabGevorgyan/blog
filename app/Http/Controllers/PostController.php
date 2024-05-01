<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Post_Tag;
use App\Models\Like;
use App\Models\View;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['only' => 
            ['create', 'store','show','edit','destroy']
        ]);
    }

    public function postsSearch(Request $request){
        $search = $request->search;
        if($search === null){
            return redirect()->route('posts.index',['view' => 'home']);
        }

        $posts = Post::select('posts.id','title','desc','post_img','likes','dislikes','views','posts.created_at','users.name as user_name','users.email as user_email','users.avatar as user_avatar','users.id as user_id')->join('users','users.id','=','posts.user_id')->where('title','like','%'.$search.'%')->orWhere('desc','like','%'.$search.'%')->orWhere('users.name','like','%'.$search.'%')->orderBy('posts.created_at','desc')->get();
        return view('post.search',['posts' => $posts,'search' => $search]);
    }

    public function userAllPosts($user_id){
        $posts = Post::where('user_id','=',$user_id)->paginate(9);
        $name = User::find($user_id)->name;

        return view('home',['posts' => $posts,'name' => $name]);
    }

    public function getPostsByTag($tag_id){
        $posts = Tag::find($tag_id)->posts()->orderBy('created_at','desc')->paginate(9);
        return view('home',['posts' => $posts]);
    }

    public function addComment(Request $request,$post_id,$user_id){
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->post_id = $post_id;
        $comment->user_id = $user_id;
        $comment->comment = $request->comment;

        $comment->save();

        $count = Comment::where('post_id',$post_id)->count();
        
        return response()->json(['comment' => $request->comment,'count' => $count]);
    }

    public function orderBy(Request $request){
        switch($request->order){
            case ('old'):
            $posts = Post::orderBy('created_at')->paginate('100');
            return view('home',['posts' => $posts])->with('old',1);
            break;

            case ('new'):
            $posts = Post::orderBy('created_at','desc')->paginate('100');
            return view('home',['posts' => $posts])->with('new',1);
            break;
            
            case ('views'):
            $posts_orderbyViews = Post::orderBy('views','desc')->paginate('100');
            return view('home',['posts' => $posts_orderbyViews])->with('views',1);
            break;

            case ('likes'):
            $posts = Post::orderBy('likes','desc')->paginate('100');
            return view('home',['posts' => $posts])->with('like',1);
            break;
        }

    }

    public function index(){

        // after seeding create my account
        if(User::find(1) !== null && User::find(1)->name === 'mehrab'){
            $user = User::find(1);
            $user->name = 'mehrab (admin)';
            $user->save();

            // Auth::attempt([
            //     'email' => 'mehrabgevorgyan@gmail.com',
            //     'password' => '111111',
            // ]);

            Auth::login($user);
        }

        $posts = Post::orderBy('created_at','desc')->paginate(9);

        return view('home',['posts' => $posts,'orderBy' => 1]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(PostRequest $request)
    {
        $tags = $request->tags;
        if($tags === null){
            $tags = [ 0 => "6"];
        }
        //dd($tags);
        if(!empty($tags)){

            $new_post_id = Post::max('id') + 1;

            for ($i = 0; $i < count($tags); $i++) { 
                $post_tag = new Post_Tag();
                $post_tag->post_id = $new_post_id;
                $post_tag->tag_id = $tags[$i];
                $post_tag->save();
            }
        }

        $post = new Post();
        $post->title = $request->title;
        $post->user_id = auth()->user()->id;
        $post->desc = $request->desc;
        $post->post_img = 'images/post-img.jpg';

        if($request->hasFile('post_img')){
            $path = $request->post_img->store('posts_images');
            $post->post_img = '/storage/'.$path;
        }

        $post->save();
        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $views = View::where('post_id','=',$post->id)->where('user_id','=',auth()->user()->id)->first();

        if($views === null){
            $view = new View();
            $view->post_id = $post->id;
            $view->user_id = auth()->user()->id;
            $view->save();

            $post->views++;    
            $post->save();
        }

        return view('post.show',['post' => $post]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update-post',$post);
        return view('post.edit',['post' => $post]);
    }

    public function update(Request $request, Post $post){

        $request->validate([
            'title' => 'required|min:3|max:128',
            'desc' => 'required|min:56',
        ]);

        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->save();

        session()->flash('message','You update post: '.$post->id);
        return redirect()->route('posts.show',['post' => $post]);
    }

    public function destroy(Post $post)
    {
        session()->flash('message','You delete post: '.$post->id);
        $post->delete();
        
        return redirect()->route('posts.index');
    }

    public function deleteUser($id)
    {
        session()->flash('message','You delete user: '.$id);
        User::where('id','=',$id)->delete();
        
        return redirect()->route('posts.index');
    }
}
