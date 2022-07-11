<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembersAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Auth::routes();

/*
 * Admin Routes
 */

Route::get('/admin', function () {
    return view('home');
});
Route::get('/admin/dashboard', function () {
    return view('admin-dashboard', ['title' => 'Admin Page']);
})->middleware('auth')->name('Admin Page');
Route::get('/admin/member-info/{memberId}', function () {
    return view('admin-dashboard', ['title' => 'Admin / Member Info']);
})->middleware('auth')->name('Member Info');

Route::get('getMembersInfo', [MembersAdminController::class, 'getMembersInfo'])
    ->middleware('auth');
Route::get('getMemberFullData/:{memberId}', [MembersAdminController::class, 'getMemberFullData'])
    ->middleware('auth');

Route::post('/editMember', [MembersAdminController::class, 'editMember'])
    ->middleware('auth');
Route::post('/deleteMember', [MembersAdminController::class, 'deleteMember'])
    ->middleware('auth');

/*
 * Public Routes
 */

Route::get('/', function () {
    return view('index', ['title' => 'Registration Page']);
});
Route::get('/members', function () {
    return view('index', ['title' => 'Member List']);
});

Route::post('send', [MemberController::class, 'send']);
Route::post('update', [MemberController::class, 'update']);
Route::post('uploadFile', [MemberController::class, 'uploadFile']);


