<?php

namespace App\Http\Controllers;

use App\Mail\testmail;
use App\Models\Chitietdonhang;
use Illuminate\Http\Request;
use App\Models\Thuonghieu;
use App\Models\CPU;
use App\Models\Donhang;
use App\Models\Giamgia;

use App\Models\Loaisp;
use App\Models\Sanpham;
use Carbon\Carbon;
use Cart;
use Illuminate\Support\Facades\Session;
use Mail;

class CartController extends Controller
{
    //    
    public function index()
    {
        //dd(Cart::content());

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $cartItems = Cart::content();
        //Neu giỏ hàng trống thì xuất ra mess 
        if ($cartItems->isEmpty()) {
            $mess = "Giỏ hàng của bạn đang trống";
            Session::forget('coupon');
            return view('clients.home.cart', ['thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'mess' => $mess]);
        }
        // Kiểm tra xem sản phẩm trong giỏ hàng có tồn tại trong cơ sở dữ liệu hay không
        foreach ($cartItems as $item) {
            $idsanpham = $item->id;
            $sanpham = SanPham::find($idsanpham);

            if (!$sanpham) {
                // Nếu sản phẩm không còn tồn tại trong cơ sở dữ liệu, xóa sản phẩm khỏi giỏ hàng
                Cart::remove($item->rowId);
            } else {
                // Nếu sản phẩm vẫn tồn tại,cập nhật thông tin sản phẩm trong giỏ hàng (nếu cần)
                Cart::update($item->rowId, [
                    'id' => $sanpham->idsanpham,
                    'name' => $sanpham->tensanpham,
                    'options' => ['img' => $sanpham->img, 'giagoc' => $sanpham->gia, 'soluongkho' => $sanpham->soluong],
                    'price' => $sanpham->giakhuyenmai,
                ]);
            }
        }
        return view('clients.home.cart', ['thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp]);
    }
    function add($id)
    {
        $sanpham = Sanpham::find($id);
        //dd($product);
        // Cart::add('1','sp1',1,9.99 ,10);
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        $existingItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id == $id;
        });

        if ($existingItem->isNotEmpty()) {
            // Hiển thị thông báo sản phẩm đã có trong giỏ hàng
            return redirect()->back()->with('alert', 'Sản phẩm đã có trong giỏ hàng.');
        }
        $cart = [
            'id' => $sanpham->idsanpham,
            'name' => $sanpham->tensanpham,
            'options' => ['img' => $sanpham->img, 'giagoc' => $sanpham->gia, 'soluongkho' => $sanpham->soluong],
            'qty' => 1,
            'price' => $sanpham->giakhuyenmai,
            'weight' => 0
        ];

        Cart::add($cart);


        //dd(Cart::content());
        return redirect('/cart');
    }
    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect('/cart');
    }
    function edit(Request $r)
    {


        Cart::update($r->rowId, $r->qty);
        return response()->json(['n' => Cart::count()]);
    }
    function trangthanhtoan()
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        return view('clients.home.thanhtoan', ['thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp]);
    }

    function check_coupon(Request $r)
    {
        $data = $r->all();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        if (auth()->check()) {
            $coupon = Giamgia::where('codegiamgia', $data['coupon'])
                ->where('trangthai', 1)
                ->where('ngayketthuc', '>=', $today)
                ->where('dasudung', 'LIKE', '%' . auth()->user()->idnguoidung . '%')
                ->first();
            if ($coupon) {
                session()->flash('error', 'Mã giảm giá đã nhập r');
                return redirect('/cart');
            } else {
                $coupon = Giamgia::where('codegiamgia', $data['coupon'])
                    ->where('trangthai', 1)
                    ->where('ngayketthuc', '>=', $today)
                    ->first();

                if ($coupon) {
                    // Kiểm tra số lượng coupon

                    // Xử lý logic cho mã coupon hợp lệ
                    $count_coupon = Giamgia::where('codegiamgia', $data['coupon'])->count();
                    if ($count_coupon > 0) {
                        $coupon_session = Session::get('coupon');
                        if ($coupon_session) {
                            // Đã có mã coupon trong session
                            $tontai = 0;
                            if ($tontai == 0) {
                                // Thực hiện các hành động với mã coupon 
                                $cou[] = array(
                                    'codegiamgia' => $coupon->codegiamgia,
                                    'tinhnangma' => $coupon->tinhnangma,
                                    'sotiengiam' => $coupon->sotiengiam,
                                );
                                Session::put('coupon', $cou);
                            }
                        } else {
                            $cou[] = array(
                                'codegiamgia' => $coupon->codegiamgia,
                                'tinhnangma' => $coupon->tinhnangma,
                                'sotiengiam' => $coupon->sotiengiam,
                            );
                            Session::put('coupon', $cou);
                        }
                        Session::save();
                        session()->flash('message', 'Thêm mã thành công');
                        return redirect('/cart');
                    }
                } else {
                    session()->flash('error', 'Mã giảm giá không đúng hoặc đã hết hạn');
                    return redirect('/cart');
                }
            }
        }
        // } else {
        //     $coupon = Giamgia::where('codegiamgia', $data['coupon'])
        //         ->where('trangthai', 1)
        //         ->where('ngayketthuc', '>=', $today)
        //         ->first();

        //     if ($coupon) {
        //         // Kiểm tra số lượng coupon

        //         // Xử lý logic cho mã coupon hợp lệ
        //         $count_coupon = Giamgia::where('codegiamgia', $data['coupon'])->count();
        //         if ($count_coupon > 0) {
        //             $coupon_session = Session::get('coupon');
        //             if ($coupon_session) {
        //                 // Đã có mã coupon trong session
        //                 $tontai = 0;
        //                 if ($tontai == 0) {
        //                     // Thực hiện các hành động với mã coupon tại đây
        //                     $cou[] = array(
        //                         'codegiamgia' => $coupon->codegiamgia,
        //                         'tinhnangma' => $coupon->tinhnangma,
        //                         'sotiengiam' => $coupon->sotiengiam,
        //                     );
        //                     Session::put('coupon', $cou);
        //                 }
        //             } else {
        //                 $cou[] = array(
        //                     'codegiamgia' => $coupon->codegiamgia,
        //                     'tinhnangma' => $coupon->tinhnangma,
        //                     'sotiengiam' => $coupon->sotiengiam,
        //                 );
        //                 Session::put('coupon', $cou);
        //             }
        //             Session::save();
        //             session()->flash('message', 'Thêm mã thành công');
        //             return redirect('/cart');
        //         }
        //     } else {
        //         session()->flash('error', 'Mã giảm giá không đúng hoặc đã hết hạn');
        //         return redirect('/cart');
        //     }
        // }
    }

    function unsetcoupon()
    {
        $coupon = Session::get('coupon');
        if ($coupon) {
            Session::forget('coupon');
            session()->flash('message', 'Xoa ma thanh cong');
            return redirect('/cart');
        }
    }
    function save_thanhtoan(Request $r)
    {
        // $r->validate(
        //     [
        //         'tennguoinhan' => 'required|min:3',
        //         'diachinguoinhan' => "required|max:45",
        //         'sdtnguoinhan' => 'required|digits:10',


        //     ],
        //     [
        //         'tennguoinhan.required' => 'Chua nhập tên người nhận',
        //         'tennguoinhan.min' => "Ten người nhận tối thiểu 3 ký tự",
        //         'diachinguoinhan.required' => "Chưa điền địa chỉ người nhận",
        //         'diachinguoinhan.max' => "Địa chỉ ko vượt quá 45 ký tự",
        //         'sdtnguoinhan.required' => "Chưa điền sđt",
        //         'sdtnguoinhan.digits' => 'SĐT ko hợp lệ',
        //     ]
        // );
        $today = Carbon::today();

        // Kiểm tra số lần ID người dùng đã xuất hiện trong đơn hàng trong ngày hôm nay
        $donHangDaDatTrongHomNay = Donhang::where('idnguoidung', auth()->user()->idnguoidung)
            ->whereDate('ngaydat', $today)
            ->count();

        if ($donHangDaDatTrongHomNay >= 3) {
            session()->flash('error', 'Bạn đã đạt số lượng đơn hàng tối đa trong ngày hôm nay.Mai quay lại bạn nhé!');
            return redirect('/thanhtoan');
        }
        $data = $r->all();
        // $haongu=Session::get('coupon');  
        // dd($haongu[0]['codegiamgia']); 

        $coupon1 = Giamgia::where('codegiamgia', $data['coupon_donhang'])
            ->where('trangthai', 1)
            ->first();

        if ($coupon1) {
            if ($coupon1->soluong > 0) {
                $coupon1->soluong = $coupon1->soluong - 1;
                $coupon1->save();
            } else {
                Session::forget('coupon');
                session()->flash('error', 'Mã giảm giá đã hết số lượng');
                return redirect('/cart');
            }
            $coupon1->dasudung = $coupon1->dasudung . ',' . auth()->user()->idnguoidung;
            $coupon1->save();
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $data['ngaydat'] = date('y-m-d h:i:s');
        $data['iddonhang'] = time();
        $data['trangthai'] = 1;
        $data['idnguoidung'] = auth()->user()->idnguoidung;
        //dd($data['idusers'] = session('users')['idusers']);
        //$data = Users::where('idusers', '1')->first();
        $o = Donhang::create($data);
        // dd($o);
        $idorder = $o->iddonhang;
        foreach (Cart::content() as $item) {
            $data2 = [
                'iddonhang' => $idorder,
                'idsanpham' => $item->id,
                'soluong' => $item->qty,
                'gia' => $item->price,
                'trangthai' => 1,
                'codegiamgia' => $r->coupon_donhang,
            ];
            $ct = Chitietdonhang::create($data2);
        }
        $dataEmail = [
            'madonhang' => $o->iddonhang,
            'magiamgia' => $ct->codegiamgia,
            'diachinguoinhan' => $o->diachinguoinhan,
            'tennguoinhan' => $o->tennguoinhan,
            'tennguoigui' => auth()->user()->tennguoidung,
            'sdtnguoinhan' => $o->sdtnguoinhan,
            'ghichu' => $o->note,
            'hinhthucthanhtoan' => $o->hinhthuc,
            'cart' => Cart::content(),
            'session_coupon' => Session::get('coupon'),

        ];
        //-----gui mail ne---------
        $email['email'] = auth()->user()->email;
        Mail::to($email)->send(new testmail($dataEmail));
        //----xoa all gio hang------
        Cart::destroy();
        Session::forget('coupon');
        return redirect('/');
    }
}
