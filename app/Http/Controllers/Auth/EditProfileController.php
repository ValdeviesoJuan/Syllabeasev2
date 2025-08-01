<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

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

        // Validate fields (you can customize as needed)
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:20',
            'signature_image' => 'nullable|image|mimes:png|max:2048', // limit to PNGs
        ], [
            'signature_image.mimes' => 'Only PNG files are allowed for the signature image.',
        ]);

         // Handle signature image upload
        if ($request->hasFile('signature_image')) {
            $file = $request->file('signature_image');
            $filename = 'signature_' . $user->id . '_' . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/signatures');

            // Create the folder if it doesn't exist
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            // Delete old signature if exists
            if ($user->signature && File::exists($destination . '/' . $user->signature)) {
                File::delete($destination . '/' . $user->signature);
            }

            // Move the uploaded file
            $file->move($destination, $filename);

            // Update user's signature path
            $user->signature = $filename;
        }

        // Update other profile info
        $user->update([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'prefix'    => $request->prefix,
            'suffix'    => $request->suffix,
            'phone'     => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Profile Updated.');
    }
    public function editPassword()
    {
        $user = Auth::user();

        return view('all.editpassword', compact('user'));
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
