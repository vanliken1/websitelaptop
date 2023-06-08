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
    public function trangsanpham(Request $r)
    {
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $query = Sanpham::query();


        if (isset($r->brand)) {
            $query->whereHas('thuonghieu', function ($q) use ($r) {
                $q->whereIn('slug_thuonghieu', $r->brand);
            });
        }

        if (isset($r->cpu)) {

            $query->whereHas('cpus', function ($q) use ($r) {
                $q->whereIn('slug_CPU', $r->cpu);
            });
        }
        if (isset($r->gia)) {

            $query->where(function ($q) use ($r) {
                if (in_array('under_10', $r->gia)) {
                    $q->orWhere('giakhuyenmai', '<', 10000000);
                }
                if (in_array('10_to_15', $r->gia)) {
                    $q->orWhereBetween('giakhuyenmai', [10000000, 15000000]);
                }
                if (in_array('15_to_20', $r->gia)) {
                    $q->orWhereBetween('giakhuyenmai', [15000000, 20000000]);
                }
                if (in_array('20_to_25', $r->gia)) {
                    $q->orWhereBetween('giakhuyenmai', [20000000, 25000000]);
                }
                if (in_array('over_25', $r->gia)) {
                    $q->orWhere('giakhuyenmai', '>', 25000000);
                }
            });
        }
        $query->where(function ($query) {
            $query->where('sanpham.soluong', '>', 0)
                ->where('chitietkhuyenmai.trangthaictkm', 1)
                // ->whereNotNull('chitietkhuyenmai.idsanpham');
                ->orWhereNull('chitietkhuyenmai.idsanpham');
        });
        $sanpham = $query->leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
            ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
            ->orderBy('sanpham.idsanpham')
            ->paginate(12);
        
        // $sanpham=Sanpham::with('chitietkm')->paginate(12);
        return view('clients.home.sanpham', ['sanpham' => $sanpham, 'thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp, 'totalSanPham' => $sanpham->total()]);
    }
    function sanphamtheodanhmuc($slugdanhmuc, Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $query = Sanpham::query();

        if (isset($r->brand)) {
            $query->whereHas('thuonghieu', function ($q) use ($r) {
                $q->whereIn('slug_thuonghieu', $r->brand);
            });
        }
        if (isset($r->cpu)) {
            $query->whereHas('cpus', function ($q) use ($r) {
                $q->whereIn('slug_CPU', $r->cpu);
            });
        }
        if (isset($r->gia)) {

            $query->where(function ($q) use ($r) {
                if (in_array('under_10', $r->gia)) {
                    $q->orWhere('giakhuyenmai', '<', 10000000);
                }
                if (in_array('10_to_15', $r->gia)) {
                    $q->orWhereBetween('giakhuyenmai', [10000000, 15000000]);
                }
                if (in_array('15_to_20', $r->gia)) {
                    $q->orWhereBetween('giakhuyenmai', [15000000, 20000000]);
                }
                if (in_array('20_to_25', $r->gia)) {
                    $q->orWhereBetween('giakhuyenmai', [20000000, 25000000]);
                }
                if (in_array('over_25', $r->gia)) {
                    $q->orWhere('giakhuyenmai', '>', 25000000);
                }
            });
        }
        $query->where(function ($query) {
            $query->where('sanpham.soluong', '>', 0)
                ->where('chitietkhuyenmai.trangthaictkm', 1)
                // ->whereNotNull('chitietkhuyenmai.idsanpham')
                ->orWhereNull('chitietkhuyenmai.idsanpham');
        });
        //Tim san pham theo danh muc Thuong hieu
        $thuonghieu = Thuonghieu::where('slug_thuonghieu', $slugdanhmuc)->first();
        if ($thuonghieu) {

            $sptheobrand = $query->leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
                ->where('sanpham.idthuonghieu', $thuonghieu->idthuonghieu)

                ->where('sanpham.soluong', '>', 0)

                ->paginate(12);
            return view('clients.home.sanphamByBrand', ['sptheobrand' => $sptheobrand, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheobrand->total()]);
        }

        //Tim san pham theo danh muc CPU
        $slugcpu = CPU::where('slug_CPU', $slugdanhmuc)->first();
        if ($slugcpu) {
            $sptheocpu = $query->leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
                ->where('sanpham.idCPU', $slugcpu->idCPU)
                ->where('sanpham.soluong', '>', 0)
                ->where('chitietkhuyenmai.trangthaictkm','=',1)
                
                ->paginate(12);
            return view('clients.home.sanphamByCPU', ['sptheocpu' => $sptheocpu, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheocpu->total()]);
        }

        //Tim san pham theo danh muc CPU
        $nhucau = Loaisp::where('slug_loai', $slugdanhmuc)->first();
        if ($nhucau) {
            $sptheonhucau = $query->leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
                ->where('sanpham.idloaisanpham', $nhucau->idloaisanpham)
                ->where('sanpham.soluong', '>', 0)
                ->where('chitietkhuyenmai.trangthaictkm','=',1)
               
                ->paginate(12);
            return view('clients.home.sanphamByNC', ['sptheonhucau' => $sptheonhucau, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheonhucau->total()]);
        }
    }
    function chitiet($slugsanpham)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $sanpham = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
            ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
            ->where('slug_sanpham', $slugsanpham)
            ->where('sanpham.soluong', '>', 0)
            ->get();
        
        $thuonghieuIds = $sanpham->pluck('idthuonghieu')->toArray();
        $sanphamlienquan = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
            ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai', 'chitietkhuyenmai.trangthaictkm')
            ->whereIn('idthuonghieu', $thuonghieuIds)
            ->inRandomOrder()
            ->where('sanpham.idsanpham', '!=', $sanpham->first()->idsanpham)
            ->where('sanpham.soluong', '>', 0)
            ->take(3)
            ->get();
        return view('clients.home.chitietsanpham', ['sanpham' => $sanpham, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'sanphamlienquan' => $sanphamlienquan]);
    }
}
