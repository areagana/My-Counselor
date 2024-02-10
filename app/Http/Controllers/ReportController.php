<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use App\Models\Client;
use App\Models\Schedule;
use App\Models\Issue;
use App\Models\User;
use App\Models\Category;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // general report
    public function generalReport()
    {
        $user = Auth::user();
        $issues = $user->issues;
        $status = Issue::pluck('status')->toArray();
        $statuses = array_unique($status);
        $statuses = array_filter($statuses);
        $categories = $user->categories;
        return view('records.reportGeneral',compact(['issues','categories','statuses']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function convertToWord(Request $request)
    // {
    //         $user = Auth::user();
    //         $date1 = $request->date1;
    //         $date2 = $request->date2;
    //         $id = $request->id;
    //         $status = $request->status;

    //         // dates are selected and no id selected/no category selected
    //         if($date1 && $date2 && !$id){ // works well
    //             if($status)
    //             {
    //                 $issues = Issue::whereDate('created_at','>=',$date1)
    //                                 ->whereDate('created_at','<=',$date2)
    //                                 ->where('status',$status)
    //                                 ->where('user_id',$user->id)
    //                                 ->get();
    //             }else{
              
    //                 $issues = Issue::whereDate('created_at','>=',$date1)
    //                                 ->whereDate('created_at','<=',$date2)
    //                                 ->where('user_id',$user->id)
    //                                 ->get();
    //             }
    //         // dates are selected and id is available
    //         }elseif($id && !empty($date1) && !empty($date2)){
    //             $category = Category::find($id);
    //             if($status){
    //                 $issues = $category->issues()->whereDate('created_at','>=',$date1)
    //                                          ->whereDate('created_at','<=',$date2)
    //                                          ->where('status',$status)
    //                                          ->where('user_id',$user->id)
    //                                          ->get();
    //             }else{

    //                 $issues = $category->issues()->whereDate('created_at','>=',$date1)
    //                                             ->whereDate('created_at','<=',$date2)
    //                                             ->where('user_id',$user->id)
    //                                             ->get();
    //             }
    //         // no dates selected // fetches well
    //         }elseif($status && !$id){

    //             $issues = Issue::where('status',$status)->get();
    //         }else{
    //             $category = Category::find($id);
    //             if($status){
    //                 $issues = $category->issues()->where('status',$status)->get();
    //             }else{
    //                 $issues = $category->issues;
    //             }
    //         }

    //         $clients =[];
    //         $records =[];

    //         foreach($issues as $issue)
    //         {
    //             $clients[] = $issue->client;
    //             $records[] = $issue->records;
    //         }

    //         $start_date = $date1;
    //         $end_date = $date2;
    //         /**
    //          * return a response with the data
    //          */
    //         // Render the view and get its content

    //         $content = view('reports.index', compact(['issues','clients','start_date','end_date']))->render();

    //         // Create a new PHPWord instance
    //         $phpWord = new PhpWord();

    //         // Add a section
    //         $section = $phpWord->addSection();

    //         // Add the content of the view to the Word document
    //         \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content);

    //         // Save the document
    //         $filename = 'Counseling_report.docx'; // Change the filename if needed
    //         $phpWord->save(storage_path('app/' . $filename));

    //         // Offer the Word document for download
    //         return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend();
    // }

    public function convertToWord(Request $request)
    {
        $user = Auth::user();
        $date1 = $request->date1;
        $date2 = $request->date2;
        $id = $request->id;
        $status = $request->status;

            // dates are selected and no id selected/no category selected
                if($date1 && $date2 && !$id){ // works well
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

        // Prepare data for the view
        $start_date = $date1;
        $end_date = $date2;

        // Render the view
        $content = view('reports.index', compact(['issues', 'start_date', 'end_date']))->render();
        // return view('reports.index', compact(['issues', 'start_date', 'end_date']));
        //;
        
        $templateProcessor = new TemplateProcessor('word-template/Report.docx');
        $templateProcessor->setValue('start_date', $date1);
        $templateProcessor->setValue('end_date', $date2);

        foreach($issues as $issue)
        {
            $templateProcessor->setValue('date', $issue->updated_at);
            $templateProcessor->setValue('name', $issue->client->name);
            $templateProcessor->setValue('class', $issue->client->class);
            $templateProcessor->setValue('title', $issue->title);
            
            foreach($issue->records as $k =>$value)
            {
                $templateProcessor->setValue('sharingk', $value->shared_info);
            }
            $templateProcessor->setValue('progressk', $value->progress);
        }

        $filename = 'Counseling_report.docx';
        $templateProcessor->saveAs($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
        // // Create a new PHPWord instance
        // $phpWord = new PhpWord();

        // // Add a section
        // $section = $phpWord->addSection();

        // // Add the content of the view to the Word document
        // \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content);

        // // Save the document
        // $filename = 'Counseling_report.docx';
        // $phpWord->save(storage_path('app/' . $filename));

        // // Offer the Word document for download
        // return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
