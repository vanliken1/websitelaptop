<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CpuController;
use App\Http\Controllers\DohoaController;
use App\Http\Controllers\KhuyenmaiController;
use App\Http\Controllers\LoaiSPController;
use App\Http\Controllers\LuutruController;
use App\Http\Controllers\ManhinhController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\SanphamController;
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
    route::prefix('category')->group(function () {
        route::get('/', [LoaiSPController::class, 'index']); 
        route::get('create', [LoaiSPController::class, 'create']);
        route::post('store', [LoaiSPController::class, 'store']);
        route::delete('destroy/{id}', [LoaiSPController::class, 'destroy']);
        route::get('edit/{id}', [LoaiSPController::class, 'edit']);
        route::post('update', [LoaiSPController::class, 'update']);
    }); 
    route::prefix('ram')->group(function () {
        route::get('/', [RamController::class, 'index']); 
        route::get('create', [RamController::class, 'create']);
        route::post('store', [RamController::class, 'store']);
        route::delete('destroy/{id}', [RamController::class, 'destroy']);
        route::get('edit/{id}', [RamController::class, 'edit']);
        route::post('update', [RamController::class, 'update']);
    }); 
    route::prefix('cpu')->group(function () {
        route::get('/', [CpuController::class, 'index']); 
        route::post('store', [CpuController::class, 'store']);
        route::delete('destroy/{id}', [CpuController::class, 'destroy']);
        route::get('edit/{id}', [CpuController::class, 'edit']);
        route::post('update', [CpuController::class, 'update']);
    });
    route::prefix('manhinh')->group(function () {
        route::get('/', [ManhinhController::class, 'index']); 
        route::post('store', [ManhinhController::class, 'store']);
        route::delete('destroy/{id}', [ManhinhController::class, 'destroy']);
        route::get('edit/{id}', [ManhinhController::class, 'edit']);
        route::post('update', [ManhinhController::class, 'update']);
    });
    route::prefix('luutru')->group(function () {
        route::get('/', [LuutruController::class, 'index']); 
        route::post('store', [LuutruController::class, 'store']);
        route::delete('destroy/{id}', [LuutruController::class, 'destroy']);
        route::get('edit/{id}', [LuutruController::class, 'edit']);
        route::post('update', [LuutruController::class, 'update']);
    });
    route::prefix('dohoa')->group(function () {
        route::get('/', [DohoaController::class, 'index']); 
        route::post('store', [DohoaController::class, 'store']);
        route::delete('destroy/{id}', [DohoaController::class, 'destroy']);
        route::get('edit/{id}', [DohoaController::class, 'edit']);
        route::post('update', [DohoaController::class, 'update']);
    });
    route::prefix('banner')->group(function () {
        route::get('/', [BannerController::class, 'index']); 
        route::post('store', [BannerController::class, 'store']);
        route::delete('destroy/{id}', [BannerController::class, 'destroy']);
        route::get('edit/{id}', [BannerController::class, 'edit']);
        route::post('update', [BannerController::class, 'update']);
    });
    route::prefix('product')->group(function () {
        route::get('/', [SanphamController::class, 'index']); 
        route::post('store', [SanphamController::class, 'store']);
        route::delete('destroy/{id}', [SanphamController::class, 'destroy']);
        route::get('edit/{id}', [SanphamController::class, 'edit']);
        route::post('update', [SanphamController::class, 'update']);
    });
});
