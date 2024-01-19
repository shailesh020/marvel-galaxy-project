<?php

namespace App\Http\Controllers\Api;

use App\Models\Services;
use App\Http\Controllers\Controller;
use App\Models\ServiceDocs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Helpers\custHelpers;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\OTPModel;
use App\Models\User;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'client_id'=>'required',
                'machine_id' => 'required',
                'description' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $services = new Services();
            $services['client_id'] = $request->client_id;
            $services['machine_id'] = $request->machine_id;
            $services['description'] = $request->description;
            $services['code_services'] = Str::random(10);
            $services['start_date'] = date('Y-m-d');
            $services->save();

            if ($request->file) {
                foreach ($request->file as $key => $file) {
                    $fileName = time().'.'.$file->extension();
                    $file->move(public_path("file/book-services"), $fileName);
                    $ServiceDocs = new ServiceDocs();
                    $ServiceDocs['service_id'] = $services->id;
                    $ServiceDocs['docs'] = $fileName;
                    $ServiceDocs->save();
                }
            }

            $data = [
                'status'  => 200,
                'data'    => $services,
                'message' => "Service booked Successfully",
            ];

            return response()->json($data, 200);

            } catch (Exception $e) {

            Log::info("Edit Profile API Error: " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }

    public function pendingService(Request $request)
    {
          try{

              $userDetails = auth()->user();

              $serviceData = Services::where('client_id',$userDetails->id)->where('status','PENDING')->orderBy('id','desc')->get();
              if(empty($serviceData))
              {
                  $datas = [
                      'status'  => 400,
                      'message' => "Service Not Found",
                  ];

                  return response()->json($datas, 400);
              }
                $dataDetails = [];
                foreach ($serviceData as $key => $value) {
                    $dataDet['id'] = $value->id;
                    $dataDet['machine_name'] = $value->machine->name;
                    $dataDet['machine_code'] = $value->machine->code;
                    $dataDet['service_code'] = $value->code_services;
                    $dataDet['service_status'] = $value->status;
                    $dataDet['engineer_name'] = isset($value->engineer->name) ? $value->engineer->name:'';
                    $dataDet['mobile_number'] = isset($value->engineer->phone_no) ? $value->engineer->phone_no:'';
                    array_push($dataDetails,$dataDet);
                }

                $data = [
                    'status'  => 200,
                    'message' => "Pending Service Successfully",
                    'data'    => $dataDetails,
                ];

                return response()->json($data, 200);

                } catch (Exception $e) {

                Log::info("Penidng Service API Error: " . $e->getMessage());
        }
    }

    //this function use allocate service
    public function allocateService(Request $request)
    {
          try{

            $userDetails = auth()->user();

            $serviceData = Services::where('client_id',$userDetails->id)->where('status','ALLOCATED')->orderBy('id','desc')->first();
            if(empty($serviceData))
            {
                $datas = [
                    'status'  => 400,
                    'message' => "Service Not Found",
                ];

                return response()->json($datas, 400);
            }
              $dataDetails = [];
              $dataDetails['id'] = $serviceData->id;
              $dataDetails['service_name'] = $serviceData->code_services;
              $dataDetails['service_status'] = $serviceData->status;
              $dataDetails['engineer_name'] = isset($serviceData->engineer->name) ? $serviceData->engineer->name:'';
              $dataDetails['mobile_number'] = isset($serviceData->engineer->phone_no) ? $serviceData->engineer->phone_no:'';
              $dataDetails['machine_code'] = isset($serviceData->machine->code) ? $serviceData->machine->code:'';
              $dataDetails['machine_name'] = isset($serviceData->machine->name) ? $serviceData->machine->name:'';

              $data = [
                  'status'  => 200,
                  'message' => "Allocate Service Successfully",
                  'data'    => $dataDetails,
              ];

              return response()->json($data, 200);
           } catch (Exception $e) {
              Log::info("Allocate Service API Error: " . $e->getMessage());
        }
    }


    //this function use get engineer details
    public function activeService(Request $request)
    {
         try{
            $userDetails = auth()->user();

            $serviceData = Services::where('client_id',$userDetails->id)->where('status','ACTIVE')->orderBy('id','desc')->first();

            if(!empty($serviceData))
            {
                $dataDetails = [];
                $dataDetails['id'] = $serviceData->id;
                $dataDetails['description'] = $serviceData->description;
                $dataDetails['service_name'] = $serviceData->code_services;
                $dataDetails['start_date'] = isset($serviceData->start_date) ? $serviceData->start_date : '';
                $dataDetails['profile'] = isset($serviceData->engineer->profile) ?  asset('file/profile/' .$serviceData->engineer->profile) :'';
                $dataDetails['engineer_name'] = isset($serviceData->engineer->name) ? $serviceData->engineer->name:'';
                $dataDetails['mobile_number'] = isset($serviceData->engineer->phone_no) ? $serviceData->engineer->phone_no:'';
                $dataDetails['machine_code'] = isset($serviceData->machine->code) ? $serviceData->machine->code:'';
                $dataDetails['machine_name'] = isset($serviceData->machine->name) ? $serviceData->machine->name:'';

                $data = [
                    'status'  => 200,
                    'message' => "Active Service Successfully",
                    'data'    => $dataDetails,
                ];
                return response()->json($data, 200);
            }else{

                $datas = [
                    'status'  => 400,
                    'message' => "Service Not Found",
                ];

                return response()->json($datas, 400);
            }
          } catch (Exception $e) {

              Log::info("Active Service API Error: " . $e->getMessage());
        }
    }

    //this function use complete list
    public function completeServiceList(Request $request)
    {
           try{
            $userDetails = auth()->user();
            $serviceData = Services::where('client_id',$userDetails->id)->where('status','COMPLITED')->orderBy('id','desc')->get();

            $serviceList = [];
            if(count($serviceData)>0)
            {
                foreach($serviceData as $key => $list)
                {
                    $serviceList[$key]['id'] = $list->id;
                    $serviceList[$key]['description'] = $list->description;
                    $serviceList[$key]['service_name'] = $list->code_services;
                    $serviceList[$key]['start_date'] = isset($list->start_date) ? $list->start_date : '';
                    $serviceList[$key]['end_date'] = isset($list->end_date) ? $list->end_date : '';
                    $serviceList[$key]['profile'] = isset($list->engineer->profile) ?  asset('file/profile/' .$list->engineer->profile) :'';
                    $serviceList[$key]['engineer_name'] = isset($list->engineer->name) ? $list->engineer->name:'';
                    $serviceList[$key]['mobile_number'] = isset($list->engineer->phone_no) ? $list->engineer->phone_no:'';
                    $serviceList[$key]['machine_number'] = isset($list->machine->code) ? $list->machine->code:'';
                }
            }

            $data = [
                'status'  => 200,
                'message' => "Complete Service Successfully",
                'data'    => $serviceList,
            ];
            return response()->json($data, 200);

           } catch (Exception $e) {

            Log::info("Complete Service API Error: " . $e->getMessage());
        }
    }

    //this function use complete service
    public function completeService(Request $request,$services_id)
    {
          try{
            
            $serviceData = Services::where('id',$services_id)->first();
            if(empty($serviceData))
            {
                $datas = [
                    'status'  => 400,
                    'message' => "Service Not Found",
                ];

                return response()->json($datas, 400);
            }
            $serviceData->status = 'COMPLITED';
            $serviceData->end_date = date('Y-m-d');
            $serviceData->update();

            $userDetails = auth()->user();
            $otpData = random_int(1000, 9999);
            $otp = new OTPModel;
            $otp->user_id = $userDetails->id;
            $otp->otp = $otpData;
            $otp->status = '0';
            $otp->save();

            $data =  $this->Notification($userDetails->id,'Complete Service Successfully',$otpData);
            $data = [
                'status'  => 200,
                'message' => "Complete Service Successfully",
                'data'    =>[],
            ];
            return response()->json($data, 200);
          } catch (Exception $e) {
            Log::info("Complete Service API Error: " . $e->getMessage());
        }
    }


    public function Notification($user_id,$title,$description)
    {

        try{
                $firebaseToken = User::where('id',$user_id)->whereNotNull('device_token')->pluck('device_token')->first();
                $url = 'https://fcm.googleapis.com/fcm/send';
               
                $SERVER_API_KEY = 'AAAAGvgGk6w:APA91bE7laIe_PzQt0q5QNNDIvP0CML7SCK0WFILNkAtGTnsAklcVZ9dHgpyXlFAjWVe8694-_9WR0Wr08TcsarQf0WIqGc-d5frtweUqO3KwhICIw78noUIiu2GlXUFLll_C_Ipiel9';
            
                    $data = [
                        "registration_ids" => $firebaseToken,
                        "notification" => [
                            "title" => $title,
                            "body" => $description,  
                        ]
                    ];
                    $encodedData = json_encode($data);
                
                    $headers = [
                        'Authorization:key=' . $SERVER_API_KEY,
                        'Content-Type: application/json',
                    ];
                
                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                  
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
                    // Execute post
                    $result = curl_exec($ch);
                    if ($result === FALSE) {
                        die('Curl failed: ' . curl_error($ch));
                    }        
                    // Close connection
                    curl_close($ch);
                    // FCM response
                    $response = json_decode($result);
                     
                    return 0;
        } catch (Exception $e) {
            Log::info("Complete Service API Error: " . $e->getMessage());
        }    
    }

    //this fucntion use otp verify
    public function OTPVerify(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'otp' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $userDetails = auth()->user();
          $OTPVerify =  OTPModel::where('user_id',$userDetails->id)->where('otp',$request->otp)->first();
          if(empty($OTPVerify))
          {
            $datas = [
                'status'  => 400,
                'message' => "OTP Not Valid",
            ];

            return response()->json($datas, 400);
          }

          $data = [
            'status'  => 200,
            'message' => "OTP Verify Successfully",
            'data'    =>[],
        ];
        return response()->json($data, 200);
        } catch (Exception $e) {
            Log::info("OTP Verify API Error: " . $e->getMessage());
        }    
    }


}
