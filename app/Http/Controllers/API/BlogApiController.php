<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class BlogApiController extends Controller
{
    
    public function getBlogList(Request $request){
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $q = Blog::with('User:id,first_name,last_name,image');
            if($request->has('keyWord') && $request->keyWord != ''){
                $q->where('title', 'ilike', $request->keyWord.'%');
            }
            $blogs = $q->orderBy('id','DESC')->paginate(env('PER_PAGE'));
            // dd($blogs);
            if(!$blogs){
                $response['message'] = "Blog not found";
                $response['data'] =  [];
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
                return response()->json($response, $response['status']);
            }
                $response['message'] = "Blog found";
                $response['data'] =  $blogs;
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            return response()->json($response, $response['status']);
            
        } catch (\Exception $e) {
            DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }
}
