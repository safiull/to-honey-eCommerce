<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\SubscribersMail;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        // $users=User::latest()->get();
        $users=User::orderBy('id', 'desc')->paginate(3);
        $total_users = User::count();
        return view('home', compact('users', 'total_users'));
    }

    public function sendMailToSubscirbers() {
        foreach (User::all()->pluck('email') as $email) {
            Mail::to($email)->send(new SubscribersMail());
        }
        return back()->with('subscribers_mail_status', 'Mail send successfully to all subscribers!');
    }

}
