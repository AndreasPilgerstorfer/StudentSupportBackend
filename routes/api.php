<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|<<
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

################################################################### Images

//GET All Images - R
Route::get('images', [ImageController::class, 'index']);


Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    //POST new image - C
    Route::post('images', [ImageController::class, 'save']);

    //PUT existing image - U
    Route::put('images/{id}', [ImageController::class, 'update']);

    //DELETE image by id - D
    Route::delete('images/{id}', [ImageController::class, 'delete']);
});


################################################################### Courses

//GET All Courses - R
Route::get('courses', [CourseController::class, 'index']);

//GET Course by ID - R
Route::get('courses/{id}', [CourseController::class, 'findByID']);


Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    //POST new course - C
    Route::post('courses', [CourseController::class, 'save']);

    //PUT existing Course - U
    Route::put('courses/{id}', [CourseController::class, 'update']);

    //DELETE course by id - D
    Route::delete('courses/deleteById/{id}', [CourseController::class, 'deleteById']);

    //DELETE course by id - D
    Route::delete('courses/deleteByNumber/{number}', [CourseController::class, 'deleteByNumber']);
});


################################################################### Users

//GET All Users - R
Route::get('users', [UserController::class, 'index']);

//GET User by ID - R
Route::get('users/{id}', [UserController::class, 'findByID']);


Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    //POST new User - C
    Route::post('users', [UserController::class, 'save']);

    //PUT existing User - U
    Route::put('users/{id}', [UserController::class, 'update']);

    //DELETE User by id - D
    Route::delete('users/{id}', [UserController::class, 'delete']);
});

################################################################### Offer


//GET All Offers - R
Route::get('offers', [OfferController::class, 'index']);

//GET Offer By Offer-ID - R
Route::get('offers/findByOfferID/{id}', [OfferController::class, 'findByOfferID']);

//GET All Offers by Course ID - R
Route::get('offers/findByCourseID/{id}', [OfferController::class, 'findByCourseID']);

//GET All Open Offers by Course ID - R
Route::get('offers/findByCourseIDOpen/{id}', [OfferController::class, 'findByCourseIDOpen']);

//GET All Offers by User ID Teacher - R
Route::get('offers/findByUserIDTeacher/{id}', [OfferController::class, 'findByUserIDTeacher']);

//GET All Offers by User ID Offer - R
Route::get('offers/findByUserIDStudent/{id}', [OfferController::class, 'findByUserIDStudent']);


Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    //POST new Offer - C
    Route::post('offers', [OfferController::class, 'save']);

    //PUT existing Offer - U
    Route::put('offers/{id}', [OfferController::class, 'update']);

    //DELETE Offer by id - D
    Route::delete('offers/{id}', [OfferController::class, 'delete']);
});


################################################################### Message

//GET All Messages - R
Route::get('messages', [MessageController::class, 'index']);

//GET All Messages by Teacher ID - R
Route::get('messages/findByTeacherID/{id}', [MessageController::class, 'findByTeacherID']);


Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    //POST New Message - C
    Route::post('messages', [MessageController::class, 'save']);

    //PUT existing Message by MessageID - U
    Route::put('messages/{id}', [MessageController::class, 'update']);

    //DELETE Offer by id - D
    Route::delete('messages/{id}', [MessageController::class, 'delete']);
});


################################################################### Request


//GET All Requests - R
Route::get('requests', [RequestController::class, 'index']);

//GET All Pending Requests by Teacher ID - R
Route::get('requests/getPendingTeacher/{id}', [RequestController::class, 'getPendingRequestsTeacher']);


Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    //PUT existing Request by RequestID - U
    Route::put('requests/{id}', [RequestController::class, 'update']);

    //DELETE Request by id - D
    Route::delete('requests/{id}', [RequestController::class, 'delete']);

    //POST New Request - C
    Route::post('requests', [RequestController::class, 'save']);
});


################################################################### Utility

// POST Login
Route::post('auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['api', "auth.jwt"]], function(){
    // Logout
    Route::post('auth/logout', [AuthController::class, 'logout']);
});


