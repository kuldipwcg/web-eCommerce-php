<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\ContactValidation;
use Illuminate\Support\Facades\DB;
class ContactController extends Controller
{
    public function store(ContactValidation $request)
    {
            // dd($request->all());

            $data = [
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'message' => $request->message,
            ];

            DB::table('contacts')->insert($data);

            return response()->json([
                'Message' => 'Contact data added successfully',
                'data' => $data,
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
            'message' => 'Deleted Successfully',
        ],200);
    }

}
