<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Hash;
use Auth;
use Carbon\Carbon;

class GithubController extends Controller
{

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        if (!User::where('email', $user->getEmail())->exists()) {
        	User::insert([
	            'name' => $user->getNickname(),
	            'email' => $user->getEmail(),
	            'password' => Hash::make('12345678'),
	            'created_at' => Carbon::now(),
	            'role' => 2
	        ]);

        }
        if (Auth::attempt(['email' => $user->getEmail(), 'password' => '12345678'])) {
            return redirect('customer/home');
        }
    }
}
