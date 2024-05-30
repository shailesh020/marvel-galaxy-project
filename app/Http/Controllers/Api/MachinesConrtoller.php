<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\PurchaseHistory;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MachinesConrtoller extends Controller
{
      //this function use machine list
      public function machinList(Request $request)
      {
     
           try{
            $userDetails = auth()->user();
             $machinList = PurchaseHistory::where('client_id',$userDetails->id)->get();
             $dataDetails = [];
             if(count($machinList)>0)
             {
                 foreach($machinList as $listData)
                 {
                  $dataDetails['id'] = $value->id;
                  $dataDetails['owner_name'] = isset($value->client->name) ? $value->client->name :'';
                  $dataDetails['machine_code'] = isset($value->machine->code) ? $value->machine->code:'';
                 }
             }
  
             $data = [
              'status'  => 200,
              'message' => "Machine Successfully",
              'data'    => $dataDetails,
          ];
  
          return response()->json($data, 200);
  
           } catch (Exception $e) {
              Log::info("Machine List API Error: " . $e->getMessage());
          }    
      }

      //this function use machine details
      public function machineDetails(Request $request)
      {
        try{

            
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $machinDetails = PurchaseHistory::where('id',$request->id)->first();
            if(empty($machinDetails ))
            {

                $datas = [
                    'status'  => 400,
                    'message' => "Id Not Found",
                ];

                return response()->json($datas, 400);
            }

            $machineData['id'] = $machinDetails->id;
            $machineData['owner_name'] = isset($machinDetails->client->name) ? $machinDetails->client->name :'';
            $machineData['machine_code'] = isset($machinDetails->machine->code) ? $machinDetails->machine->code:'';
            $machineData['machine_name'] = isset($machinDetails->machine->name) ? $machinDetails->machine->name:'';
            $machineData['machine_address'] = isset($machinDetails->machine_address) ? $machinDetails->machine_address:'';
            $data = [
                'status'  => 200,
                'message' => "Machine Details Successfully",
                'data'    => $machineData,
            ];
    
            return response()->json($data, 200);
        } catch (Exception $e) {
            Log::info("Machine Details API Error: " . $e->getMessage());
        }   
      }

      //this fucntion use edit machine 
      public function machinEdit(Request $request)
      {
           try{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'address' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $machinEdit = PurchaseHistory::where('id',$request->id)->first();
            if(empty($machinEdit ))
            {

                $datas = [
                    'status'  => 400,
                    'message' => "Id Not Found",
                ];

                return response()->json($datas, 400);
            }
            $machinEdit->machine_address = $request->address;
            $machinEdit->update();

            $data = [
                'status'  => 200,
                'message' => "Machine Edit Successfully",
                'data'    => [],
            ];
    
            return response()->json($data, 200);
           } catch (Exception $e) {
            Log::info("Machine Details API Error: " . $e->getMessage());
        }  
      }
}
