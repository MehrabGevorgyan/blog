@extends('layout.layout')

@section('title')
    {{'On request "'.$search.'" found '.$posts->count().' posts' }}
@endsection

@section('content')
  <main>
    @isset($posts)
      @foreach($posts as $post)
        <div class="post flex-center {{ $post->id === 1 ? 'admin-post' : '' }}">
          <div style="max-width: 420px;">
            <div class="author flex-center">
              <div class="flex-center">
                <span class="avatar" style="background: url('{{ asset($post->user_avatar) }}');"></span>
                <a href="{{ route('user.allposts',$post->user_id) }}">
                  <span>{{ $post->user_name }}</span>
                </a> 
              </div>
              <span style="font-style: italic;">{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <div class="tags">
              @foreach($post->tags as $tag)
                <a class="tag" href="{{ route('posts.tag',$tag->id) }}">{{ $tag->name }}</a>
              @endforeach
            </div>
            <div>
              <img style="width: 100%;" src="{{ asset($post->post_img) }}" height="225">
            </div>
            <div>
              <h3 class="flex-center">{{ $post->title }}</h3>
            </div>
            <div class="desc">
              <p style="line-height: 25px; margin:5px 0 15px 0;">
                @php
                  if(mb_strlen($post->desc) > 300)
                      $post->desc = substr($post->desc,0,300);
                    echo htmlentities($post->desc.' ...');
                @endphp
              </p>
            </div>
            <div class="flex-center" style="border: 1px solid #c88;border-left: none;border-right: none;">
            <div class="flex-center">
              <form action="{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/like') }}" method="POST" class="flex-center formlike{{$post->id}}">

                @csrf
                <input class="hiddenlike{{$post->id}}" type="hidden">

                <input type="submit" value='' class="like like{{$post->id}}">
                <span class="count like{{$post->id}}">{{$post->likes}}</span>
              </form>

              <form action="{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/dislike') }}" method="POST" class="flex-center formdislike{{$post->id}}">

                @csrf
                <input class="hiddendislike{{$post->id}}" type="hidden">

                <input type="submit" value='' class="dislike dislike{{$post->id}}">
                <span class="count dislike{{$post->id}}">{{$post->dislikes}}</span>
              </form>
            </div>
            <script type="text/javascript">
              $(document).ready(function(){
                  $(".formlike{{$post->id}}").on('submit',function(event){

                      event.preventDefault();

                      $.ajax({
                        url:"{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/like') }}",
                        data:$(".formlike{{$post->id}}").serialize(),
                        type:'post',

                        success: function(result){
                          $(".like{{$post->id}}").html(result.likes);
                          $(".formlike{{$post->id}}")[0].reset();
                        }
                      });
                  });
              });

              $(document).ready(function(){
                  $(".formdislike{{$post->id}}").on('submit',function(event){

                      event.preventDefault();

                      $.ajax({
                        url:"{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/dislike') }}",
                        data:$(".formdislike{{$post->id}}").serialize(),
                        type:'post',

                        success: function(result){
                          $(".dislike{{$post->id}}").html(result.dislikes);
                          $(".formdislike{{$post->id}}")[0].reset();
                        }
                      });
                  });
              });
            </script> 
            <div class="flex-center">
              <span class="comments"></span>
              <span class="count">{{ count($post->comments) }}</span>
              <span class="views"></span>
              <span class="count">{{ $post->views }}</span>
            </div>
          </div>
          </div>
          <div class="actions">
            <form action="{{ route('posts.destroy',$post) }}" method="POST">
              @csrf
              @method('DELETE')
              <a class="info" href="{{ route('posts.show',$post) }}">Show</a>
              @can('update-post',$post)
              <a class="info warning" href="{{ route('posts.edit',$post) }}" style="color: black;">Edit</a>
              @endcan

              @can('delete-post',$post)
              <input class="danger" type="submit" value="Delete" style="padding: 10px 15px;border-radius: 3px;font-size: 16px;background: #DC3545FF;"onclick="if(confirm('Delete post?')){return true;}else{return false;}">
              @endcan
            </form>
          </div>
        </div>
      @endforeach
    @endisset
  </main>
@endsection