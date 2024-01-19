<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    //this function use get product list
    public function products(Request $request)
    {
        try {
            $machine = Machine::get();
            $dataMachine = [];
            if (count($machine) > 0) {
                foreach ($machine as $key => $list) {
                    $dataMachine[$key]['id'] = $list->id;
                    $dataMachine[$key]['name'] = $list->name;
                    $dataMachine[$key]['description'] = $list->description;
                    $dataMachine[$key]['code'] = $list->code;

                    $productImage[$key]['product_image'] = [];
                    if (count($list->machineImages) > 0) {
                        foreach ($list->machineImages as $imageKey =>  $image) {
                            $dataMachine[$key]['product_image'][$imageKey] = asset("file/machine/" . $image->photo);
                        }
                    }
                }
            }
            $data = [
                'status'  => 200,
                'message' => "Data Fetch Successfully",
                'data'    => $dataMachine,
            ];

            return response()->json($data, 200);
        } catch (Exception $e) {
            Log::info("Product List API Error: " . $e->getMessage());
        }
    }

    //this function use edit profile
    public function editProfile(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'profile' => 'required',
                'name' => 'required',
                'dob' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $userIds = User::find(auth()->user()->id);
            if (empty($userIds)) {
                $data = [
                    'status'  => 400,
                    'message' => "User Not Found",
                ];

                return response()->json($data, 400);
            }
            $userIds->name = $request->name;
            $userIds->dob = $request->dob;
            $userIds->profile = storeFile($request->profile, 'profile');
            $userIds->update();

            $userDetails = auth()->user();

            $dataDetails = [];
            $dataDetails['id'] = $userDetails->id;
            $dataDetails['name'] = $userDetails->name;
            $dataDetails['email'] = $userDetails->email;
            $dataDetails['dob'] = $userDetails->dob;
            $dataDetails['residential_address'] = $userDetails->residential_address;
            $dataDetails['phone_no'] = $userDetails->phone_no;
            $dataDetails['role'] = $userDetails->roles->first()->id;

            $data = [
                'status'  => 200,
                'message' => "Profile Update Successfully",
                'data'    => $dataDetails,
            ];

            return response()->json($data, 200);
        } catch (Exception $e) {

            Log::info("Edit Profile API Error: " . $e->getMessage());
        }
    }

    //this function use my profile get
    public function myProfile(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $userIds = User::where('id', $request->user_id)->first();
            if (empty($userIds)) {
                $data = [
                    'status'  => 400,
                    'message' => "User Not Found",
                ];

                return response()->json($data, 400);
            }

            $dataProfile['id'] = $userIds->id;
            $dataProfile['name'] = $userIds->name;
            $dataProfile['phone_no'] = $userIds->phone_no;
            $dataProfile['profile'] = asset('file/profile/' . $userIds->profile);

            $datas = [
                'status'  => 200,
                'message' => "Profile Update Successfully",
                'data'    => $dataProfile,
            ];

            return response()->json($datas, 200);
        } catch (Exception $e) {
            dd($e);
            Log::info("My Profile API Error: " . $e->getMessage());
        }
    }

    public function clientMachine($client_id)
    {
        try {
            $client = User::find($client_id);
            if (empty($client)) {
                $data = [
                    'status'  => 400,
                    'message' => "User Not Found",
                ];

                return response()->json($data, 400);
            }

            $clientMachine = $client->PurchaseMachine;
            $machine_date = [];
            foreach ($clientMachine as $key => $list) {
                $list = $list->machine;
                $dataMachine['id'] = $list->id;
                $dataMachine['name'] = $list->name;
                $dataMachine['description'] = $list->description;
                $dataMachine['code'] = $list->code;

                $dataMachine['product_image'] = [];
                if (count($list->machineImages) > 0) {
                    foreach ($list->machineImages as $imageKey =>  $image) {
                        $dataMachine['product_image'][$imageKey] = asset("file/machine/" . $image->photo);
                    }
                }
                array_push($machine_date, $dataMachine);
            }
            $data = [
                'status'  => 200,
                'message' => "Data Fetch Successfully",
                'data'    => $machine_date,
            ];
            return response()->json($data, 200);
        } catch (Exception $e) {
            Log::info("Client Machine API Error: " . $e->getMessage());
        }
    }

    public function clients()
    {
        try {
            $cients_data = User::orderBy('id', 'DESC');
            $cients_data = $cients_data->whereHas('roles', function ($q) {
                $q->where('name', 'Clients');
            });
            $cients_data = $cients_data->get();

            $client_data = [];
            foreach ($cients_data as $key => $client) {
                $dataProfile['id'] = $client->id;
                $dataProfile['name'] = $client->name;
                $dataProfile['phone_no'] = $client->phone_no;
                $dataProfile['profile'] = asset('file/profile/' . $client->profile);
                array_push($client_data,$dataProfile);
            }

            $data = [
                'status'  => 200,
                'message' => "Data Fetch Successfully",
                'data'    => $client_data,
            ];
            return response()->json($data, 200);
        } catch (Exception $e) {
            Log::info("Client Machine API Error: " . $e->getMessage());
        }
    }
}
