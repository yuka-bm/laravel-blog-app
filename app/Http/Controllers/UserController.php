<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/avatars/';
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($user_id)
    {
        $user = $this->user->findOrFail($user_id);
        return view('users.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
    
        if(Auth::user()->id != $id) {
            return redirect()->route('index');
        }
        
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required | min:1 | max:150',
            'email' => 'required | min:1 | max:150 | unique:users,email,' .$id,
            'avatar' => 'mimes:jpeg,jpg,png,gif | max:1048'
        ]);

        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        # if the user uploaded an avatar ...
        if ($request->avatar) {
            if ($user->avatar) {
                $this->deleteAvatar($user->avatar);
            }

            # move the new image to the local storage
            $user->avatar = $this->saveAvatar($request);
        }

        $user->save();
        return redirect()->route('profile.show', $user->id);
    }

    public function saveAvatar($request)
    {
        // rename the image file to CURRENT TIME to avoid overlapping
        $avatar_name = time() . "." . $request->avatar->extension();

        // save the file inside the local storage - storage/app/public/avatars
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    public function deleteAvatar($avatar_name)
    {
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;

        if (Storage::disk('local')->exists($avatar_path)) {
            Storage::disk('local')->delete($avatar_path);
        }
    }

    public function editPassword($user_id)
    {
        return view('users.edit_password')->with('user_id', $user_id);
    }

    public function updatePassword(Request $request, $user_id)
    {
        $request->validate([
            'old_password' => 'required | min:1',
            'new_password' => 'required | min:1',
            'confirm_password' => 'required | min:1'
        ]);

        if(Auth::user()->id != $user_id) {
            return redirect()->route('index');
        }

        if (password_verify($request->old_password, Auth::user()->password)) {

            if ($request->new_password === $request->confirm_password) {
                $user = $this->user->findOrFail($user_id);
                $password = password_hash($request->new_password, PASSWORD_DEFAULT);
                $user->password = $password;
                $user->save();

                return redirect()->route('profile.edit_password', Auth::user()->id)->with('success', "Password changed successfully.");
            }
            else {
                return redirect()->route('profile.edit_password', Auth::user()->id)->with('error', "New password and Confirm password do not match.");
            }
        }
        else {
            return redirect()->route('profile.edit_password', Auth::user()->id)->with('error2', "Old password does not match your current password.");
        }
    }
}
