@extends('layout.layout')

@section('title','All posts: '.$post->name)
@section('content')               
  @foreach($posts as $post)
    <div class="post">
      <div><img src="{{ asset('images/post-img.jpg')}}" alt="post img" width="400"></div>
      <div class="author">
        <span style="font-weight: bold;">Author: {{ $post->name }}</span>
      </div>
      <div>
        <h3>{{ $post->title }}</h3>
      </div>
      <div class="desc">
        <p>{{ $post->desc }}</p>
      </div>
      <div class="actions">
        <p>
          <a class="info" href="{{ route('posts.show',$post) }}">Show</a>
          <span style="float: right;">{{ $post->created_at->diffForHumans() }}
          </span>
        </p>
      </div>
    </div>
  @endforeach
@endsection