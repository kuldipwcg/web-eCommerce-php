<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContactValidation;

class ContactController extends Controller
{

    public function show(Request $request)
    {
        $contact = contact::get();
        if ($contact) {
            return response()->json([
                'data' => $contact,
                'Message' => 'Contact added successfully',
                'status' => 'Success',
                'code' => 200
            ], 200);
        }
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

          $data->name = $request->name;
          $data->subject = $request->subject;
          $data->email = $request->email;
          $data->message = $request->message;
          $data->save();
        
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