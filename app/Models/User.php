<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'email'
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function login($request)
    {
        $requestData = $request->all();
        $response['status'] = STATUS_BAD_REQUEST;
        $response['message'] = ENTER_VALID_CREDENTIAL;

        $remember_me = $request->has('remember_me') ? true : false;

        $userObj  = User::Where('email', $request->email)->first();
        if ($userObj) {
            if ($userObj->is_block == '0') {
                if (Auth::validate(['email' => $userObj->email, 'password' => $requestData['password']], $remember_me)) {
                    $response['user'] = $userObj;
                    $response['status'] = STATUS_OK;
                    $response['message'] = "Login successfully";
                } else {
                    $response['status'] = STATUS_BAD_REQUEST;
                    $response['message'] = ENTER_VALID_CREDENTIAL;
                }
            } else {
                $response['status'] = STATUS_BAD_REQUEST;
                $response['message'] = ACCOUNT_BLOCKED_BY_ADMIN;
            }
        }
        return $response;
    }

    static function changePassword($request)
    {
        $requestData = $request->all();
        $userObj = User::find(Auth::user()->id);
        if (!Hash::check($request->get('current_password'), $userObj->password)) {
            $response['message'] = WRONG_PASSWORD;
            $response['status'] = STATUS_BAD_REQUEST;
            return $response;
        }

        $userObj->password = Hash::make($requestData['password']);
        if ($userObj->save()) {
            /* $mailData = [];
            $mailData['name'] = $userObj->name ?? $userObj->email;
            $mailData['type'] = 'Password Change';
            $mailData['proposal'] = 'Congratulations';
            $mailData['subject'] = 'Change Password';
            $mailData['content'] = PASSWORD_CHANGED;
            Mail::to($userObj->email)->send(new AccountConfirmation($mailData)); */
        }
        $response['message'] = PASSWORD_CHANGED_SUCCESSFULLY;
        $response['status'] = STATUS_OK;

        return $response;
    }

    static function deactivateAccount($request)
    {
        $response['status'] = STATUS_BAD_REQUEST;
        $response['message'] = ENTER_VALID_CREDENTIAL;
        $userObj = User::find(Auth::user()->id);
        if ($userObj->delete()) {
            $response['message'] = ACCOUNT_DEACTIVATED_SUCCESSFULLY;
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        }

        return $response;
    }

    static function restoreAccount($request)
    {
        $requestData = $request->all();

        $userObj  = User::withTrashed()->Where('email', $requestData['email'])->first();
        if ($userObj) {
            if (Hash::check($request->get('password'), $userObj['password'])) {
                $userObj->restore();

                $response['status'] = STATUS_OK;
                $response['message'] = ACCOUNT_RESTORE_SUCCESSFULLY;
            } else {
                $response['status'] = STATUS_BAD_REQUEST;
                $response['message'] = ENTER_VALID_CREDENTIAL;
            }
        }

        return $response;
    }

    static function deleteAccount($request)
    {
        $userObj = User::find(Auth::user()->id);
        $userObj->forceDelete();
        $request->user()->token()->revoke();

        $response['message'] = ACCOUNT_DELETED_SUCCESSFULLY;
        $response['success'] = TRUE;
        $response['status'] = STATUS_OK;

        return $response;
    }

    public static function webLogin($data)
    {
        $response = [];
        if (array_key_exists('username', $data)) {
            if (Auth::attempt(array('username' => $data['username'], 'password' => $data['password']))) {
                $user = User::where('username', $data['username'])->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect username or password';
            }
        } elseif (array_key_exists('email', $data)) {
            $userObj = User::where('email', strtolower($data['email']))->first();
            if (!$userObj) {
                $response['message'] = 'Please enter valid registered email.';
                return $response;
            }
            if (Auth::attempt(array('email' => strtolower($data['email']), 'password' => $data['password']))) {
                $user = User::where('email', strtolower($data['email']))->first();
                $response['user'] = $user;
            } else {
                $response['message'] = 'Incorrect password';
            }
        } else {
            $response['message'] = 'Email or username is required';
        }

        return $response;
    }

    public function getImageAttribute($value = '')
    {
        if (!empty($value)) {
            return asset('/uploads/profile/' . $value);
        }
        return asset('/admin/logo/user_logo.png');
    }

    public function getIsBlockedAttribute()
    {

        $isBlocked = 'Active';
        if ($this->is_block == '1') {
            $isBlocked = 'Blocked';
        }
        return $isBlocked;
    }

    public function UserAddress()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
}
