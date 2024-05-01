<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(UserRequest $request) {

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->avatar = '/images/avatar.png';

        if(($request->hasFile('avatar'))){
            $path = $request->avatar->store('users_avatars');
            $user->avatar = '/storage/'.$path;
        }

        $user->save();

        Auth::login($user);

        return redirect()->route('posts.index');
    }
}
