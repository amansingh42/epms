<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\FieldController;
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

Auth::routes(['register'=>false]);

Route::group(['middleware' => ['auth']],function(){
    
    Route::get('/',[HomeController::class,'index'])->name('home');
    // Route::get('/dashboard',function(){
    //     return view('dashboard');
    // })->name('dashboard');

    Route::resource('/user',UserController::class);
    Route::resource('/role',RoleController::class);
    Route::resource('/report',ReportController::class);
    Route::resource('/field',FieldController::class);
    Route::resource('/designation',DesignationController::class);

    Route::post('/report/admin-info',[ReportController::class,'saveGenInfo'])->name('performance.geninfo');
    Route::get('/report/hr-info/{id}',[ReportController::class,'editHrInfo'])->name('performance.hrinfo');
    Route::patch('/report/update/hr-info/{id}',[ReportController::class,'updateHrInfo'])->name('report.update.hrinfo');
    
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
