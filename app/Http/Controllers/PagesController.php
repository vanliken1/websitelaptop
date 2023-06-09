<?php

namespace App\Http\Controllers;

use App\Models\Chitietdonhang;
use App\Models\CPU;
use App\Models\Dohoa;
use App\Models\Donhang;
use App\Models\Giamgia;
use App\Models\Loaisp;
use App\Models\Sanpham;
use App\Models\Thuonghieu;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
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
        // $query->where(function ($query) {
        //     $query->where('sanpham.soluong', '>', 0)
        //         ->where('chitietkhuyenmai.trangthaictkm','=', 1)
        //         // ->whereNotBetween('chitietkhuyenmai.trangthaictkm',[2,0])
        //         // ->whereNotNull('chitietkhuyenmai.idsanpham');
        //         ->orWhereNull('chitietkhuyenmai.idsanpham');
              
        // });
        $sanpham = $query->where('soluong', '>', 0)
            ->orderBy('idsanpham')
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
        // $query->where(function ($query) {
        //     $query->where('sanpham.soluong', '>', 0)
        //         ->where('chitietkhuyenmai.trangthaictkm','=', 1)
        //         ->whereNotNull('chitietkhuyenmai.idsanpham')
        //         ->orWhereNull('chitietkhuyenmai.idsanpham');
                
        // });
        //Tim san pham theo danh muc Thuong hieu
        $thuonghieu = Thuonghieu::where('slug_thuonghieu', $slugdanhmuc)->first();
        if ($thuonghieu) {

            $sptheobrand = $query->where('soluong', '>', 0)
                ->where('idthuonghieu', $thuonghieu->idthuonghieu)

                

                ->paginate(12);
            return view('clients.home.sanphamByBrand', ['sptheobrand' => $sptheobrand, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheobrand->total()]);
        }

        //Tim san pham theo danh muc CPU
        $slugcpu = CPU::where('slug_CPU', $slugdanhmuc)->first();
        if ($slugcpu) {
            $sptheocpu = $query->where('soluong', '>', 0)
                ->where('idCPU', $slugcpu->idCPU)
                
                ->paginate(12);
            return view('clients.home.sanphamByCPU', ['sptheocpu' => $sptheocpu, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheocpu->total()]);
        }

        //Tim san pham theo danh muc CPU
        $nhucau = Loaisp::where('slug_loai', $slugdanhmuc)->first();
        if ($nhucau) {
            $sptheonhucau = $query->where('soluong', '>', 0)
                ->where('idloaisanpham', $nhucau->idloaisanpham)
               
                ->paginate(12);
            return view('clients.home.sanphamByNC', ['sptheonhucau' => $sptheonhucau, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheonhucau->total()]);
        }
    }
    function chitiet($slugsanpham)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $sanpham = Sanpham::where('soluong', '>', 0)
            ->where('slug_sanpham', $slugsanpham)
            ->where('sanpham.soluong', '>', 0)
            ->get();
        
        $thuonghieuIds = $sanpham->pluck('idthuonghieu')->toArray();
        $sanphamlienquan = Sanpham::whereIn('idthuonghieu', $thuonghieuIds)
            ->inRandomOrder()
            ->where('idsanpham', '!=', $sanpham->first()->idsanpham)
            ->where('soluong', '>', 0)
            ->take(3)
            ->get();
        return view('clients.home.chitietsanpham', ['sanpham' => $sanpham, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'sanphamlienquan' => $sanphamlienquan]);
    }
    function history()
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        if(!auth()->check()){
            return redirect('/dangnhap');
        }else{
            $donhang = Donhang::where('idnguoidung',auth()->user()->idnguoidung)->orderBy('ngaydat', 'DESC')->paginate(10);
            return view('clients.home.history', ['thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp,'donhang'=>$donhang]);
        }
        
       
    }
    function chitiethistory($iddonhang)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        if(!auth()->check()){
            return redirect('/dangnhap');
        }else{
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
            return view('clients.home.viewhistory', ['chitietdonhang' => $chitiet, 'donhang' => $donhang,'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp,'donhang'=>$donhang,'tinhnangma' => $tinhnangma, 'sotiengiam' => $sotiengiam]);
        }
        
       
    }
    function infouser()
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        if(!auth()->check()){
            return redirect('/dangnhap');
        }else{
            $info=User::findOrFail(auth()->user()->idnguoidung);
            // dd($info->email);
            return view('clients.home.infouser',['nguoidung'=>$info,'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp]);

        }
        
       
    }
    function updateuser(Request $request)
    {
        // dd($request->email);
        
        $c=User::findOrFail(auth()->user()->idnguoidung);
        if($request->changePassword =="on"){
            $request->validate(
                [
                   
                    
                    'password2'=>'same:password',
                 
    
                ],
                [
                    
                    
                   'password2.same'=>'Không trùng khớp',
                    
                ]
            );
            $c->password=Hash::make($request->password);
        }
        $c->email=$request->email;
        $c->tennguoidung = $request->tennguoidung;
        $c->sdt= $request->sdt;
        $c->diachi = $request->diachi;
      
        $c->save();
        session()->flash("mess","Cập nhật thành công");
        return redirect("/info");
    }
}
