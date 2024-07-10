<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Http\Requests\ContactValidation;
use Illuminate\Support\Str;
use DB;
class ContactController extends Controller
{
    
    public function show(Request $request){
    public function show(Request $request){
        $contact = contact::get();
        if($contact){
        if($contact){
            return response()->json([
                'data' => $contact,
                'status' => 'Success',
                'code' => 200
            ],200);
        }
        else{
            return response()->json([
                'Message' => 'No Data Found',
                'status' => 'failed',
                'code' => 404
            ],404);
        }
        }
        else{
            return response()->json([
                'Message' => 'No Data Found',
                'status' => 'failed',
                'code' => 404
            ],404);
        }
    }
    public function store(ContactValidation $request)
    {
            // dd($request->all());

            // dd($request->all());

            $data = [   
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'message' => $request->message,
            ];
            
           $contact = DB::table('contacts')->insert($data);
            if($contact){
            if($contact){
                return response()->json([
                    'data' => $data,
                    'data' => $data,
                    'Message' => 'Contact data added successfully',
                    'status' => 'success',
                    'code' => 200
                ],200);
            }
            else{
                return response()->json([ 
                    'Message' => 'Data not added',
                    'Status' => 'Failed',
                    'code' => 401                    
                ], 401);
            }
            
    } 


    public function update(ContactValidation $request, $id)
    {
          $data = contact::find($id);
          $data = contact::find($id);

          $data->name = $request->name;
          $data->subject = $request->subject;
          $data->email = $request->email;
          $data->message = $request->message;
          $data->save();
        //   dd($data);

        //   dd($data);

          return response()->json([
            'Message' => 'contact updated successfully',
            'data' => $data,
            'data' => $data,
          ],200);
    }

    public function destroy($id)
    {
        $data = contact::find($id);
        $data->delete();
        $data = contact::find($id);
        $data->delete();
        return response()->json([
            'message' => 'Deleted Successfully',
        ],200);
    }

}
