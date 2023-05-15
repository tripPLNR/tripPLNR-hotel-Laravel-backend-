<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShareCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShareApiController extends Controller
{
    public function addShareCount(Request $request){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try{
            // DB::beginTransaction();
            $rules = [
                'productId' => 'required',
                'type' => [
                        'required',
                        'min:3',
                        Rule::in(['Blog']),
                    ]
                   
                ];

            $messages = [
                'required' => 'The :attribute field is required.',
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }
            $productId = $request->productId;

            
            $shareCountObj = ShareCount::where('product_id',$productId)->where('product_type',$request->type)->first();
            if($shareCountObj){
                $shareCountObj->share_count = $shareCountObj->share_count+1;
                if($shareCountObj->save()){
                    $response['message'] = $request->type." share cout updated successfully";
                    $response['success'] = TRUE;
                    $response['status'] = STATUS_OK;
                }
            }else{
                $shareCountObj = new ShareCount();
                $shareCountObj->product_id = $productId;
                $shareCountObj->share_count = 1;
                $shareCountObj->product_type = $request->type;
                if($shareCountObj->save()){
                    $response['message'] = $request->type." share cout updated successfully";
                    $response['success'] = TRUE;
                    $response['status'] = STATUS_OK;
                }
            }

        }catch (\Exception $e) {
            // DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
}
