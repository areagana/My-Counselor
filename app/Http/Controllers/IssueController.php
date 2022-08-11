<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Issue;
use App\Models\Category;
use App\Models\IssueTopic;

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
    public function fetchIssues(Request $request)
    {
        if($request->ajax())
        {
            $user = Auth::user();
            $date1 = $request->date1;
            $date2 = $request->date2;
            $id = $request->id;
            $status = $request->status;

        // dates are selected and no id selected/no category selected
            if($date1 && $date1 && !$id){ // works well
                if($status)
                {
                    $issues = Issue::whereDate('created_at','>=',$date1)
                                    ->whereDate('created_at','<=',$date2)
                                    ->where('status',$status)
                                    ->where('user_id',$user->id)
                                    ->get();
                }else{
              
                    $issues = Issue::whereDate('created_at','>=',$date1)
                                    ->whereDate('created_at','<=',$date2)
                                    ->where('user_id',$user->id)
                                    ->get();
                }
        // dates are selected and id is available
            }elseif($id && !empty($date1) && !empty($date2)){
                $category = Category::find($id);
                if($status){
                    $issues = $category->issues()->whereDate('created_at','>=',$date1)
                                             ->whereDate('created_at','<=',$date2)
                                             ->where('status',$status)
                                             ->where('user_id',$user->id)
                                             ->get();
                }else{

                    $issues = $category->issues()->whereDate('created_at','>=',$date1)
                                                ->whereDate('created_at','<=',$date2)
                                                ->where('user_id',$user->id)
                                                ->get();
                }
        // no dates selected // fetches well
            }elseif($status && !$id){

                $issues = Issue::where('status',$status)->get();
            }else{
                $category = Category::find($id);
                if($status){
                    $issues = $category->issues()->where('status',$status)->get();
                }else{
                    $issues = $category->issues;
                }
            }

            $clients =[];
            $records =[];

            foreach($issues as $issue)
            {
                $clients[] = $issue->client;
                $records[] = $issue->records;
            }

            /**
             * return a response with the data
             */
            return response()->json(['issues'=>$issues,'clients'=>$clients]);
        }
    }

    // store subissue
    public function subIssueStore(Request $request)
    {
        $issue_id = $request->input('issue_id');
        $issue = Issue::find($issue_id);

        $topic = new IssueTopic();
        $topic->issue_id = $issue->id;
        $topic->title = $request->input('title');
        $topic->details = $request->input('details');

        $topic->save();
        return redirect()->back();
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
