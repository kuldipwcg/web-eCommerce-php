<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\ContactValidation;
use DB;
class ContactController extends Controller
{
    
    public function index(){
        $contact = contact::get();
            return response()->json([
                'data' => $contact,
                'Message' => 'Data added successfully',
                'status' => 'Success',
                'code' => 200
            ],200);
    }
    public function store(ContactValidation $request)
    {
            $data = [   
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'message' => $request->message,
            ];
            
           $contact = DB::table('contacts')->insert($data);
            if($contact){
                return response()->json([
                    'data' => $contact,
                    'Message' => 'Contact data added successfully',
                    'status' => 'success',
                    'code' => 200
                ],200);
            }
            else{
                return response()->json([ 
                    'Message' => 'No data found',
                    'Status' => 'Failed',
                    'code' => 404                    
                ], 404);
            }
            
    } 


    public function update(ContactValidation $request, $id)
    {
          $contact = contact::find($id);

          $data->name = $request->name;
          $data->subject = $request->subject;
          $data->email = $request->email;
          $data->message = $request->message;
          $data->save();
        
          return response()->json([
            'data' => $contact,
            'Message' => 'contact updated successfully',
            'status' => 'success',
            'code' => 200
          ],200);
    }

    public function destroy($id)
    {
        $contact = contact::find($id);
        $contact->delete();
        return response()->json([
            'data' => $contact,
            'message' => 'Contact deleted Successfully',
            'status' => 'success',
            'code' => 200
        ],200);
    }

}
