<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditProfileController extends Controller
{
    public function editProfile()
    {
        $user = Auth::user();
        return view('All.editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'prefix' => $request->prefix,
            'suffix' => $request->suffix,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile Updated.');
    }
    public function editPassword()
    {
        $user = Auth::user();

        return view('All.editPassword', compact('user'));
    }
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|min:8',
        'new_password' => 'required|min:8|confirmed',
    ], [
        'current_password.required' => 'Please enter your current password.',
        'current_password.min' => 'Your current password must be at least :min characters.',
        'new_password.required' => 'Please enter a new password.',
        'new_password.min' => 'Your new password must be at least :min characters.',
        'new_password.confirmed' => 'The new password confirmation does not match.',
    ]);

    $user = User::find(Auth::user()->id);

    if (Hash::check($request->current_password, $user->password)) {
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password changed successfully.');
    } else {
        return redirect()->back()->with('error', 'Incorrect current password. Please try again.');
    }
}
}
