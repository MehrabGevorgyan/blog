@extends('layout.layout')

@section('title','Create new post')
@section('content')
  <form class="form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
      <p class="not-necessary" style="margin-top: 10px;">Tags (not necessary)</p>
      <label for="sport">sport</label>
      <input name="tags[]" value="1" id="sport" type="checkbox">

      <label for="programming">programming</label>
      <input name="tags[]" value="2" id="programming" type="checkbox">

      <label for="art">art</label>
      <input name="tags[]" value="3" id="art" type="checkbox">

      <label for="gaming">gaming</label>
      <input name="tags[]" value="4" id="gaming" type="checkbox">

      <label for="other">other</label>
      <input name="tags[]" value="5" id="other" type="checkbox">
    </div>
    @error('title')
    <div class="alert-text">
      {{ $message }}
    </div>
    @enderror
    <div>
      <input value="{{ old('title')}}" class="{{ $errors->has('title') ? 'alert' : '' }}" name="title" type="text" placeholder="Post title">
    </div>

    @error('desc')
    <div class="alert-text">
      {{ $message }}
    </div>
    @enderror
    <div>
      <textarea name="desc" rows="10"  class="{{ $errors->has('title') ? 'alert' : '' }}" placeholder="Post desctiption" >{{ old('desc')}}</textarea>
    </div>


    @error('post_img')
    <div class="alert-text">
      {{ $message }}
    </div>
    @enderror
    <div>
      <p class="not-necessary" style="padding-top: 10px;">Post image (not necessary)</p>
      <input name="post_img" type="file" style="border: none;">
    </div>
    <div>
      <input type="submit" value="Create post">
    </div>
  </form>
@endsection