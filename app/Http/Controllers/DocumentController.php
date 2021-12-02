<?php

namespace App\Http\Controllers;
use Illuminate\Support\facades\Auth;
use App\Models\Document;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * 
     */
    public function __construct()
    {
        $this->middleware(['auth','role:superadministrator|counsellor']);
    }
    /**
     * add a document to the table and folder
     */
    public function store(Request $request,$id)
    {
        $request->validate([
            'document' => 'required|mimes:ppt,pptx,docs,csv,txt,xlx,xls,pdf'
        ]);

        $document = new Document();

        if($file = $request->file('document'))
        {
            $fileName = $file->getClientOriginalName();

            // move file to the file folde
            if($file->move('Documents',$fileName))
            {
                $document->client_id = $request->input('client_id');
                $document->category_id = $id;
                $document->document_title = $request->input('document_title');
                $document->document_url = $fileName;
                $document->user_id = Auth::user()->id;
                $document->save();

                return redirect('/categories/'.$document->category_id.'/documents')->with('success','Document uploaded successfully');
            }else{
                return redirect('/categories/'.$document->category_id.'/documents')->with('error','Error in moving documen to folder');
            }
            
        }else{
            return redirect('/categories/'.$document->category_id.'/documents')->with('error','Please select document to upload');
        }
    }

    // download document
    public function download($id)   
    {
        $document = Document::find($id);
        $doc = 'Documents/'.$document->document_url;
        return response()->download($doc);

    }
}
