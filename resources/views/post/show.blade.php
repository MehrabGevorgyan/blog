@extends('layout.layout')

@section('title','Post: '.$post->id)
@section('content')
  <p class="message">{{ session('message') }}</p>
  <div class="show flex-center" style="flex-direction: column;">
    <div class="post flex-center">
      <div style="height: 25px;">
        @foreach($post->tags as $tag)
          <a class="tag" href="{{ route('posts.tag',$tag->id) }}">{{ $tag->name }}</a>
        @endforeach
      </div>
      <div>
        <img id="img-show" src="{{ isset($post->post_img) ? asset($post->post_img) : asset('images/post-img.jpg') }}" alt="post img" width="100%">
        <script>
          $('#img-show').hover(function(){
            $('#img-show').css({'cursor':'zoom-in'});
          });
          $('#img-show').click(function(){
            $('#img-show').css({'transform':'scale(1.3)','transition':'0.5s','cursor':'default'});
          });
          $('#img-show').mouseout(function(){
            $('#img-show').css({'transform':'scale(1)','transition':'0.5s'});
          });
        </script>
      </div>
      <div class="author flex-center">
        <span class="avatar" 
          style="background: url('{{ asset($post->user->avatar) }}')";>
        </span>
        <a href="{{ route('user.allposts',$post->user->id) }}">{{ $post->user->name }}</a>
      </div>
      <div>
        <h3 style="overflow: hidden;">{{ $post->title }}</h3>
      </div>
      <div class="desc">
        <p style="line-height: 25px;">{!! nl2br(e($post->desc)) !!}</p>
      </div>

      <div class="actions" style="width: 100%;display: flex;justify-content: space-between;">
        <div class="flex-center" style="justify-content: flex-start;">
          <form action="{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/like') }}" method="POST" class="flex-center formlike">
            @csrf
            <input class="hiddenlike" type="hidden">

            <input type="submit" value='' class="like">
            <span class="count count-like">{{$post->likes}}</span>
          </form>

          <form action="{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/dislike') }}" method="POST" class="flex-center formdislike">
            @csrf
            <input class="hiddendislike" type="hidden">

            <input type="submit" value='' class="dislike">
            <span class="count count-dislike">{{$post->dislikes}}</span>
          </form>
          <div class="flex-center">
            <span class="comments"></span>
            <span class="count count-show-views">{{ count($post->comments) }}</span>
            <span class="views"></span>
            <span class="count">{{ $post->views }}</span>
          </div>
          <script type="text/javascript">
            $(document).ready(function(){
                $(".formlike").on('submit',function(event){

                    event.preventDefault();

                    $.ajax({
                      url:"{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/like') }}",
                      data:$(".formlike").serialize(),
                      type:'post',

                      success: function(result){
                        $(".count-like").html(result.likes);
                        $(".formlike")[0].reset();
                      }

                    });
                });
            });

            $(document).ready(function(){
                $(".formdislike").on('submit',function(event){

                    event.preventDefault();

                    $.ajax({
                      url:"{{ url('posts/'.$post->id.'/'.(auth()->user()->id).'/dislike') }}",
                      data:$(".formdislike").serialize(),
                      type:'post',

                      success: function(result){
                        $(".count-dislike").html(result.dislikes);
                        $(".formdislike")[0].reset();
                      }
                      
                    });
                });
            });
          </script> 
        </div>
        <form action="{{ route('posts.destroy',$post) }}" method="POST">
          @csrf
          @method('DELETE')

          @canany(['update-post','delete-post'],$post)
            <a class="info warning" href="{{ route('posts.edit',$post) }}" style="color: black;display: ;">Edit</a>

            <input class="danger" type="submit" value="Delete" style="padding: 10px 15px;border-radius: 3px;font-size: 16px;background: #DC3545FF;"onclick="if(confirm('Delete post?')){return true;}else{return false;}">
          @endcan
        </form>
      </div>

    </div>
    <ul>
      <div>
        <p style="margin-top: 20px;">What do you think? Write your opinion about this post!</p>
        <p  style="font-weight: bold;color: green;margin-left: 200px;margin-top: 20px;"></p>

        <form id="addComment" action="{{ url('posts/'.$post->id.'/'.auth()->user()->id.'/addComment') }}" method="POST" class="flex-center" style="align-items: flex-start;margin-bottom: 100px; margin-top: 20px;">
          @csrf
          <span class="avatar" 
            style="background: url('{{ asset(auth()->user()->avatar) }}');margin-right: 10px;">
          <input type="submit" style="position: relative;bottom: -80px; padding: 10px 15px;border-radius: 5px;" value="Leave a comment" id="addComment-submit">
          </span>
          <textarea id="comment-textarea" name="comment"cols="30" rows="5" resize placeholder="Comment..." style="margin: 0;width: 600px;"></textarea>
        </form>

      </div>
      <p class="count-comments" style="margin-bottom: 20px;font-weight: bold;">
        {{ count($post->comments).' comments' }}
      </p>
        <script>
          $(document).ready(function(){
              $("#addComment").on('submit',function(event){

                  event.preventDefault();

                  $.ajax({
                    url: "{{ url('posts/'.$post->id.'/'.auth()->user()->id.'/addComment') }}",
                    data: $("#addComment").serialize(),

                    type: 'post',

                    success: function(result){
                      var date = new Date();
                      var newCommentClass = date.getSeconds() + '-'+ date.getHours();
                      date = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
                      $('.comments-show').prepend("<li  class='comment-wrapper' style='background: #ccc;padding: 20px;border:1px solid #999;'><div class='flex-center'><div class='flex-center'><span class='avatar' style='background: url({{ asset(auth()->user()->avatar) }});margin-right: 10px;'></span><span style='margin-right: 10px;font-weight: bold;'><a href='{{ route('user.allposts',auth()->user()->id) }}' style='color: blue;'>{{ auth()->user()->name }}</span></a><span class='comment-date '"+newCommentClass+"></span></div></div><p class=" + 'comment-text' + newCommentClass + " style='margin-top: 10px;'></p></li>");
                      $(".comment-text" + newCommentClass).html(result.comment.replace(/\n/g, '<br/>'));
                      $(".count-show-views").html(result.count);
                      $(".comment-date").attr('id',newCommentClass);
                      $('#' + newCommentClass).html(date);
                      $(".count-comments").html(result.count + ' comments');
                        $('html, body').animate({
                          scrollTop: $(".count-comments").offset().top
                        }, 800);
                      $('#comment-textarea').val('');
                      $(".addComment-submit")[0].reset();
                    }
                  });
              });
          });
        </script> 
      <ul class="comments-show">
        @foreach($post->comments as $comment)
          <li style="background: #EDE;padding: 20px;">
            <div class="flex-center">
              <div class="flex-center">              
                <span class="avatar" 
                  style="background: url('{{ asset($comment->user->avatar) }}');margin-right: 10px;">
                </span>
                <span style="margin-right: 10px;font-weight: bold;">
                  <a href="{{ route('user.allposts',$comment->user->id) }}" style="color: blue;">
                    {{ $comment->user->name }}</span>
                  </a>
                <span>{{ $comment->created_at }}</span>
              </div>
            </div>
              <p style="margin-top: 10px;">
                {!! nl2br(e($comment->comment)) !!}
              </p>
          </li>
        @endforeach
      </ul>
    </ul>
  </div>
@endsection