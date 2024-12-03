<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(){

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'phone' => 'max:10',
            'about' => 'max:150',
            'location' => ''
        ]);

        $user = User::create($attributes);

        $user->assignRole('user');
        auth()->login($user);
        
        return redirect('/dashboard');
    } 
}
