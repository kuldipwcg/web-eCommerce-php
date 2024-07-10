<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\ContactValidation;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    
    public function show(Request $request){
        $contact = contact::get();
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
    public function store(ContactValidation $request)
    {
            // dd($request->all());

            $data = [   
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'message' => $request->message,
            ];
            
           $contact = DB::table('contacts')->insert($data);
            if($contact){
                return response()->json([
                    'data' => $data,
                    'Message' => 'Contact data added successfully',
                    'status' => 'success',
                    'code' => 200
                ],200);
    } 


    public function update(ContactValidation $request, $id)
    {
          $data = contact::find($id);

          $data->name = $request->name;
          $data->subject = $request->subject;
          $data->email = $request->email;
          $data->message = $request->message;
          $data->save();
        //   dd($data);

          return response()->json([
            'Message' => 'contact updated successfully',
            'data' => $data,
          ],200);
    }

    public function destroy($id)
    {
        $data = contact::find($id);
        $data->delete();
        return response()->json([
            'data' => $data,
            'message' => 'Contact deleted Successfully',
            'status' => 'success',
        ],200);
    }

}
