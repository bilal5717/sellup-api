<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\OtpController;
use App\Http\Controllers\api\Auth\AuthController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\Api\MobileController;
use App\Http\Controllers\Api\BikeController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\api\VideoController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\FashionAndBeautyController;
use App\Http\Controllers\Api\ElectronicsHomeController;
use App\Http\Controllers\api\BusinessIndustrialController;
use App\Http\Controllers\api\ServicesController;
use App\Http\Controllers\api\AnimalsController;
use App\Http\Controllers\Api\JobsController;
use App\Http\Controllers\Api\KidsController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\BooksAndHobbiesController;
use App\Http\Controllers\Api\FurnitureHomeController;
Route::prefix('auth')->group(function () {
    Route::get('/csrf-cookie', function () {
        return response()->json(['message' => 'CSRF cookie set']);
    });
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');


});
/* Signup via email OTP code */
Route::post('/send-sms-otp', [OtpController::class, 'sendSMSOtp']);
Route::post('/send-whatsapp-otp', [OtpController::class, 'sendWhatsappOtp']);
Route::post('/send-verification-code', [OtpController::class, 'sendEmailOtp']);
Route::post('/verify-email-otp', [OtpController::class, 'verifyEmailOtp']);
Route::post('/verify-phone-otp', [OtpController::class, 'verifyPhoneOtp']);
Route::post('/check-email', [AuthController::class, 'checkEmailExistence']);
Route::post('/check-phone', [OtpController::class, 'checkPhone']);
Route::post('/register', [AuthController::class, 'registerUsingEmail']);
Route::post('/register-phone', [AuthController::class, 'registerUsingPhone']);
    
/* Post ads routes  */
Route::post('/posts', [PostController::class, 'store']);
/* Mobiles Routes */
Route::get('/mobiles', [MobileController::class, 'index']);
Route::get('/tablets', [MobileController::class, 'getTabletProducts']);
Route::get('/mobile-phones', [MobileController::class, 'getMobileProducts']);
Route::get('/accessories', [MobileController::class, 'getAccessoryProducts']);
/* Route::get('/mobiles/{id}', [MobileController::class, 'showMobileDetails']); */
/* Bikes Routes */
Route::get('/bikes', [BikeController::class, 'index']);
Route::get('/bikes/{id}', [BikeController::class, 'show']);
/* Propert Routes */
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties-for-rent', [PropertyController::class, 'propertyRentAllDetails']);
Route::get('/properties-for-sale', [PropertyController::class, 'propertySaleAllDetails']);
Route::get('/lands', [PropertyController::class, 'showLandsDetails']);
/* Jobs Routes */
Route::get('/jobs', [JobsController::class, 'index']);
Route::get('/jobsProducts', [JobsController::class, 'getjobsProducts']);
/* Fashion And Beauty */
Route::get('/fashion-products', [FashionAndBeautyController::class, 'index']);
/* Electronics and Home  */
Route::get('/electronics', [ElectronicsHomeController::class, 'index']);
/* Business and agriculture  */
Route::post('/business-industrial', [BusinessIndustrialController::class, 'store']);
Route::get('/business-industrial-agriculture', [BusinessIndustrialController::class, 'index']);
/* services */
Route::get('/services', [ServicesController::class, 'index']);
/* Animals  */
Route::get('/animals', [AnimalsController::class, 'index']);
/* Books and hobbies */
Route::get('/books-sports-hobbies', [BooksAndHobbiesController::class, 'index']);
/* Furniture and home decor */
Route::get('/furniture-home-decor', [FurnitureHomeController::class, 'index']);
/* Kids */
Route::get('/kids', [KidsController::class, 'index']);
/* Kids */
Route::get('/vehicles', [VehicleController::class, 'index']);
/* Image and video urls */
Route::post('generate-image-url', [ImageController::class, 'generateUploadUrl']);
Route::post('generate-video-url', [VideoController::class, 'generateVideoUploadUrl']);
