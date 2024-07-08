<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\newsletter;
use Illuminate\Routing\Controller;
use App\Http\Requests\NewsletterValidation;
use Illuminate\Support\Facades\DB;


class newsLetterController extends Controller
{   

    public function index(){
        //get all subscriber 
        $newsLetter = newsletter::get();
        if($newsLetter){
            return response()->json([
                'data' => $newsLetter,
                'status' => 'Success',
                'code' => 200
            ],200);
        }
        else{
            return response()->json([
                'Message' => 'No Data Found',
                'status' => 'failed',
                'code' => 404
            ],200);
        }
    }
    public function store(NewsletterValidation $request)
    {
        $data = [   
            'email' => $request->email,    
        ];
        
        $newsLetter = DB::table('newsletters')->insert($data);
        if($newsLetter){
            return response()->json([
                'data' => $data,
                'Message' => 'News letter added successfully',
                'status' => 'Success',
                'code' => 200
            ],200);
        }
        else{
            return response()->json([ 
                'Message' => 'Data not found',
                'Status' => 'Failed',
                'code' => 404                    
            ], 404);
        }
        
    } 

    public function update(NewsletterValidation $request, $id)
    {
          $newsLetter = newsletter::find($id);

          $newsLetter->email = $request->email;
          $newsLetter->update();
          $newsLetter->save();

          return response()->json([
            'data' => $newsLetter,
            'Message' => 'newsLetter updated successfully',
          ],200);
    }  

    public function destroy($id)
    {
        $newsLetter = newsletter::find($id);
        $newsLetter->delete();
        return response()->json([
            'data' => $newsLetter,
            'message' => 'newsLetter Deleted Successfully',
            'status' => 'success',
        ],200);
    }
}
