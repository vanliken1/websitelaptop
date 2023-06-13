<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thuonghieu;
use App\Models\CPU;
use App\Models\Loaisp;
use App\Models\Social;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Socialite;
use Cart;
class LoginController extends Controller
{
    //
    function loginview()
    {
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        return view('clients.home.dangnhap', ['thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp]);
    }
    function login(Request $r)
    {
        $credentials = $r->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Đăng nhập thành công
            // dd(auth()->check());
            if(auth()->user()->level!=0){
                return redirect('/admin');
            }
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
        Session::forget('coupon');
        Cart::destroy();
        return redirect('/');
    }
    function dangky(Request $r)
    {
        $r->validate(
            [

                'tennguoidung' => 'min:3',
                'email' => 'unique:nguoidung|min:3|max:45|email',
                'diachi' => 'max:45',
                'sdt' => 'digits:10',
                'password' => 'max:50|min:2',





            ],
            [

                'tennguoidung.min' => 'Họ tên phải tối thiểu 3 ký tự',
                'email.unique' => 'email đã tồn tại',
                'email.min' => 'Email phai tối thiểu 3 ký tự',
                'email.max' => 'Email không vượt quá 45 ký tự',
                'diachi.max' => 'Địa chỉ không vượt quá 100 ký tự',
                'sdt.digits' => 'SĐT ko hợp lệ',
                'email.email' => 'Trường này phải là email',
                'password.min' => 'Mat khau toi thieu 2 ky tu',
                'password.max' => 'Mat khau qua 50 ky tu',


            ]
        );
        User::create([
            'tennguoidung' => $r->tennguoidung,
            'email' => $r->email,
            'sdt' => $r->sdt,
            'diachi' => $r->diachi,
            'password' => Hash::make($r->password),
            'level'=> 0,
            'trangthai'=> 1

        ]);

        session()->flash('mess', 'Tao tai khoan thanh cong');
        return redirect('/dangnhap');
    }
    function logingg()
    {
        // return Socialite::driver('google')->redirect();
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();

    }

    function callbackgg()
    {
        //kết nối tới tài khoản google
        // auth()->logout();
        $users = Socialite::driver('google')->stateless()->user();
        //Tìm id tk google = idnguoidungxahoi có trong bảng Social
        $authUser = Social::where('idnguoidungxahoi', $users->id)->first();
        //nếu như tài khoản đã tồn tại thì đang nhặp
        if ($authUser) {

            auth()->login($authUser->user);

        } else {
            $orang = User::where('email', $users->email)->first(); //Tìm user có email giống email gg
            //Nếu ko có email trùng với email đã tìm thì tạo mới
            if (!$orang) {
                $orang = User::create([
                    'tennguoidung' => $users->name,
                    'email' => $users->email,
                    'password' => '',
                    'diachi' => '',
                    'sdt' => '',
                    'level'=> 0,
                    'trangthai' => 1
                ]);
            }
            //dong thời tạo bên bảng Social một tài khoản mới 
            $taikhoanmoi = new Social([
                'idnguoidungxahoi' => $users->id,
                'emailnguoidungxahoi' => $users->email,
                'kieumangxahoi' => strtoupper('google'),
                'idnguoidung' => $orang->idnguoidung
            ]);
            // dd($taikhoanmoi);
            //Thiết lập mối quan hệ giữa bản Social và User nghĩa là idnguoidung Social=idnguoidung User
            $taikhoanmoi->user()->associate($orang);
            $taikhoanmoi->save();
            //Dang nhap tk user mới
            auth()->login($orang);
        }
        

        return redirect('/');
    }
}
