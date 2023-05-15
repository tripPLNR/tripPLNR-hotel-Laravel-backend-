<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FavoriteApiController extends Controller
{
    
    public function addRemove(Request $request){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try{
            // DB::beginTransaction();
            $rules = [
                'blogId' => 'required',
                'type' => 'required|min:3',
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }
            $blogId = $request->blogId;
            $userId = Auth::id();
            $isFavorite = Favorite::where('blog_id',$blogId)->where('user_id',$userId)->count();
            if($isFavorite){
                $isDeleted = Favorite::where('blog_id',$blogId)->where('user_id',$userId)->delete();  
                if($isDeleted){
                    $response['message'] = "Remove from favorites";
                    // $response['data'] =  $userObj->access_token;
                    $response['success'] = TRUE;
                    $response['status'] = STATUS_OK;
                }
            }else{
                $favoriteObj = new Favorite();
                $favoriteObj->blog_id = $blogId;
                $favoriteObj->user_id = $userId;
                $favoriteObj->type = $request->type;
                if($favoriteObj->save()){
                    $response['message'] = "Added in favorites";
                    // $response['data'] =  $userObj->access_token;
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
