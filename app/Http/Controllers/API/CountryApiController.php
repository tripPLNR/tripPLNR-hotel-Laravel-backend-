<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Country;


class CountryApiController extends Controller
{
    public function getCountriesList(Request $request){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
          
            $q = Country::orderBy('country','ASC');
            if($request->has('keyWord') && $request->keyWord != ''){
                $q->where('country', 'ilike', $request->keyWord.'%');
            }
            $countryObj = $q->get();
            if(!$countryObj){
                $response['message'] = "Countries not found";
                $response['data'] =  [];
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
                return response()->json($response, $response['status']);
            }
                $response['message'] = "Countries found";
                $response['data'] =  $countryObj;
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
           
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
}
