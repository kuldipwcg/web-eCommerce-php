<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Routing\Controller;
use App\Http\Requests\ContactValidation;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    
    public function index(){
        $contact = contact::get();
            return response()->json([
                'data' => $contact,
                'Message' => 'Contact added successfully',
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
                return response()->json([
                    'data' => $contact,
                    'Message' => 'Contact data added successfully',
                    'status' => 'success',
                    'code' => 200
                ],200);
    }
    public function update(ContactValidation $request, $id)
    {
          $data = contact::find($id);

          $contact->name = $request->name;
          $contact->subject = $request->subject;
          $contact->email = $request->email;
          $contact->message = $request->message;
          $contact->save();
        
          return response()->json([
            'data' => $data,
            'Message' => 'contact updated successfully',
            'status' => 'success',
          ],200);
    }

    public function destroy($id)
    {
        $contact = contact::find($id);
        $contact->delete();
        return response()->json([
            'data' => $data,
            'message' => 'Contact deleted Successfully',
            'status' => 'success',
        ],200);
    }

}