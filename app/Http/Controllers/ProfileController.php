<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Check authentication
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    // view user profiles
    public function profile()
    {
        return view('Auth.profile');
    }

    // update profile
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $user->firstName = $request->input('firstName');
        $user->lastName = $request->input('lastName');
        $user->gender = $request->input('gender');
        $user->contact = $request->input('contact');
        $user->email = $request->input('email');
        $user->save();
        return redirect('/profile')->with('success','Profile Updated Successfully');
    }
}
