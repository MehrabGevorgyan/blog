@extends('layout.layout')

@section('title','Log In')
@section('content')
  <form class="form" action="{{ route('auth.login') }}" method="POST">

    <div>{{ $errors->first('message') }}</div>
    @csrf

    @error('email')
      <div class="alert-text">
        {{ $message }}
      </div>
    @enderror
    <div class="form-group">
      <input value="{{ old('email') }}" class="{{ $errors->has('email') ? 'alert' : '' }}" name="email" type="email" class="form-control mb-2" placeholder="Email">
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
      <input type="checkbox" name="remember" id="flexCheckChecked" checked>
      <label class="form-check-label" for="flexCheckChecked">Remamber me</label>
    </div>

    <div>
      <input type="submit" value="Log In">
    <div>

    <div>
      <p>You haven't account ? 
        <a href="{{ route('auth.register') }}" style="color: blue;">Registeration</a>
      </p>
    </div>
  </form>
@endsection