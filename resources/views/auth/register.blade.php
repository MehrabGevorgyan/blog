@extends('layout.layout')

@section('title','Registration')
@section('content')
  <form class="form" action="{{ route('auth.store') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @error('name')
    <div class="alert-text">
      {{ $message }}
    </div>
    @enderror
    <div class="form-group">
      <input value="{{ old('name')}}" class="{{ $errors->has('name') ? 'alert' : '' }}" name="name" type="text" placeholder="Name">
    </div>

    @error('email')
    <div class="alert-text">
      {{ $message }}
    </div>
    @enderror
    <div>
      <input value="{{ old('email')}}" class="{{ $errors->has('email') ? 'alert' : '' }}" name="email" type="email" placeholder="Email">
    </div>

    @error('password')
    <div class="alert-text">
      {{ $message }}
    </div>
    @enderror
    <div>
      <input class="{{ $errors->has('password') ? 'alert' : '' }}" name="password" type="password" placeholder="Password">
    </div>

    <div>
      <input class="{{ $errors->has('password') ? 'alert' : '' }}" name="password_confirmation" type="password" placeholder="Confirm password">
    </div>

    <div>
      <p class="not-necessary">Profile image (not necessary)</p>
      <input type="file" name="avatar">
    </div>
    <div>
      <input type="submit" value="Registration">
    <div>
      <div>
        <p>You have an account ? 
          <a href="{{ route('auth.login') }}" style="color: blue;">Log In</a>
        </p>
      </div>
  </form>
@endsection