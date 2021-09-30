<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Schedule;
use App\Models\Issue;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','role:superadministrator|counsellor']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = Client::all();
        $schedules = Schedule::all();
        $issues = Issue::all();

        return view('home',compact(['clients','schedules','issues']));
    }
    
    /**
     * Users
     */
    
    public function users()
    {
        $users = User::all();
        return view('users.create',compact('users'));
    }
}
