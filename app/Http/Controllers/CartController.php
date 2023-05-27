<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thuonghieu;
use App\Models\CPU;
use App\Models\Loaisp;
use App\Models\Sanpham;
use Cart;

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
                    'options' => ['img' => $sanpham->img, 'giagoc' => $sanpham->gia],
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
        $cart = [
            'id' => $sanpham->idsanpham,
            'name' => $sanpham->tensanpham,
            'options' => ['img' => $sanpham->img, 'giagoc' => $sanpham->gia],
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
        return response()->json(['n'=>Cart::count()] );
    }
}
