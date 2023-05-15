<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogApiController;
use App\Http\Controllers\API\FavoriteApiController;
use App\Http\Controllers\API\LikeApiController;
use App\Http\Controllers\API\ShareApiController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\SettingApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\CountryApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => ['\App\Http\Middleware\LogAfterRequest::class']], function () {

    // App basic details, term & condition and privacy policy
    Route::get('basic-app-details', [HomeController::class, 'BasicApplicationDetails']);
    Route::get('settingLink/{title}', [HomeController::class, 'settingLink']);

    // User sign up and login
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);

    // User account restore
    Route::post('restore-account', [AuthController::class, 'restoreAccount']);

    // User password forgot
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
 
    // Get Countries list
    Route::get('get-countries', [CountryApiController::class, 'getCountriesList']);

    // User Social login
    Route::post('social-login', [AuthController::class, 'socialLogin']);
    Route::post('get-blog',[BlogApiController::class,'getBlogList']);
    Route::get('get-blogs',[BlogApiController::class,'getBlogList']);
    Route::get('term-condition',[SettingApiController::class,'getTermCondition']);
    Route::get('about-us',[SettingApiController::class,'getAboutUs']);
    Route::get('privacy-policy',[SettingApiController::class,'getPrivacyPolicy']);


    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('deactivate-account', [AuthController::class, 'deactivateAccount']);
        Route::post('delete-account', [AuthController::class, 'deleteAccount']);
        Route::post('update-profile', [AuthController::class, 'updateAccount']);
        Route::post('logout', [AuthController::class, 'logout']);
        
        Route::post('add-favorite',[FavoriteApiController::class,'addRemove']);
        Route::post('add-like',[LikeApiController::class,'addRemoveLike']);
        Route::post('share-count',[ShareApiController::class,'addShareCount']);
        

    });
});
