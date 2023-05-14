<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();


        $request->validate([
            'name' => 'required',
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg',
        ]);

        $user->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ]);

        // Profile Photo Upload
        if($request->hasFile('profile_photo')){
            if($user->profile_photo != 'default_news_thumbnail_photo.jpg'){
                unlink(base_path("public/uploads/profile_photo/").$user->profile_photo);
            }
            $profile_photo_name =  "Profile-Photo-".$user->id.".". $request->file('profile_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/profile_photo/").$profile_photo_name;
            Image::make($request->file('profile_photo'))->resize(120, 100)->save($upload_link);
            $user->update([
                'profile_photo' => $profile_photo_name,
            ]);
        }

        $notification = array(
            'message' => 'Profile updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);
        if($request->current_password == $request->password){
            return back()->withErrors(['password_error' => 'New password can not same as old password']);
        }
        if(Hash::check($request->current_password, Auth::user()->password)){
            User::find(Auth::user()->id)->update([
                'password' => Hash::make($request->password)
            ]);
            $notification = array(
                'message' => 'Password change successfully.',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        }else{
            return back()->withErrors(['password_error' => 'Your Old Password is Wrong!']);
        }
    }
}
