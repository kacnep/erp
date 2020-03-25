<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {

            @unlink($user->avatar);
            $user->update([
                'avatar' => null
            ]);

        }

        return redirect()->route('profile.index')->with('alert', 'Avatar removed');
    }

    public function changeAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image',
        ]);

        $user = Auth::user();

        $path = 'upload/avatar/' . $user->id;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($user->avatar) @unlink($user->avatar);

        $avatar = $path . '/' . rand(11111, 99999) . '.' . $request->file('avatar')->getClientOriginalExtension();
        $this->resizeAndSave($request->file('avatar'), $avatar);

        $user->update([
            'avatar' => $avatar
        ]);

        return redirect()->route('profile.index')->with('alert', 'Avatar change');
    }

    public function changeProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        Auth::user()->update([
            'name' =>  $request->name,
        ]);

        return redirect()->route('profile.index')->with('alert', 'Profile change');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);

        Auth::user()->update([
            'password' =>  Hash::make($request->password),
        ]);

        Auth::logout();

        return redirect()->route('login');
    }

    protected function resizeAndSave($img, $pathToSave)
    {
        $image = Image::make($img);
        $w = $image->width();
        $h = $image->height();
        $min =  $w > $h ? $h : $w;
        $image->crop($min, $min, (int)(($w - $min) / 2), (int)(($h - $min) / 2));
        $image->resize(50, 50);
        $image->save($pathToSave);
    }


}