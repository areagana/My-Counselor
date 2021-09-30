<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Check authentication
     */
    public function __construct()
    {
        $this->middleware(['auth','role:superadministrator|counsellor']);
    }
   
    /**
     * show client image
     */
   protected function ShowClientImage()
   {
                //check image exist or not
        $exists = Storage::disk('public')->exists('Client_profiles/'.$filename);
        
        if($exists) {
            
            //get content of image
            $content = Storage::get('public/Client_profiles/'.$filename);
            
            //get mime type of image
            $mime = Storage::mimeType('public/Client_profiles/'.$filename);
            //prepare response with image content and response code
            $response = Response::make($content, 200);
            //set header 
            $response->header("Content-Type", $mime);
            // return response
            return $response;
        } else {
            abort(404);
        }
   }
   
   public function UserProfileImageUpdate(Request $request,$id)
   {
        $user = User::find($id);
        $file = $request->file('file');
        if($file)
        {
            $fileName = $file->getClientOriginalName();
            // make directory for the clients
            $directory = 'User_profile';

            if($file->move($directory,$fileName))
            {
                $user->profile_image_url = $fileName;
                $user->save();
                return redirect('/profile')->with('success','Profile Updated Successfully');
            }else{
                return redirect('/profile')->with('error','Error in moving file to storage');
            }
        }else{
            return redirect('/profile')->with('error','Please select the image to upload');  
        }
   }
   
}
