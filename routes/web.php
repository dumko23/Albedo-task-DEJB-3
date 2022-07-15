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
    return view('home-admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin-dashboard', ['title' => 'Admin Page']);
    });
    Route::get('/admin/member-info/{memberId}', function () {
        return view('admin-dashboard', ['title' => 'Admin / Member Info']);
    });

    Route::controller(MembersAdminController::class)->group(function () {
        Route::get('getMembersInfo', 'getMembersInfo');
        Route::get('getMemberFullData/:{memberId}', 'getMemberFullData');

        Route::post('/editMember', 'editMember');
        Route::post('/deleteMember', 'deleteMember');
        Route::post('/toggleVisibility', 'toggleVisibility');
    });
});


/*
 * Public Routes
 */

Route::get('/', function () {
    return view('index', ['title' => 'Registration Page']);
});
Route::get('/members', function () {
    return view('index', ['title' => 'Member List']);
});
Route::controller(MemberController::class)->group(function () {
    Route::post('send', 'send');
    Route::post('update', 'update');
    Route::post('uploadFile', 'uploadFile');
});

