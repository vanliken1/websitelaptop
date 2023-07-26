<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CpuController;
use App\Http\Controllers\DohoaController;
use App\Http\Controllers\DonhangController;
use App\Http\Controllers\GiamgiaController;
use App\Http\Controllers\KhuyenmaiController;
use App\Http\Controllers\LoaiSPController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LuutruController;
use App\Http\Controllers\ManhinhController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\SanphamController;
use App\Http\Controllers\ThuonghieuController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\Khuyenmai;
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

route::middleware([ktAdmin::class])->group(function () {
    route::prefix('admin')->group(function () {
        route::get('/', [AdminController::class, 'index']);
        route::post('/filter-date', [AdminController::class, 'filterdate']);
        route::post('/filter-date2', [AdminController::class, 'filterdate2']);
        route::post('/rs30day', [AdminController::class, 'rs30ngayqua']);
        route::get('/infoadmin', [UserController::class, 'infoadmin']);
        route::put('/updateadmin', [UserController::class, 'updateadmin']);
        route::middleware([ktSuperAdmin::class])->prefix('users')->group(function () {
            route::get('/', [UserController::class, 'index']);
            route::post('/store', [UserController::class, 'store']);
            // route::delete('destroy/{id}', [UserController::class, 'destroy']);
            route::get('edit/{id}', [UserController::class, 'edit']);

            route::post('update', [UserController::class, 'update']);
        });
        Route::middleware([ktAdmindm::class])->group(function () {
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
        });
        route::middleware([ktAdminbn::class])->prefix('banner')->group(function () {
            route::get('/', [BannerController::class, 'index']);
            route::post('store', [BannerController::class, 'store']);
            route::delete('destroy/{id}', [BannerController::class, 'destroy']);
            route::get('edit/{id}', [BannerController::class, 'edit']);
            route::post('update', [BannerController::class, 'update']);
        });
        route::middleware([ktAdminsp::class])->prefix('product')->group(function () {
            route::get('/', [SanphamController::class, 'index']);
            route::get('/create', [SanphamController::class, 'create']);
            route::post('store', [SanphamController::class, 'store']);
            route::delete('destroy/{id}', [SanphamController::class, 'destroy']);
            route::get('edit/{id}', [SanphamController::class, 'edit']);
            // route::post('update', [SanphamController::class, 'update']);
            route::put('update', [SanphamController::class, 'update']);
            Route::get('lockm', [KhuyenmaiController::class, 'lockm']);
        });
        route::middleware([ktAdmingg::class])->prefix('giamgia')->group(function () {
            route::get('/', [GiamgiaController::class, 'index']);
            route::post('store', [GiamgiaController::class, 'store']);
            route::delete('destroy/{id}', [GiamgiaController::class, 'destroy']);
            route::get('edit/{id}', [GiamgiaController::class, 'edit']);
            route::post('update', [GiamgiaController::class, 'update']);
        });

        route::middleware([ktAdminkm::class])->prefix('khuyenmai')->group(function () {
            route::get('/', [KhuyenmaiController::class, 'index']);

            route::get('chitiet/{id}', [KhuyenmaiController::class, 'chitiet']);
            route::post('storekm', [KhuyenmaiController::class, 'storekm']);
            route::get('editkm/{id}', [KhuyenmaiController::class, 'editkm']);
            route::post('updatekm', [KhuyenmaiController::class, 'updatekm']);
            route::delete('destroykm/{id}', [KhuyenmaiController::class, 'destroykm']);
            route::post('store', [KhuyenmaiController::class, 'store']);
            route::delete('destroy/{id}', [KhuyenmaiController::class, 'destroy']);
            route::get('edit/{id}', [KhuyenmaiController::class, 'edit']);
            route::post('update', [KhuyenmaiController::class, 'update']);

            route::get('them/{id}', [KhuyenmaiController::class, 'them']);
            route::post('them', [KhuyenmaiController::class, 'themstore']);
            route::post('capnhat', [KhuyenmaiController::class, 'capnhat']);
            

            route::get('editform/{id}', [KhuyenmaiController::class, 'editform']);
            route::put('updateform', [KhuyenmaiController::class, 'updateform']);
        });
        route::middleware([ktAdmindh::class])->prefix('donhang')->group(function () {
            route::get('/', [DonhangController::class, 'index']);
            route::get('chitiet/{id}', [DonhangController::class, 'chitietdonhang']);
            route::delete('destroy/{id}', [GiamgiaController::class, 'destroy']);
        });
    });
});
route::post('/admin/khuyenmai/capnhatajax', [KhuyenmaiController::class, 'capnhatajax']);
route::post('/updatesoluong', [DonhangController::class, 'updatesoluong']);
route::post('/updateqty', [DonhangController::class, 'updateqty']);
//Nguoi dung
route::get('/', [PagesController::class, 'trangchu']);
//trang san pham ALL
route::get('/laptop', [PagesController::class, 'trangsanpham']);
route::get('/laptop/{slugdanhmuc}', [PagesController::class, 'sanphamtheodanhmuc']);
route::get('/chitiet/{slugsanpham}', [PagesController::class, 'chitiet']);
route::get('/search', [PagesController::class, 'search']);

//Gio hang
route::get('/cart', [CartController::class, 'index']);
route::get('/cart/add/{id}', [CartController::class, 'add']);
route::post('/cart/add/{id}', [CartController::class, 'addajax']);
route::get('/cart/remove/{id}', [CartController::class, 'remove']);
route::post('/cart/edit', [CartController::class, 'edit']);
route::post('/cart/xoaAll', [CartController::class, 'xoatatca']);


//Dang nhap dang ky user
route::get('/dangnhap', [LoginController::class, 'loginview']);
route::post('/dangnhap', [LoginController::class, 'login']);
route::post('/dangxuat', [LoginController::class, 'logoutuser']);
route::post('/dangky', [LoginController::class, 'dangky']);
route::get('/quenmatkhau', [LoginController::class, 'quenmatkhau']);
route::post('/khoiphucmatkhau', [LoginController::class, 'khoiphucmatkhau']);
route::get('/newpass', [LoginController::class, 'matkhaumoi']);
route::put('/updatenewpass', [LoginController::class, 'updatematkhaumoi']);
//dang nhap gg
route::get('/login-google', [LoginController::class, 'logingg']);
route::get('/users/google/callback', [LoginController::class, 'callbackgg']);

//Thanh toán
route::get('/thanhtoan', [CartController::class, 'trangthanhtoan'])->middleware('ktUser');
route::post('/savethanhtoan', [CartController::class, 'save_thanhtoan']);
route::get('/returnVNP', [CartController::class, 'returnVNPAY']);
route::get('/finish', [CartController::class, 'finish'])->middleware('ktUser');
//Coupon
route::post('/checkcoupon', [CartController::class, 'check_coupon'])->middleware('ktUser');
route::get('/xoama', [CartController::class, 'unsetcoupon']);

//gui mail
route::get('/sendmail', [CartController::class, 'trangthanhtoan'])->middleware('ktUser');

//Thong tin người dùng và lịch sử đơn hàng
route::get('/history', [PagesController::class, 'history']);
route::get('history-details/{id}', [PagesController::class, 'chitiethistory']);
route::get('/info', [PagesController::class, 'infouser']);
route::put('/updateuser', [PagesController::class, 'updateuser']);
