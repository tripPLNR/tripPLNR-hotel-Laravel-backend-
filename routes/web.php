<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    //return view('welcome');

    $userId = $request->user()->id ?? NULL;

    if ($userId) {
        return redirect()->route('user.index');
    } else {
        return view('auth.login');
    }
})->name('/');

Auth::routes();
// Auth::routes(['login' => false]);
// Route::get('admin', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
// Route::post('admin', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::post('password/resets/{token}', 'App\Http\Controllers\API\ForgotPasswordController@checkPwd')->name('pwd.reset');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('blog/share/slug/{id}', 'App\Http\Controllers\Admin\BlogController@shareBlog')->name('blog.share');  
Route::get('blog/description/slug/{id}', 'App\Http\Controllers\Admin\BlogController@blogDescription')->name('blog.description');  

Route::group(['namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::group(['middleware' => ['auth']], function () {
            
        // Route::get('dashboard', function () {
        //     return view('home'); 
        // })->name('admin.dashboard');

        //  CATEGORY
        // Route::resource('category', CategoryController::class);
        // Route::get('category-delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

        // // SUB CATEGORY
        // Route::resource('sub-category', SubcategoryController::class);
        // Route::get('delete-sub-category/{id}', [SubcategoryController::class, 'delete'])->name('sub-category.delete');
        Route::get('change-password', 'SettingController@changePassword')->name('change-password');
        Route::post('save-password', 'SettingController@updatePassword')->name('save-password');

        // Blog  
        Route::resource('blog', BlogController::class);

        // user  
        Route::resource('user', UserController::class); 

        // TermCondition  
        Route::resource('term-condition', TermConditionController::class);

        // Aboutus  
        Route::resource('about-us', AboutusController::class);

        // Privacy policy  
        Route::resource('privacy-policy', PolicyController::class);
    });
});
 