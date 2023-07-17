<?php

namespace App\Http\Controllers;

use App\Mail\quenmk;
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
use Illuminate\Support\Str;
use Mail;
class LoginController extends Controller
{
    //
    function loginview(Request $r)
    {
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Đăng nhập,đăng ký';
        $meta_keyword = 'dangnhapdangky,trang đăng nhập,đăng ký haovan';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        return view('clients.home.dangnhap', ['thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp,
        'meta_desc' => $meta_desc,
        'meta_keyword' => $meta_keyword,
        'meta_title' =>  $meta_title,
        'url_canonical' => $url_canonical]);
    }
    function login(Request $r)
    {
   
        $credentials = $r->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Đăng nhập thành công
            // dd(auth()->check());
            if(auth()->user()->level!=0&&auth()->user()->trangthai==1){
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

                'tennguoidung' => 'min:3|max:255',
                'email' => 'unique:nguoidung|max:255',
                'password' => 'required|max:50|min:2',
                'sdt' => 'digits:10',
                'diachi' => 'required|max:255',





            ],
            [
                'tennguoidung.min' => 'Tên tối thiểu 3 ký tự',
                'tennguoidung.max' => 'Tên quá dài',
                'email.unique' => 'Email đã tồn tại',
                'email.max' => 'Email không hợp lệ',
                'password.max' => 'Mật khẩu quá dài',
                'password.min' => 'Mật khẩu quá ngắn',
                'sdt.digits' => 'SĐT không hợp lệ',
                'diachi.max' => 'Địa chỉ quá dài',
                


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
          
            if ($authUser->user->level != 0 && $authUser->user->trangthai == 1) {
                auth()->login($authUser->user);
                return redirect('/admin');
            } else {
                auth()->login($authUser->user);
                return redirect('/');
            }

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
            // dd($orang->idnguoidung);
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
            if ($orang->level != 0 && $orang->trangthai == 1) {
                auth()->login($orang);
                return redirect('/admin');
            } else {
                auth()->login($orang);
                return redirect('/');
            }
            // auth()->login($orang);
        }
        

        return redirect('/');
    }
    function quenmatkhau(Request $r){
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Quên mật khẩu';
        $meta_keyword = 'quenmatkhau,forgetpassword haovan';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        return view('clients.home.quenmatkhau',['thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp,'meta_desc' => $meta_desc,
        'meta_keyword' => $meta_keyword,
        'meta_title' =>  $meta_title,
        'url_canonical' => $url_canonical]);
    }
    function khoiphucmatkhau(Request $r)
    {
        // dd($r->all());  
        $data=$r->all();
        $user=User::where('email',$data['email_account'])->get();
        // dd($user);
        foreach($user as $item){
            $idnguoidung=$item->idnguoidung;
        }
        if($user){
            $demuser=$user->count();
            //Dem xem có bao nhiêu tài khoản có email giống với email_account
            if($demuser==0){
                session()->flash('error','Email chưa được đăng ký để khôi phục');
                // dd(session()->all());
                return redirect('/quenmatkhau');

             }
             else{
                $token_random=Str::random(20);
                $u=User::findorFail($idnguoidung);
                // dd($u);
                $u->token=$token_random;
                $u->save();

                $dataEmail = [
                    'linkreset'=>url('/newpass?email='.$data['email_account'].'&token='.$token_random),
                    

                ];
                Mail::to($data['email_account'])->send(new quenmk($dataEmail));
                session()->flash('thongbao','Gửi mail thành công vui lòng check mail để reset password');

                return redirect('/quenmatkhau');


            }
        }
       
        

    }
    function matkhaumoi(Request $r){
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Mật khẩu mới';
        $meta_keyword = '';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        return view('clients.home.newpass',['thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp,  'meta_desc' => $meta_desc,
        'meta_keyword' => $meta_keyword,
        'meta_title' =>  $meta_title,
        'url_canonical' => $url_canonical]);
    }
    function updatematkhaumoi(Request $r)
    {
        // dd($r->all());  
        
        $r->validate(
            [

                'new_password'=>'min:2|max:255',
                'new_password_confirm' => 'same:new_password',



            ],
            [
                'new_password.min'=>'Mật khẩu quá ngắn',
                'new_password.max'=>'Mật khẩu quá dài',
                'new_password_confirm.same' => 'Không trùng khớp',
                


            ]
        );
        $data=$r->all();
        // dd($data);

       $token_random=Str::random(20);
        $user=User::where('email',$data['email_account'])->where('token',$data['token'])->get();
        if($user->count()>0){
            foreach($user as $item){
                $idnguoidung=$item->idnguoidung;
            }
            $reset=User::find($idnguoidung);
            $reset->password=Hash::make($data['new_password']);
            $reset->token=$token_random;
            $reset->save();
            return redirect('/dangnhap')->with('thongbao','Mật khẩu đã reset');
        }else{
            return redirect('/quenmatkhau')->with('error','Vui lòng nhập lại email vì link đã quá hạn');
        }
        

    }


}
