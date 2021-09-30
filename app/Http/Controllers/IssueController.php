<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Issue;

use Illuminate\Http\Request;

class IssueController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $client = Client::find($id);
        $title='new issue';
        return redirect('/client/'.$client->id.'/view')->with('title',$title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $issue = new Issue();
        $client_id = $request->input('client_id');
        $issue->client_id = $client_id;
        $issue->user_id = Auth::user()->id;
        $issue->category_id = $request->input('category_id');
        $issue->issue_title = $request->input('issue_title');
        $issue->issue_details = $request->input('issue_details');
        $issue->save();

        return redirect('/client/'.$client_id.'/view');
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
}
