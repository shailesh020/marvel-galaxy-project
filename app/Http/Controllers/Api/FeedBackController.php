<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedBack;
use Illuminate\Support\Facades\Validator;
use Log;

class FeedBackController extends Controller
{
    //this function use feed back 
    public function feedBack(Request $request)
    {
       try{

            $validator = Validator::make($request->all(), [
                'service_id' => 'required',
                'client_id' => 'required',
                'rating' => 'required',
                'description' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

           $feedBack = new FeedBack;
           $feedBack->service_id = $request->service_id;
           $feedBack->client_id = $request->client_id;
           $feedBack->rating = $request->rating;
           $feedBack->description = $request->description;
           $feedBack->save();

           $data = [
            'status'  => 200,
            'message' => "Data Fetch Successfully",
            'data'    => $feedBack,
         ];

        return response()->json($data, 200);

         } catch (Exception $e) {
            Log::info("Feed Back API Error: " . $e->getMessage());
        }
    }
}
