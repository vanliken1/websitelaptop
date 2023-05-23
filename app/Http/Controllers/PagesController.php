<?php

namespace App\Http\Controllers;

use App\Models\CPU;
use App\Models\Dohoa;
use App\Models\Loaisp;
use App\Models\Sanpham;
use App\Models\Thuonghieu;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function trangchu()
    {
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        return view('clients.index', ['thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp]);
    }
    public function trangsanpham()
    {
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $sanpham = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
            ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
            ->whereNotNull('chitietkhuyenmai.idsanpham')
            ->orWhereNull('chitietkhuyenmai.idsanpham')
            ->orderBy('sanpham.idsanpham')
            ->paginate(12);

        // $sanpham=Sanpham::with('chitietkm')->paginate(12);
        return view('clients.home.sanpham', ['sanpham' => $sanpham, 'thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp]);
    }
    function sanphamtheodanhmuc($slug)
    {
       
        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        //Tim san pham theo danh muc Thuong hieu
        $thuonghieu = Thuonghieu::where('slug_thuonghieu', $slug)->first();
        if ($thuonghieu) {
            $sptheobrand = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
                ->where('sanpham.idthuonghieu', $thuonghieu->idthuonghieu)
                ->paginate(12);
            return view('clients.home.sanphamByBrand', ['sptheobrand' => $sptheobrand, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp]);
        }

        //Tim san pham theo danh muc CPU
        $slugcpu = CPU::where('slug_CPU', $slug)->first();
        if ($slugcpu) {
            $sptheocpu = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
                ->where('sanpham.idCPU', $slugcpu->idCPU)
                ->paginate(12);
            return view('clients.home.sanphamByCPU', ['sptheocpu' => $sptheocpu, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp]);
        }

        //Tim san pham theo danh muc CPU
        $nhucau = Loaisp::where('slug_loai', $slug)->first();
        if ($nhucau) {
            $sptheonhucau = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
                ->where('sanpham.idloaisanpham', $nhucau->idloaisanpham)
                ->paginate(12);
            return view('clients.home.sanphamByNC', ['sptheonhucau' => $sptheonhucau , 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp]);
        }



       
    }

}
