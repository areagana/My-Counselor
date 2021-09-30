<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Client;
use App\Models\Category;
use App\Models\Issue;
use App\Models\Schedule;
use App\Models\Record;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // check authentication

    public function __construct()
    {
        $this->middleware(['auth','role:superadministrator|counsellor']);
    }

    /**
     * Search Client
     */
    public function search(Request $request)
    {
        if($request->ajax())
        {
            $name = $request->name;
            $clients = Client::where('name','like','%'.$name.'%')
                              ->where('user_id',Auth::user()->id)
                              ->get();
            return response()->json(['data'=>$clients]);
        }
    }

    // search user
    public function searchClient(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;
            $issues = Issue::where('client_id',$id)->get();
            return response()->json(['data'=>$issues]);
        }
    }

    // schedules
    public function schedules(Request $request)
    {
        if($request->ajax())
        {
            $date = $request->date;
            // get the upcoming schedules
            $schedules = Schedule::where('schedules.user_id',Auth::user()->id)
                                  ->where('schedules.date','>=',$date)
                                  ->leftJoin('clients','clients.id','client_id')
                                  ->orderBy('schedules.date')  
                                  ->get();
            // get previous schedules
            $previous_schedules = Schedule::where('schedules.user_id',Auth::user()->id)
                                        ->where('schedules.date','<',$date)
                                        ->leftJoin('clients','clients.id','client_id')
                                        ->orderBy('schedules.date','desc')  
                                        ->get();
                                  
            return response()->json(['upcoming'=>$schedules,'previous'=>$previous_schedules]);
        }
    }

    /**
     * check password of the user
     */
    public function passwordCheck(Request $request)
    {
        if($request->ajax())
        {
            $password = $request->password;
            $password = Hash($password);
            // query
            /*$resp = User::where('id',Auth::user()->id)
                        ->where('password',$password)
                        ->get();
            return response()->json(['response'=>$resp]);*/
            return $password;
        }
    }

}
