<?php

namespace App\Http\Controllers;

use App\Mail\huydh;
use App\Models\Chitietdonhang;
use App\Models\Donhang;
use App\Models\Giamgia;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Mail;
use App\Mail\xacnhandh;
use App\Models\Thongke;

class DonhangController extends Controller
{
    //
    public function index()
    {
        $donhang = Donhang::orderBy('ngaydat', 'DESC')->get();
        return view('admin.donhang.index', ['donhang' => $donhang]);
    }
    public function chitietdonhang($iddonhang)
    {
        $chitiet = Chitietdonhang::where('iddonhang', $iddonhang)->get();
        $donhang = Donhang::where('iddonhang', $iddonhang)->get();
        foreach ($chitiet as $or) {
            $coupon_code = $or->codegiamgia;
        }
        // $coupon = Giamgia::where('codegiamgia', $coupon_code)->first();
        if ($coupon_code != 'no') {
            $coupon = Giamgia::where('codegiamgia', $coupon_code)->first();

            $tinhnangma = $coupon->tinhnangma;
            $sotiengiam = $coupon->sotiengiam;
        } else {
            $tinhnangma = 1;
            $sotiengiam = 0;
        }


        return view('admin.donhang.chitiet', ['chitietdonhang' => $chitiet, 'donhang' => $donhang, 'tinhnangma' => $tinhnangma, 'sotiengiam' => $sotiengiam]);
    }
    public function updatesoluong(Request $r)
    {
        $data = $r->all();
        $order = Donhang::find($data['iddonhang']);
        $order->trangthai = $data['trangthaidh'];
        $order->save();
        $chitiet = Chitietdonhang::where('iddonhang', $data['iddonhang'])->get();
        foreach ($chitiet as $or) {
            $coupon_code = $or->codegiamgia;
        }
        if ($coupon_code != 'no') {
            $coupon = Giamgia::where('codegiamgia', $coupon_code)->first();

            $tinhnangma = $coupon->tinhnangma;
            $sotiengiam = $coupon->sotiengiam;
        } else {
            $tinhnangma = 1;
            $sotiengiam = 0;
        }
        // $coupon = Giamgia::where('codegiamgia', $coupon_code)->first();

        $dataEmail1 = [
            'madonhang' => $order->iddonhang,
            'magiamgia' => $coupon_code,
            'diachinguoinhan' => $order->diachinguoinhan,
            'tennguoinhan' => $order->tennguoinhan,
            'tennguoigui' => $order->users->tennguoidung,
            'sdtnguoinhan' => $order->sdtnguoinhan,
            'ghichu' => $order->note,
            'hinhthucthanhtoan' => $order->hinhthuc,
            'cart' => $chitiet,
            'tinhnangma' => $tinhnangma,
            'sotiengiam' => $sotiengiam,
        ];
        $dataEmail2 = [
            'madonhang' => $order->iddonhang,
            'cart' => $chitiet,
            'tinhnangma' => $tinhnangma,
            'sotiengiam' => $sotiengiam,
        ];
        $ngaydathang = $order->ngaytinhdoanhthu;
        $thongke = Thongke::where('ngaydat', $ngaydathang)->get();
        if ($thongke) {
            $dem = $thongke->count();
        } else {
            $dem = 0;
        }
        $tongdonhang = 0;
        $doanhthu = 0;
        $soluongdaban = 0;
        if ($order->trangthai == 2) {
            foreach ($data['order_product_id'] as $key => $idsanpham) {
                $sanpham = Sanpham::find($idsanpham);
                $soluongsp = $sanpham->soluong;

                foreach ($data['quantity'] as  $key2 => $qty) {
                    if ($key == $key2) {
                        $soluongcon = $soluongsp - $qty;
                        $sanpham->soluong = $soluongcon;
                        $sanpham->save();
                    }
                }
            }
            Mail::to($order->users->email)->send(new xacnhandh($dataEmail1));
        } elseif ($order->trangthai == 3) {
            foreach ($data['order_product_id'] as $key => $idsanpham) {
                $sanpham = Sanpham::find($idsanpham);
                $soluongsp = $sanpham->soluong;

                foreach ($data['quantity'] as  $key2 => $qty) {
                    if ($key == $key2) {
                        $soluongcon = $soluongsp + $qty;
                        $sanpham->soluong = $soluongcon;
                        $sanpham->save();
                    }
                }
            }
            Mail::to($order->users->email)->send(new huydh($dataEmail2));
        } elseif ($order->trangthai == 4 || $order->trangthai == 5 || $order->trangthai == 6) {
            foreach ($data['order_product_id'] as $key => $idsanpham) {
                $sanpham = Sanpham::find($idsanpham);
                $soluongsp = $sanpham->soluong;

                foreach ($data['quantity'] as  $key2 => $qty) {
                    if ($key == $key2) {
                        $soluongcon = $soluongsp;
                        $sanpham->soluong = $soluongcon;
                        $sanpham->save();
                        if ($order->trangthai == 5) {
                            $soluongdaban += $qty;
                            $tongdonhang = 1;
                            $doanhthu = $data['tongthanhtoan'];
                        }
                    }
                }
            }
            if ($order->trangthai == 6) {
                Mail::to($order->users->email)->send(new huydh($dataEmail2));
            }
        }
      
        if ($dem > 0) {
            $thongke_update = Thongke::where('ngaydat', $ngaydathang)->first();
            $thongke_update->doanhthu = $thongke_update->doanhthu + $doanhthu;
            $thongke_update->soluongdaban = $thongke_update->soluongdaban + $soluongdaban;
            if ($order->trangthai == 5) {
                $thongke_update->tongdonhang = $thongke_update->tongdonhang + 1;
            }
            $thongke_update->save();
        } else {
            Thongke::create([
                'ngaydat' => $ngaydathang,
                'doanhthu' => $doanhthu,
                'soluongdaban' => $soluongdaban,
                'tongdonhang' => $tongdonhang
            ]);
        }
    }
    public function updateqty(Request $r)
    {
        $data = $r->all();
        // dd($data['order_product_id']);
        // dd($data['order_product_id'], $data['order_donhang']);
        $order = Chitietdonhang::where('idsanpham', $data['order_product_id'])->where('iddonhang', $data['order_donhang'])->first();
        // dd($order);
        $order->soluong = $data['order_qty'];

        $order->save();
    }
}
