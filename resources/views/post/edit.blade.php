@extends('layout.layout')

@section('title','Edit post '.$post->id)
@section('content')
  <form class="form" action="{{ route('posts.update',$post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @error('title')
      <div class="alert-text">
        {{ $message }}
      </div>
    @enderror
      <div>
        <input value="{{ $post->title }}" class="{{ $errors->has('title') ? 'alert' : '' }}" name="title" type="text" placeholder="Post title">
      </div>
    @error('desc')
      <div class="alert-text">
        {{ $message }}
      </div>
    @enderror
    <div>
      <textarea name="desc" rows="10"  class="{{ $errors->has('desc') ? 'alert' : '' }}" placeholder="Post desctiption">
        {{ $post->desc }}
      </textarea>
    </div>
    <div>
      <input type="submit" value="Edit post">
    </div>
  </form>
@endsection