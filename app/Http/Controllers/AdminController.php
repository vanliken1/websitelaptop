<?php

namespace App\Http\Controllers;

use App\Models\Donhang;
use App\Models\Sanpham;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        $sanpham_count=Sanpham::count();
        $users_count=User::where('level',0)->count();
        $order_count=Donhang::count();
        return view('admin.index',['sanpham_count'=>$sanpham_count,'user_count'=>$users_count,'order_count'=>$order_count]); 
    }
}
