<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <script src="{{ asset('scripts/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('scripts/main.js') }}"></script>
</head>

<body>
  <header class="flex-center">
      <p class="flex-center">
        <a class="logo" href="{{ route('posts.index') }}" title="All posts"></a>
      @auth
        <a id="create" class="create" href="{{ route('posts.create') }}">Create new post</a>
      @endauth
      </p>
        <div class="ararat"></div>
      @auth
        <div class="flex-center">
          <img class="search-post" src="{{ asset('images/search-icon.png') }}" alt="search icon" width="50px" style="margin-right: 20px;">
              <span class="author">
                  <span id="avatar" 
                    style="background: url('{{ asset(auth()->user()->avatar) }}');border-radius: 50%;">
                  </span>
              </span>
          <ul class="user">
            <li class="flex-center">
              <span class="author">
                  <span class="avatar" 
                    style="background: url('{{ asset(auth()->user()->avatar) }}');border-radius: 50%; margin-right: 20px;height: 100px;
                    width: 100px;">
                  </span>
              </span>
              <span>
                {{ auth()->user()->name }}
              </span>
            </li>
            <li style="margin-bottom: 30px;">
              {{ auth()->user()->email }}
            </li>
            <li class="flex-center">
              <img src="{{ asset('images/allposts.png') }}" alt="all posts" width="25">
              <a href="{{ route('user.allposts',auth()->user()->id) }}" style="margin-left: 0;">
                All my posts
              </a>
            </li>
            <li class="flex-center">
              <img src="{{ asset('images/logout-icon.png') }}" alt="logout" width="25">   
              <a href="{{ route('auth.logout') }}" onclick="if(confirm('Log out of your account?')){return true;}else{return false;}">
                Logout
              </a>
            </li> 
          </ul>
        </div>
      @endauth
      @guest
        <p>
          <a class="primary" href="{{ route('auth.login') }}">Log In</a>
          <a class="primary" href="{{ route('auth.register') }}">Registration</a>
        </p>
      @endguest
  </header>
  <div class="search">    
  <div class="flex-center">    
    <form class="header-form" action="{{ route('posts.search') }}" method="POST">
      @csrf
      <input placeholder="Search post" type="text" name="search">
      <input type="submit" value="Search" style="width: 170px;">
    </form>
    </div>
  </div>
  <h2 style="{{ (!(auth()->user())) ? 'position:relative;z-index:2;color:#fff;' : ''; }};color: black;">
  @if(auth()->user() !== null && ((Route::currentRouteName() === 'posts.index') || (Route::currentRouteName() === 'orderBy')))
  <div class="flex-center">
    <div class="order flex-center" style="padding: 0 40px;margin-bottom:-40px;margin-top: -12px;">
      <form action="{{ route('orderBy')}}" method="POST">
        @csrf
        <input type="submit" value="Order by">
        <select name="order" id="order">
          <option value="new" @isset($new){{'selected'}}@endisset>new ones first</option>
          <option value="old" @isset($old){{'selected'}}@endisset>old ones first</option>
          <option value="views" @isset($views){{'selected'}}@endisset>views</option>
          <option value="likes" @isset($like){{'selected'}}@endisset>likes</option>
        </select>
      </form>
    </div>
  </div>
  @endif
  @yield('title')</h2>
  @yield('content')
</body>
</html>
