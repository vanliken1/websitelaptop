<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thuonghieu;
use App\Models\CPU;
use App\Models\Loaisp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    //
    function loginview()
    {
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        return view('clients.home.dangnhap',['thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp]);
    }
    function login(Request $r)
    {
        $credentials = $r->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Đăng nhập thành công
            return redirect('/');
        } else {
            session()->flash('error', 'Tài khoản không tồn tại');
            // Đăng nhập thất bại, chuyển hướng trở lại trang đăng nhập với thông báo lỗi
            return redirect('/dangnhap');
        }
    }
    function logoutuser()
    {
        auth()->logout();
        return redirect('/');
    }
    function dangky(Request $r)
    {
        $r->validate(
            [
                
                'tennguoidung' => 'min:3',
                'email'=>'unique:nguoidung|min:3|max:45|email',
                'diachi'=>'max:45',
                'sdt'=>'digits:10',
                'password' => 'max:50|min:2',


             


            ],
            [
                
                'tennguoidung.min' => 'Họ tên phải tối thiểu 3 ký tự',
                'email.unique'=>'email đã tồn tại',
                'email.min'=>'Email phai tối thiểu 3 ký tự',
                'email.max'=>'Email không vượt quá 45 ký tự',
                'diachi.max'=>'Địa chỉ không vượt quá 100 ký tự',
                'sdt.digits'=>'SĐT ko hợp lệ',
                'email.email'=>'Trường này phải là email',
                'password.min' => 'Mat khau toi thieu 2 ky tu',
                'password.max' => 'Mat khau qua 50 ky tu',
                

            ]
        );
        User::create([
            'tennguoidung'=>$r->tennguoidung,
            'email'=>$r->email,
            'sdt'=>$r->sdt,
            'diachi'=>$r->diachi,
            'password'=>Hash::make($r->password)
            
            

        ]);
        
        session()->flash('mess', 'Tao tai khoan thanh cong' );
        return redirect('/dangnhap');
    }
}
