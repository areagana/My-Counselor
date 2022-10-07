<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Schedule;
use App\Models\Issue;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','role:superadministrator|counsellor|user']);
    }

    /* Show the application dashboard.
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
     * function to generate reports 
     */
    public function reports()
    {
        $user = Auth::user();
        $issues = $user->issues;
        $status = Issue::pluck('status')->toArray();
        $statuses = array_unique($status);
        $statuses = array_filter($statuses);
        $categories = $user->categories;
        return view('records.report',compact(['issues','categories','statuses']));
    }

}
