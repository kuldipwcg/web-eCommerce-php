<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footer;


class FooterController extends Controller
{
    public function index(){

        $data = Footer::find(1);

        if($data){

            
            return response()->json(
                [
                    'footer'=> $data,
                    
                    ]
                    ,200);
                    
        }else{


            return response()->json(
                [
                    'Error'=> 'Data Not Found',
                    
                    ]
                    ,400);

        }

    }


}
