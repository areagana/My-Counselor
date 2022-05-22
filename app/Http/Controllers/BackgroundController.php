<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Otherinfo;
use App\Models\Background;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackgroundController extends Controller
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
        $background = new Background();

        return view('backgrounds.create',compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $background = new Background();
        $background->client_id = $request->input('client_id');
        $background->alcohol = $request->input('alcohol');
        $background->drugs = $request->input('drugs');
        $background->torture = $request->input('torture');
        $background->others = $request->input('other-info');
        $background->save();

        return redirect('/clients')->with('success','New client created successfully');
    }

    public function otherInfoStore(Request $request,$id)
    {
        $client = Client::find($id);
        $info = new Otherinfo();

        $info->client_id = $client->id;
        $info->other_info = $request->input('more-info');
        $info->category = $request->input('category');
        $info->user_id = Auth::user()->id;
        $info->save();
        return redirect()->back();   
        
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
