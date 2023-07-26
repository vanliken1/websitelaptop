<?php

namespace App\Http\Controllers;

use App\Mail\testmail;
use App\Models\Chitietdonhang;
use App\Models\Chitietkhuyenmai;
use Illuminate\Http\Request;
use App\Models\Thuonghieu;
use App\Models\CPU;
use App\Models\Donhang;
use App\Models\Giamgia;
use App\Models\Khuyenmai;
use App\Models\Loaisp;
use App\Models\Sanpham;
use Carbon\Carbon;
use Cart;
use Illuminate\Support\Facades\Session;
use Mail;

class CartController extends Controller
{
    //    
    public function index(Request $r)
    {
        //dd(Cart::content());

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $cartItems = Cart::content();
        $meta_desc = 'Giỏ hàng của bạn';
        $meta_keyword = 'haovancart,giỏ hàng website haovan';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        //Neu giỏ hàng trống thì xuất ra mess 
        if ($cartItems->isEmpty()) {
            $mess = "Giỏ hàng của bạn đang trống";
            Session::forget('coupon');
            return view('clients.home.cart', [
                'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'mess' => $mess, 'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical
            ]);
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
        return view('clients.home.cart', [
            'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical
        ]);
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
            return redirect()->back()->with('alert', 'Sản phẩm đã tồn tại trong giỏ');
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
    function addajax($id, Request $r)
    {
        $sanpham = Sanpham::find($id);
        // ...
        $existingItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id == $id;
        });
        if ($existingItem->isNotEmpty()) {
            return response()->json(['success' => false]);
        }
        $cart = [
            'id' => $sanpham->idsanpham,
            'name' => $sanpham->tensanpham,
            'options' => ['img' => $sanpham->img, 'giagoc' => $sanpham->gia, 'soluongkho' => $sanpham->soluong],
            'qty' => 1,
            'price' => $sanpham->giakhuyenmai,
            'weight' => 0
        ];
        // Add the item to the cart
        Cart::add($cart);
        // Return a JSON response indicating successful addition to the cart
        return response()->json(['success' => true]);
    }
    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect('/cart');
    }
    function xoatatca(Request $r)
    {
        // dd($r->all());
        Cart::destroy();
        return redirect('/cart');
    }
    function edit(Request $r)
    {


        Cart::update($r->rowId, $r->qty);
        return response()->json(['n' => Cart::count()]);
    }
    function trangthanhtoan(Request $r)
    {
        // dd($r->all());
        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Trang thanh toán sản phẩm';
        $meta_keyword = 'thanhtoanhaovan,cổng thanh toán haovan';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();

        return view('clients.home.thanhtoan', [
            'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp,
            'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical
        ]);
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
            session()->flash('message', 'Xóa mã thành công');
            return redirect('/cart');
        }
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        // dd($result);
        curl_close($ch);
        return $result;
    }
    function save_thanhtoan(Request $r)
    {
        $r->validate(
            [

                'tennguoinhan' => 'min:3|max:255',
                'sdtnguoinhan' => 'digits:10',
                'diachinguoinhan' => 'max:255',


            ],
            [
                'tennguoinhan.min' => 'Tên tối thiểu 3 ký tự',
                'tennguoinhan.max' => 'Tên quá dài',
                'sdtnguoinhan.digits' => 'SĐT không hợp lệ',
                'diachinguoinhan.max' => 'Địa chỉ quá dài',
            ]
        );
        $data2 = $r->all();
        // dd($data2);
        // dd($data['tongmomo']);
        $today = Carbon::today();

        // Kiểm tra số lần ID người dùng đã xuất hiện trong đơn hàng trong ngày hôm nay
        $donHangDaDatTrongHomNay = Donhang::where('idnguoidung', auth()->user()->idnguoidung)
            ->whereDate('ngaydat', $today)
            ->count();

        if ($donHangDaDatTrongHomNay >= 5) {
            session()->flash('error', 'Bạn đã đạt số lượng đơn hàng tối đa trong ngày hôm nay.Mai quay lại bạn nhé!');
            return redirect('/thanhtoan');
        }
        // dd($data['hinhthuc']);
        if ($data2['hinhthuc'] == 2) {

            // include "../common/helper.php";


            $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";


            $partnerCode = "MOMOBKUN20180529";
            $accessKey = "klm05TvNBzhg7h7j";
            $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";
            $orderInfo = "Thanh toán qua MoMo";
            $amount = $_POST['tongmomo'];
            // dd($amount);
            $orderId = time() . "";
            $returnUrl = "http://127.0.0.1:8000/finish";
            $notifyurl = "http://127.0.0.1:8000/";
            // Lưu ý: link notifyUrl không phải là dạng localhost
            $extraData = "merchantName=MoMo Partner";


            $requestId = time() . "";
            $requestType = "captureMoMoWallet";
            $extraData =  "";
            //before sign HMAC SHA256 signature
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
            // dd($rawHash);
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            // dd($signature);
            $data = array(
                'partnerCode' => $partnerCode,
                'accessKey' => $accessKey,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'returnUrl' => $returnUrl,
                'notifyUrl' => $notifyurl,
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            // dd($data);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            // dd($result);
            $jsonResult = json_decode($result, true);  // decode json
            $coupon1 = Giamgia::where('codegiamgia', $data2['coupon_donhang'])
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

            $data2['ngaydat'] = date('y-m-d h:i:s');
            $data2['ngaytinhdoanhthu'] = date('y-m-d');
            $data2['trangthai'] = 1;
            $data2['idnguoidung'] = auth()->user()->idnguoidung;
            //dd($data['idusers'] = session('users')['idusers']);
            //$data = Users::where('idusers', '1')->first();
            $o = Donhang::create($data2);
            // dd($o);
            $idorder = $o->iddonhang;
            foreach (Cart::content() as $item) {
                $spkm = Chitietkhuyenmai::where('idsanpham', $item->id)
                    ->where('trangthaictkm', 1)
                    ->first();

                if ($spkm != null) {
                    $tenkhuyenmai = Khuyenmai::where('idkhuyenmai', $spkm->idkhuyenmai)->first();

                    $data3 = [
                        'iddonhang' => $idorder,
                        'idsanpham' => $item->id,
                        'soluong' => $item->qty,
                        'giagoc' => $item->options->giagoc,
                        'gia' => $item->price,
                        'codegiamgia' => $r->coupon_donhang,
                        'makhuyenmai' => $tenkhuyenmai->tenkhuyenmai
                    ];
                } else {
                    $data3 = [
                        'iddonhang' => $idorder,
                        'idsanpham' => $item->id,
                        'soluong' => $item->qty,
                        'giagoc' => $item->options->giagoc,
                        'gia' => $item->price,
                        'codegiamgia' => $r->coupon_donhang,

                    ];
                }
                $ct = Chitietdonhang::create($data3);
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



            return redirect()->to($jsonResult['payUrl']);

            //Just a example, please check more in there

            // header('Location: ' . );

        }
        // $haongu=Session::get('coupon');  
        // dd($haongu[0]['codegiamgia']); 
        if ($data2['hinhthuc'] == 3) {



            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/returnVNP";
            $vnp_TmnCode = "HL35N690"; //Mã website tại VNPAY 
            $vnp_HashSecret = "RCWVJPLFZOUCZOOSVJZCXZRBWGGINITG"; //Chuỗi bí mật

            $vnp_TxnRef = uniqid(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = 'Thanh toan hoa don';
            $vnp_OrderType = 'bill';
            $vnp_Amount = $_POST['tongmomo'] * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,

            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00', 'message' => 'success', 'data' => $vnp_Url
            );
            session()->put('donhang', $r->toArray());
            return redirect($vnp_Url);
            // vui lòng tham khảo thêm tại code demo





        }
        $coupon1 = Giamgia::where('codegiamgia', $data2['coupon_donhang'])
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

        $data2['ngaydat'] = date('y-m-d h:i:s');
        $data2['ngaytinhdoanhthu'] = date('y-m-d');
        $data2['trangthai'] = 1;
        $data2['idnguoidung'] = auth()->user()->idnguoidung;
        //dd($data['idusers'] = session('users')['idusers']);
        //$data = Users::where('idusers', '1')->first();
        $o = Donhang::create($data2);
        // dd($o);
        $idorder = $o->iddonhang;
        foreach (Cart::content() as $item) {
            $spkm = Chitietkhuyenmai::where('idsanpham', $item->id)
                ->where('trangthaictkm', 1)
                ->first();

            if ($spkm != null) {
                $tenkhuyenmai = Khuyenmai::where('idkhuyenmai', $spkm->idkhuyenmai)->first();

                $data3 = [
                    'iddonhang' => $idorder,
                    'idsanpham' => $item->id,
                    'soluong' => $item->qty,
                    'giagoc' => $item->options->giagoc,
                    'gia' => $item->price,
                    'codegiamgia' => $r->coupon_donhang,
                    'makhuyenmai' => $tenkhuyenmai->tenkhuyenmai
                ];
            } else {
                $data3 = [
                    'iddonhang' => $idorder,
                    'idsanpham' => $item->id,
                    'soluong' => $item->qty,
                    'giagoc' => $item->options->giagoc,
                    'gia' => $item->price,
                    'codegiamgia' => $r->coupon_donhang,

                ];
            }
            $ct = Chitietdonhang::create($data3);
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
        return redirect('/finish');
    }

    function finish(Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Hoàn thành đơn hàng';
        $meta_keyword = '';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        return view('clients.home.finish', [
            'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical
        ]);
    }
    function returnVNPAY(Request $r)
    {
        // dd($r->all());
        $data4 = $r->all();
        // dd($data2);
        //thanh cong
        if ($r['vnp_TransactionStatus'] == "00") {
            $data2 = session()->get('donhang');
            // dd($data2);
            $coupon1 = Giamgia::where('codegiamgia', $data2['coupon_donhang'])
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

            $data2['ngaydat'] = date('y-m-d h:i:s');
            $data2['ngaytinhdoanhthu'] = date('y-m-d');
            $data2['trangthai'] = 1;
            $data2['idnguoidung'] = auth()->user()->idnguoidung;
            //dd($data['idusers'] = session('users')['idusers']);
            //$data = Users::where('idusers', '1')->first();
            $o = Donhang::create($data2);
            // dd($o);
            $idorder = $o->iddonhang;
            foreach (Cart::content() as $item) {
                $spkm = Chitietkhuyenmai::where('idsanpham', $item->id)
                    ->where('trangthaictkm', 1)
                    ->first();

                if ($spkm != null) {
                    $tenkhuyenmai = Khuyenmai::where('idkhuyenmai', $spkm->idkhuyenmai)->first();

                    $data3 = [
                        'iddonhang' => $idorder,
                        'idsanpham' => $item->id,
                        'soluong' => $item->qty,
                        'giagoc' => $item->options->giagoc,
                        'gia' => $item->price,
                        'codegiamgia' => $data2['coupon_donhang'],
                        'makhuyenmai' => $tenkhuyenmai->tenkhuyenmai
                    ];
                } else {
                    $data3 = [
                        'iddonhang' => $idorder,
                        'idsanpham' => $item->id,
                        'soluong' => $item->qty,
                        'giagoc' => $item->options->giagoc,
                        'gia' => $item->price,
                        'codegiamgia' => $data2['coupon_donhang'],

                    ];
                }
                $ct = Chitietdonhang::create($data3);
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
            session::forget('donhang');
            return redirect('/finish');
        }
        // loi
        elseif ($r['vnp_TransactionStatus'] == "01") {
            
            return redirect("/thanhtoan");
        }
        //tu choi
        elseif ($r['vnp_TransactionStatus'] == "02") {

            // dd(Cart::content());

            return redirect("/thanhtoan");
        }
    }
}
