<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Like;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            DB::beginTransaction();
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8'
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
                'email.unique' => 'This email address already taken.',
                'email.email' => 'Please enter valid email address.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }

            $requestData = $request->all();
            $userObj = new User;
            $userObj->first_name = $requestData['first_name'] ?? "";
            $userObj->last_name = $requestData['last_name'] ?? "";
            $userObj->email =  strtolower($requestData['email'] ?? "");;
            $userObj->password = bcrypt($requestData['password']);
            $userObj->device_token = $requestData['device_token'] ?? "";
            $userObj->device_type = $requestData['device_type'] ?? "";

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(IMAGE_UPLOAD_PATH, $fileName);
                $userObj->image = $fileName;
            }

            if ($userObj->save()) {
                $userObj->access_token = $userObj->createToken($userObj->id . ' token ')->accessToken;
                $token = $userObj->createToken($userObj->id . ' token ')->accessToken;
            }
            if ($token) {
                DB::commit();
            }
            $response['data'] = $token;
            $response['success'] = TRUE;
            $response['message'] = "User registered successfully";
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function login(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $rules = [
                'email' => 'required|email:rfc,dns',
                'password' => 'required'
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
                'email.email' => 'Please enter valid email address.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errorResponse = validation_error_response($validator->errors()->toArray());
                return response()->json($errorResponse, $response['status']);
            }

            $requestData = $request->all();
            $dataObj = User::login($request);

            if ($dataObj['status'] != 200) {
                $response['message'] = $dataObj['message'];
                $response['status'] = $dataObj['status'];
                return response()->json($response, $response['status']);
            }
            $user = $dataObj['user'];

            $userObj = User::select('id', 'first_name', 'last_name', 'email')->find($user->id);
            $userObj->device_token = $requestData['device_token'] ?? "";
            $userObj->device_type = $requestData['device_type'] ?? "";
            if ($userObj->save()) {
                $token = $userObj->createToken($userObj->id . ' token ')->accessToken;
                $userObj->access_token = $token;
            }
            $response['message'] = "Login successfully";
            $response['data'] =  $userObj;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function socialLogin(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            $post_data = $request->all();
            $isNewAccount = FALSE;
            $rules = [
                'social_id' => 'required',
            ];

            $messages = [
                'social_id.required' => 'The social id cannot be empty',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                return response()->json($response, 301);
            }
            // $email_exist = User::where('email', $post_data['email'])->count();
            $email_exist = User::where('social_id', $post_data['social_id'])->count();
            if ($email_exist) {
                $userObj = User::where('social_id', $post_data['social_id'])->first();
                // $social_id_exist = User::where('email', $post_data['email'])->where('social_id', $post_data['social_id'])->count();
                // if (!$social_id_exist) {
                //     $userObj->social_id = $post_data['social_id'];
                //     $userObj->save();
                // }
            } else {
                $isNewAccount = TRUE;
                $userObj = new User;
                $userObj->social_id = $post_data['social_id'];
                $userObj->first_name = $post_data['first_name'] ?? "";
                $userObj->last_name = $post_data['last_name'] ?? "";
                $userObj->email = $post_data['email'] ?? NULL;
                $userObj->password = SOCIAL_PASS;
                $userObj->save();
            }
            $userObj->device_token = $post_data['device_token'] ?? "";
            $userObj->device_type = $post_data['device_type'] ?? "";
            if ($userObj->save()) {
                $response['data'] = $userObj;
                $response['token'] = $userObj->createToken($userObj->id . ' token ')->accessToken;
                $response['message'] = "Login successfully";
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            DB::beginTransaction();
            $userObj = User::find($request->user()->id);
            $userObj->device_type = "";
            $userObj->device_token = "";
            $userObj->save();

            $request->user()->token()->revoke();
            $response['message'] = LOGOUT_SUCCESSFULLY;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        return response()->json($response, $response['status']);
    }

    public function changePassword(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            DB::beginTransaction();
            $rules = [
                'current_password' => 'required|min:8',
                'password' => 'required|confirmed|min:8',
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
                'password.confirmed' => 'Confirm password does not match',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return $response;
            }

            $dataObj = User::changePassword($request);
            $response['message'] = $dataObj['message'];
            if ($dataObj['status'] == 200) {
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

    public function deactivateAccount(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            DB::beginTransaction();

            $dataObj = User::deactivateAccount($request);
            $response['message'] = $dataObj['message'];
            if ($dataObj['status'] == 200) {
                $response['success'] = TRUE;
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

    public function updateAccount(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            DB::beginTransaction();
            $rules = [
                'first_name' => 'required|min:3|max:25',
                'last_name' => 'required|min:3|max:25',
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return $response;
            }
            $userObj = User::find(Auth::user()->id);
            if (!$userObj) {
                $response['message'] = "User does not exist.";
                $response['status'] = STATUS_NOT_FOUND;
                return $response;
            }
            $userObj->first_name = $request->first_name ?? '';
            $userObj->last_name = $request->last_name ?? '';
            if ($userObj->save()) {
                $response['success'] = TRUE;
                $response['message'] = "User updated successfully.";
                $response['status'] = STATUS_OK;
            }
        } catch (\Exception $e) {
            DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

    public function restoreAccount(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;
        try {
            DB::beginTransaction();
            $rules = [
                'email' => 'required|email:rfc,dns',
                'password' => 'required|min:8'
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return $response;
            }
            $dataObj = User::restoreAccount($request);
            $response['message'] = $dataObj['message'];
            if ($dataObj['status'] == 200) {
                $response['success'] = TRUE;
                $response['status'] = $dataObj['status'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            unset($response['data']);
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }

    public function deleteAccount(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            DB::beginTransaction();

            $dataObj = User::deleteAccount($request);
            $response['message'] = $dataObj['message'];
            if ($dataObj['status'] == 200) {
                $userId = Auth::user()->id;

                Favorite::where('user_id', $userId)->delete();
                Like::where('user_id', $userId)->delete();
                $response['success'] = $dataObj['success'];
                $response['status'] = $dataObj['status'];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }
}
