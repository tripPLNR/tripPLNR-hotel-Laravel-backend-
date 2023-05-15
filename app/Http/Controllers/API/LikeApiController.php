<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LikeApiController extends Controller
{
    public function addRemoveLike(Request $request){
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
            $userId = Auth::id();
            
            $isLike = Like::where('product_id',$productId)->where('user_id',$userId)->where('product_type',$request->type)->count();
            if($isLike){
                $isDeleted = Like::where('product_id',$productId)->where('user_id',$userId)->delete();  
                if($isDeleted){
                    $response['message'] = $request->type." unliked successfully";
                    $response['success'] = TRUE;
                    $response['status'] = STATUS_OK;
                }
            }else{
                $likeObj = new Like();
                $likeObj->product_id = $productId;
                $likeObj->user_id = $userId;
                $likeObj->product_type = $request->type;
                if($likeObj->save()){
                    $response['message'] = $request->type." liked successfully";
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
