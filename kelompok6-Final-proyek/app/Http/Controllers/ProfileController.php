<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index()
    {
        // Retrieve the currently authenticated user's ID...
        $Userid = Auth::id();

        $profile = Profile::where('users_id', $Userid)->first();

        return view('profile.edit', ['profile' => $profile]);
    }

    public function update(Request $request, $id)
    {
        // validation data
        $request->validate([
            'umur' => 'required|numeric|max:99',
            'alamat' => 'required',
        ]);

        $profile = Profile::find($id);

        $profile->umur = $request->input('umur');
        $profile->alamat = $request->input('alamat');

        $profile->save();

        return redirect('/');
    }
}
