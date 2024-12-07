<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
{
    try {
        $google_user = Socialite::driver('google')->user();

        // Check if a user exists with the Google ID
        $user = User::where('google_id', $google_user->id)->first();

        if (!$user) {
            // Check if a user exists with the same email
            $user = User::where('email', $google_user->getEmail())->first();

            if (!$user) {
                // Create a new user if no existing user with email
                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                ]);
            } else {
                // Update the existing user's Google ID
                $user->update(['google_id' => $google_user->getId()]);
            }
        }

        // Log the user in
        auth()->login($user);

        return redirect()->intended('login'); // Change 'dashboard' to your desired route
    } catch (\Throwable $th) {
        // Log the error or show a user-friendly message
        return redirect('/')->with('error', 'Something went wrong: ' . $th->getMessage());
    }
}

}
