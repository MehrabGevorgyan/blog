<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    protected $model = 'like'; 

    public function addLike(Request $request,$post_id,$user_id){
        $like = Like::where('post_id','=',$post_id)->where('user_id','=',$user_id)->first();
        if($like === null || ($like->like === 0 && $like->dislike === 0)){
            $like = new Like();
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->like= 1;
            $like->save();
        //dd($like);

            $post = Post::find($post_id);
            $post->likes++;
            $post->save();   

            return response()->json(['likes' => $post->likes]);
        }
        if($like->like !== 1){
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->like= 1;
            $like->save();

            $post = Post::find($post_id);
            $post->likes++;
            $post->save();   

            return response()->json(['likes' => $post->likes]);
        }
        if($like->like === 0 && $like->dislike === 1){
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->like= 1;
            $like->save();

            $post = Post::find($post_id);
            $post->likes++;
            $post->save();   

            return response()->json(['likes' => $post->likes]);
        }
    }

    public function addDisLike(Request $request,$post_id,$user_id){
        $dislike = Like::where('post_id','=',$post_id)->where('user_id','=',$user_id)->first();
        
        if($dislike === null || ($dislike->dislike === 0 && $dislike->like === 0)){
            $dislike = new Like();
            $dislike->post_id = $post_id;
            $dislike->user_id = $user_id;
            $dislike->dislike= 1;
            $dislike->save();

            $post = Post::find($post_id);
            $post->dislikes++;
            $post->save();
            
            return response()->json(['dislikes' => $post->dislikes]);
        }
        if($dislike->dislike !== 1){
            $dislike->post_id = $post_id;
            $dislike->user_id = $user_id;
            $dislike->dislike= 1;
            $dislike->save();

            $post = Post::find($post_id);
            $post->dislikes++;
            $post->save();

            return response()->json(['dislikes' => $post->dislikes]);
        }
    }
}
