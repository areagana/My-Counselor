<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Issue;
use App\Models\Record;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Check authentication
     */
    public function __construct()
    {
        $this->middleware(['auth','role:superadministrator|counsellor']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::where('user_id',Auth::user()->id)
                           ->get()
                           ->sortByDesc('created_at');
        return view('records.show',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $records = new Record();
        $issue = Issue::find($id);
        $topics = $issue->topics();
        $client_id = $issue->client_id;
        $title='new record';
        return redirect('/client/'.$client_id.'/view')->with(['title'=>$title,'issue_select'=>$issue]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = new Record();
        $record->user_id = Auth::user()->id;
        $record->topic_id = $request->input('topic_id');
        $record->client_id = $request->input('client_id');
        $record->issue_id = $request->input('issue_id');
        $record->category_id= $request->input('category_id');
        $record->shared_info = $request->input('issue_details');
        $record->progress = $request->input('issue_progress');
        $record->save();

        // update the status of the issue
        $issue = Issue::find($record->issue_id);
        $issue->status = $request->input('issue_status');
        $issue->save();

        return redirect('/client/'.$record->client_id.'/view')->with('success','Records saved');
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
        $record = Record::find($id);
        $client_id = $request->input('client_id');
        $record->shared_info = $request->input('shared_info');
        $record->progress = $request->input('progress');
        $record->save();
        
        return redirect('/client/'.$client_id.'/view')->with('success','Record updated successfully');
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
}
