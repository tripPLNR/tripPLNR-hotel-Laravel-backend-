<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TermCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingApiController extends Controller
{
    
    public function getTermCondition(){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $termCondition = TermCondition::with('User:id,first_name,last_name,image')->where('type','condition')->first();
            if($termCondition){
                $response['message'] = 'Data found ';
                $response['data'] = $termCondition ?? '';
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
    
    public function getAboutUs(){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $termCondition = TermCondition::with('User:id,first_name,last_name,image')->where('type','aboutus')->first();
            if($termCondition){
                $response['message'] = 'Data found ';
                $response['data'] = $termCondition ?? '';
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
    
    public function getPrivacyPolicy(){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $termCondition = TermCondition::with('User:id,first_name,last_name,image')->where('type','policy')->first();
            if($termCondition){
                $response['message'] = 'Data found ';
                $response['data'] = $termCondition ?? '';
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
}
