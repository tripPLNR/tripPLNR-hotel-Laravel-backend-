<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    //
    public function forgotPassword(Request $request)
    {
        
        $response = [];
        $response['success'] = FALSE;
        $response['status'] = STATUS_BAD_REQUEST;

        try {
            DB::beginTransaction();
            $rules = [
                'email' => 'required|email:rfc,dns',
            ];
            $messages = [
                'required' => 'The :attribute field is required.',
                'email.email' => 'Please enter valid email address.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                $response['status'] = UNPROCESSABLE_ENTITY;
                return $response;
            }

            $userObj = User::where('email', strtolower($request->get('email')))->first();
            if (!$userObj) {
                $response['message'] = "Email id does not exist.";
                $response['status'] = STATUS_NOT_FOUND;
                return $response;
            }
           
            $token = generateRandomToken(50, $request->get('email'));
            $tokenMailObj = ForgotPasswordMail::where('email', $request->get('email'))->first();
            if (!$tokenMailObj) {
                $tokenMailObj = new ForgotPasswordMail;
            }
            $tokenMailObj->email = $request->get('email');
            $tokenMailObj->token = $token;
            $currentTime = date("Y-m-d H:i:s");
            $mailExpireTime = date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime($currentTime)));
           
            $tokenMailObj->expired_at = $mailExpireTime;
            $tokenMailObj->save();

            $mailData = []; 
            $mailData['name'] = $userObj->first_name . ' ' . $userObj->last_name ?? '';

            $mailData['link'] = route('password.reset', [$token, 'email' => $request->get('email')]);
            
            // Mail::to($request->user()->email)->send(new ForgotPassword($mailData));
            Mail::to($request->email)->send(new ForgotPassword($mailData));
            $response['message'] = 'Please check your email to reset password';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }
        DB::commit();
        return response()->json($response, $response['status']);
    }


    public function checkPwd(Request $request, $token)
    {
       
        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
            $expiry  = Carbon::now()->subMinutes( 3 );


        $userObj = ForgotPasswordMail::firstWhere('token', $token);
        if (!is_null($userObj)) {
            
            if ($userObj->isExpire()) {
                return redirect()->back()->with('success', 'Link has been expired or Invalid');;
            } else {

                $user = User::firstWhere('email', $userObj->email);
                $user->password = bcrypt($request->password) ?? $userObj->password;
                $user->save();
                $userObj->delete();
                return redirect()->back()->with('success', 'Your password updated successfully');
            }
        } else {
            return redirect()->back()->with('success', 'Link has been expired or Invalid');
        }
    }
   
}
