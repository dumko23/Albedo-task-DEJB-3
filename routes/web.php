<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('index');
//});
Route::get('getMembers', [MemberController::class, 'getMembers']);
Route::get('getMembersCount', [MemberController::class, 'getMembersCount']);
Route::get('/{any}',function (){
    return view('index');
})->where('any', '.*');

//Route::get('/members', [MemberController::class, 'index'])
//    ->name('members');

//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('send', [MemberController::class, 'send']);
Route::post('update', [MemberController::class, 'update']);
Route::post('uploadFile', [MemberController::class, 'uploadFile']);

