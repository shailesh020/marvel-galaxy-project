<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Apitoken;
use Log;

class LoginController extends Controller
{
    //this function use login data
    public function login(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'phone_no' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $userDetails = User::where('phone_no', $request->phone_no)->first();
            if (empty($userDetails)) {

                $data = [
                    'status'  => 400,
                    'message' => "Your Phone Number Invalid",
                ];

                return response()->json($data, 400);
            }

                $previousAccessToken = Apitoken::where('tokenable_id', $userDetails->id)->first();
                if ($previousAccessToken != "") {
                    $previousAccessToken->delete();
                }
                $newTokenDetails =  $userDetails->createToken('my-app-token')->plainTextToken;

                $userDetails->remember_token =$newTokenDetails;
                $userDetails->update();

                    //   $data =  Helpers::sendFirebasePushNotification($userDetails->id,$userDetails->id,'Login Successfully','You Are Login In Playzee App','');

                if ($userDetails) {
                    $tokenDetails = [];
                    $tokenDetails['otp'] = '1234';
                    $data = [
                        'status'  => 200,
                        'data'    => $tokenDetails,
                        'message' => "Login Successfully",
                    ];

                    return response()->json($data, 200);
                }


        } catch (Exception $e) {

            Log::info("Login API Error: " . $e->getMessage());
        }
    }

    //this function use OTP verify
    public function otpVerify(Request $request)
    {
           try{

            $validator = Validator::make($request->all(), [
                'phone_no' => 'required',
                'otp' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $userDetails = User::where('phone_no', $request->phone_no)->first();
            if (empty($userDetails)) {

                $data = [
                    'status'  => 400,
                    'message' => "Your Phone Number Invalid",
                ];

                return response()->json($data, 400);
            }

            $previousAccessToken = Apitoken::where('tokenable_id', $userDetails->id)->first();
            if ($previousAccessToken != "") {
                $previousAccessToken->delete();
            }
            $newTokenDetails =  $userDetails->createToken('my-app-token')->plainTextToken;

            $userDetails->remember_token =$newTokenDetails;
            $userDetails->update();

            if($request->otp == 1234)
            {
                $dataDetails = [];
                $dataDetails['id'] = $userDetails->id;
                $dataDetails['name'] = $userDetails->name;
                $dataDetails['email'] = $userDetails->email;
                $dataDetails['dob'] = $userDetails->dob;
                $dataDetails['residential_address'] = $userDetails->residential_address;
                $dataDetails['phone_no'] = $userDetails->phone_no;
                $dataDetails['token'] = $newTokenDetails;
                $dataDetails['role'] = $userDetails->roles->first()->id;

                $data = [
                    'status'  => 200,
                    'data'    => $dataDetails,
                    'message' => "OTP Verify Successfully",
                ];

                return response()->json($data, 200);
            }else{
                $data = [
                    'status'  => 400,
                    'message' => "OTP Invalid",
                ];

                return response()->json($data, 400);
            }
           } catch (Exception $e) {

            Log::info("Login API OTP Verify Error: " . $e->getMessage());
           }
    }
}
