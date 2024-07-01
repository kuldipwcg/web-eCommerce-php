<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\newsletter;
use Illuminate\Routing\Controller;
use App\Http\Requests\NewsletterValidation;
use Illuminate\Support\Facades\DB;


class NewsLetterController extends Controller
{
    public function store(NewsletterValidation $request)
    {
        $data = [   
            'email' => $request->email,    
        ];
        
        DB::table('newsletters')->insert($data);
        
        return response()->json([
            'Message' => 'News letter added successfully',
            'data' => $data,
        ],200);
    } 

    public function update(NewsletterValidation $request, $id)
    {
          $data = newsletter::find($id);

          $data->email = $request->email;
          $data->update();
          $data->save();

          return response()->json([
            'Message' => 'contact updated successfully',
            'data' => $data,
          ],200);
    }  

    public function destroy($id)
    {
        $data = newsletter::find($id);
        $data->delete();
        return response()->json([
            'message' => 'Deleted Successfully',
        ],200);
    }
}
