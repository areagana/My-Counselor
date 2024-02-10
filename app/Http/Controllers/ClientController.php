<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Background;
use App\Models\Category;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Allow only logged in users
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
        $clients = Client::where('user_id',Auth::user()->id)->get();
        return view('clients.show',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();
        $categories = Category::all();
        return view('clients.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->gender =  $request->input('gender');
        $client->age =  $request->input('age');
        $client->class = $request->input('class');
        $client->category_id =  $request->input('category');
        $client->user_id = Auth::user()->id;
        $client->save();

        return redirect('client/'.$client->id.'/background/create',);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        $backgrounds = $client->background();
        $otherinfos = $client->otherinfos;
        return view('clients.view',compact(['client','backgrounds','otherinfos']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $directory = 'Client_profiles';
        $client = Client::find($id);
        $url = Storage::url($client->profile_image_url);
        $category_client = Category::find($client->category_id);
        $categories = Category::all();
        return view('clients.edit',compact(['client','category_client','categories','url']));
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
        $client = Client::find($id);

        // get image from the file submitted
        if($file = $request->file('file'))
        {
            $fileName = $file->getClientOriginalName();
            // make directory for the clients
            $directory = 'Client_profiles';

            if($file->move($directory,$fileName))
            {
                $client->profile_image_url = $fileName;
            }
        }else{
        //save the details of the client
            $client->name = $request->input('name');
            $client->gender =  $request->input('gender');
            $client->age =  $request->input('age');
            $client->class =  $request->input('class');
            $client->category_id =  $request->input('category');
            $client->contact =  $request->input('contact');
            $client->email =  $request->input('email');  
            $client->address =  $request->input('address');       
        }
        $client->save();

        return redirect('/clients')->with('success','Cient information updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect('/clients')->with('status','Cleint Deleted successfully');
    }

    // get the clients for a certain category
    public function category($id)
    {
        $category = Category::find($id);
        $clients = $category->clients()->get()->sortBy('name');
        return view('categories.more.clients',compact(['clients','category']));
    }

    /**
     * Create a profile for the client
     */
    public function profile($id)
    {
        $client = Client::find($id);
        return view('clients.profile',compact('client'));
    }

    /**
     * View client schedules
     */

     public function schedules($id)
     {
         $client = Client::find($id);
         $schedules = $client->schedules()->get()->sortByDesc('date');
         return view('clients.schedules',compact(['client','schedules']));
     }
}
