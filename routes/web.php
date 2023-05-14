<?php

use App\Http\Controllers\ThuonghieuController;
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


route::prefix('admin')->group(function () {
    route::get('/', function () {
        return view('admin.index');
    });
    route::prefix('brand')->group(function () {
        route::get('/', [ThuonghieuController::class, 'index']); 
        route::get('create', [ThuonghieuController::class, 'create']);
        route::post('store', [ThuonghieuController::class, 'store']);
        route::delete('destroy/{id}', [ThuonghieuController::class, 'destroy']);
        route::get('edit/{id}', [ThuonghieuController::class, 'edit']);
        route::post('update', [ThuonghieuController::class, 'update']);
    }); 
});
