<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Client;
use App\Models\Issue;
use App\Models\Category;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Check authentication
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = DB::table('schedules')
                            ->leftJoin('issues','issues.id','schedules.issue_id')
                            ->leftJoin('clients','clients.id','schedules.client_id')
                            ->get();
        
        return view('schedules.show',compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schedule = new Schedule();
        $clients = Client::where('user_id',Auth::user()->id)->get()->sortBy('name'); // only clients for the user
        return view('schedules.create',compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new Schedule();
        $date = $request->input('schedule-date');
        $end_time = $request->input('end_time').":00";
        $end_date_time = date_format(date_create($date),"Y-m-d ".$end_time);

        $schedule->client_id = $request->input('client_id');
        $schedule->issue_id = $request->input('schedule-issues');
        $schedule->user_id = Auth::user()->id;
        $schedule->date = $date;
        $schedule->end_time = $end_date_time;
        $schedule->status='Scheduled';
        $schedule->topic = $request->input('schedule-topic');
        $schedule->save();

        return redirect('/schedule')->with('success','Meeting Scheduled successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * display the category schedules
     */
    public function category($id)
    {
        $category = Category::find($id);
        $schedules = $category->schedules()->get()->sortByDesc('date');
        return view('categories.more.schedules',compact(['category','schedules']));
    }
}
