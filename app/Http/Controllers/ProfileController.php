<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Image;

use App\Mail\ChangePasswordMail;
use Mail;

class ProfileController extends Controller
{
    function profileEditCategory() {
    	return view('admin.profile.updateProfile');
    }

    function profileEditPostCategory(Request $request) {

        // echo Carbon::now()->addDays(30);
        // echo Auth::user()->updated_at;

        if (Auth::user()->updated_at->addDays(30) < Carbon::now()) {
            $request->validate([
                'name' => 'required'
            ]);
            User::find(Auth::id())->update([
                'name' => $request->name
            ]);
            return back()->with('profile_update_status', 'Your profile updated successfully.');
            // echo "Parba";
        } else {
            $left_days = Carbon::now()->diffInDays(Auth::user()->updated_at->addDays(30));
            return back()->with('profile_update_error', 'You can cahnge your name '.$left_days.' days latter.');
            // echo "Naa";
        }
    	
    }

    function ChangePasswordPost(Request $request) {
        // print_r($request->old_password);
        // echo Auth::user()->password;
        // echo $request->password;
        // echo Auth::user()->email;
        $request->validate([
            'password' => 'confirmed|min:8'
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            if ($request->old_password != $request->password) {
                User::find(Auth::id())->update([
                    'password' => Hash::make($request->password)
                ]);
                Mail::to(Auth::user()->email)->send(new ChangePasswordMail(Auth::user()->name));
                return back()->with('change_password_status', 'Your password changed successfully.');
            } else {
                return back()->with('change_password_error', 'Your old password and new password is same.Please enter a new password.');
            }
        } else {
            return back()->with('change_password_error', 'Your old password is wrong.');
        }
    }

    function changeImagePost(Request $request) {
        // echo $request->profile_image;
        $request->validate([
            'image' => 'required|image'
        ]);
        if ($request->hasFile('image')) {
            if (Auth::user()->image != 'default.png') {
                $deleted_photo_location = 'public/dashboard_asset/photo/profile_upload/'.Auth::user()->image;
                unlink(base_path($deleted_photo_location));
            }
            $uploaded_photo = $request->file('image');
            $photo_name = Auth::id().".".$uploaded_photo->getClientOriginalExtension($uploaded_photo);
            $new_photo_location = 'public/dashboard_asset/photo/profile_upload/'.$photo_name;

            Image::make($uploaded_photo)->resize(150,150)->save(base_path($new_photo_location), 50);
            User::find(Auth::id())->update([
                'image' => $photo_name
            ]);
            return back()->with('image_upload_status', 'Image uploaded successfully!');
        } else {
            echo "Nai";
        } 
    }
}
