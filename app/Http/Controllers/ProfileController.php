<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->hasRole(['admin'])) {
            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'user']);
            })->paginate(5);
            return view('pages.profile.user-management', compact('users'));
        } else {
            return redirect()->route('dashboard')->with('error', 'You are not authorized.');
        }
    }
    
    public function profile()
    {
        return view('pages.profile.user-profile');
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        return view('pages.profile.edit-profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->input();

        $user = User::find($id);
        $user->name =  $request->name;
        $user->phone =  $request->phone;
        $user->location =  $request->location;
        $user->about =  $request->about;
        $user->save();

        return back()->with('success', 'User update successfully!');
    }

    public function edit_profile()
    {
        $user = auth()->user();
        return view('pages.profile.edit-profile', compact('user'));
    }

}
