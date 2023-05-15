<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function changePassword()
    {
        $page_title = 'Change Password';
        return view('admin.user.change-password', compact('page_title'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $userDetail = User::where('id',$user->id)->first();
        if (Hash::check($request->old_password, $userDetail->password)) {
            $userDetail->password = Hash::make($request->password);
            $userDetail->save();

            return redirect()->back()->with('success', 'Password changed successfully');
        } else {
            return redirect()->route('change-password')->withErrors(['failed' => 'Old password doesnt matched']);
        }
    }
}
