<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Chitietdonhang;
use App\Models\CPU;
use App\Models\Dohoa;
use App\Models\Donhang;
use App\Models\Giamgia;
use App\Models\Loaisp;
use App\Models\Luutru;
use App\Models\Manhinh;
use App\Models\Ram;
use App\Models\Sanpham;
use App\Models\Thuonghieu;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class PagesController extends Controller
{
    //
    public function trangchu(Request $r)
    {
        //seo
        $meta_desc = 'Chuyên bán các mặt hàng laptop chất lượng cao với đầy đủ thương hiệu nổi tiếng';
        $meta_keyword = "laptophaovan,website laptop haovan";
        $meta_title = "CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp";
        $url_canonical = $r->url();

        //--seo
        $thuonghieu = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $banner = Banner::all();
        $sanphamhot = Sanpham::where('hot', 1)->where('trangthai', 1)->where('soluong', '>', 0)->take(6)->get();
        $sanphamkhuyenmai = Sanpham::whereColumn('gia', '>', 'giakhuyenmai')->where('trangthai', 1)->where('soluong', '>', 0)->take(6)->get();

        return view('clients.index', [
            'thuonghieu' => $thuonghieu,
            'cpu' => $cpu,
            'loaisp' => $loaisp, 'banner' => $banner,
            'sanphamhot' => $sanphamhot,
            'sanphamkhuyenmai' => $sanphamkhuyenmai,
            'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical
        ]);
    }
    public function trangsanpham(Request $r)
    {
        $meta_desc = 'Tất cả các loại laptop bao gồm thương hiệu và nhiều thông số khác';
        $meta_keyword = "tatcalaptop,laptop ở công ty haovan";
        $meta_title = "Laptop-giá rẻ-nhiều ưu đãi";
        $url_canonical = $r->url();
        $selectedBrands = [];
        $selectedCPUs = [];
        $selectedPrices = [];
        $selectedRAMs = [];
        $selectedLTs = [];
        $selectedDHs = [];
        $selectedNCs = [];
        $selectedMHs = [];
        $thuonghieu = Thuonghieu::where('trangthai', 1)->get();
        $cpu = CPU::where('trangthai', 1)->get();
        $loaisp = Loaisp::where('trangthai', 1)->get();
        $ram = Ram::where('trangthai', 1)->get();
        $luutru = Luutru::where('trangthai', 1)->get();
        $dohoa = Dohoa::where('trangthai', 1)->get();
        $manhinh = Manhinh::where('trangthai', 1)->get();
        $query = Sanpham::query();


        if (isset($r->brand)) {
            $selectedBrands = $r->brand;
            $query->whereHas('thuonghieu', function ($q) use ($r) {
                $q->whereIn('slug_thuonghieu', $r->brand);
            });
        }
        if (isset($r->cpu)) {
            $selectedCPUs = $r->cpu;
            $query->whereHas('cpus', function ($q) use ($r) {
                $q->whereIn('slug_CPU', $r->cpu);
            });
        }
        if (isset($r->ram)) {
            $selectedRAMs = $r->ram;
            $query->whereHas('rams', function ($q) use ($r) {
                $q->whereIn('slug_ram', $r->ram);
            });
        }
        if (isset($r->luutru)) {
            $selectedLTs = $r->luutru;
            $query->whereHas('luutrus', function ($q) use ($r) {
                $q->whereIn('slug_luutru', $r->luutru);
            });
        }
        if (isset($r->dohoa)) {
            $selectedDHs = $r->dohoa;
            $query->whereHas('dohoas', function ($q) use ($r) {
                $q->whereIn('slug_dohoa', $r->dohoa);
            });
        }
        if (isset($r->nhucau)) {
            $selectedNCs = $r->nhucau;
            $query->whereHas('loaisp', function ($q) use ($r) {
                $q->whereIn('slug_loai', $r->nhucau);
            });
        }
        if (isset($r->manhinh)) {
            $selectedMHs = $r->manhinh;
            $query->whereHas('manhinhs', function ($q) use ($r) {
                $q->whereIn('slug_manhinh', $r->manhinh);
            });
        }
        if (isset($r->gia)) {
            $selectedPrices = $r->gia;
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
        if ($r->sort == 'tangdan') {
            $query->orderBy('gia', 'asc');
        } elseif ($r->sort == 'giamdan') {
            $query->orderBy('gia', 'desc');
        } elseif ($r->sort == 'hot') {
            $query->where('hot', 1);
        }
        $sanpham = $query->where('soluong', '>', 0)
            ->orderBy('idsanpham')
            ->paginate(12);

        // $sanpham=Sanpham::with('chitietkm')->paginate(12);
        return view('clients.home.sanpham', [
            'sanpham' => $sanpham, 'thuonghieu' => $thuonghieu, 'cpu' => $cpu, 'loaisp' => $loaisp, 'ram' => $ram, 'luutru' => $luutru, 'dohoa' => $dohoa, 'manhinh' => $manhinh, 'totalSanPham' => $sanpham->total(), 'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical,
            'selectedBrands' => $selectedBrands,
            'selectedCPUs' => $selectedCPUs,
            'selectedPrices' => $selectedPrices,
            'selectedRAMs' => $selectedRAMs,
            'selectedLTs' => $selectedLTs,
            'selectedDHs' => $selectedDHs,
            'selectedNCs' => $selectedNCs,
            'selectedMHs' => $selectedMHs
        ]);
    }
    function sanphamtheodanhmuc($slugdanhmuc, Request $r)
    {

        $thuonghieusp = Thuonghieu::where('trangthai', 1)->get();
        $cpu = CPU::where('trangthai', 1)->get();
        $loaisp = Loaisp::where('trangthai', 1)->get();
        $ram = Ram::where('trangthai', 1)->get();
        $luutru = Luutru::where('trangthai', 1)->get();
        $dohoa = Dohoa::where('trangthai', 1)->get();
        $manhinh = Manhinh::where('trangthai', 1)->get();
        $selectedBrands =  [];
        $selectedCPUs = [];
        $selectedPrices = [];
        $selectedRAMs = [];
        $selectedLTs = [];
        $selectedDHs = [];
        $selectedNCs = [];
        $selectedMHs = [];
        $query = Sanpham::query();

        if (isset($r->brand)) {
            $selectedBrands = $r->brand;
            $query->whereHas('thuonghieu', function ($q) use ($r) {
                $q->whereIn('slug_thuonghieu', $r->brand);
            });
        }
        if (isset($r->cpu)) {
            $selectedCPUs = $r->cpu;
            $query->whereHas('cpus', function ($q) use ($r) {
                $q->whereIn('slug_CPU', $r->cpu);
            });
        }
        if (isset($r->ram)) {
            $selectedRAMs = $r->ram;
            $query->whereHas('rams', function ($q) use ($r) {
                $q->whereIn('slug_ram', $r->ram);
            });
        }
        if (isset($r->luutru)) {
            $selectedLTs = $r->luutru;
            $query->whereHas('luutrus', function ($q) use ($r) {
                $q->whereIn('slug_luutru', $r->luutru);
            });
        }
        if (isset($r->dohoa)) {
            $selectedDHs = $r->dohoa;
            $query->whereHas('dohoas', function ($q) use ($r) {
                $q->whereIn('slug_dohoa', $r->dohoa);
            });
        }
        if (isset($r->nhucau)) {
            $selectedNCs = $r->nhucau;
            $query->whereHas('loaisp', function ($q) use ($r) {
                $q->whereIn('slug_loai', $r->nhucau);
            });
        }
        if (isset($r->manhinh)) {
            $selectedMHs = $r->manhinh;
            $query->whereHas('manhinhs', function ($q) use ($r) {
                $q->whereIn('slug_manhinh', $r->manhinh);
            });
        }
        if ($r->sort == 'tangdan') {
            $query->orderBy('gia', 'asc');
        } elseif ($r->sort == 'giamdan') {
            $query->orderBy('gia', 'desc');
        } elseif ($r->sort == 'hot') {
            $query->where('hot', 1);
        }
        if (isset($r->gia)) {
            $selectedPrices = $r->gia;
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

        //Tim san pham theo danh muc Thuong hieu
        $thuonghieu = Thuonghieu::where('slug_thuonghieu', $slugdanhmuc)->first();

        if ($thuonghieu) {
            $meta_desc = $thuonghieu->motathuonghieu;
            $meta_keyword = 'laptop' . $thuonghieu->tenthuonghieu;
            $meta_title = 'Laptop ' . $thuonghieu->tenthuonghieu . '- Laptop ' . $thuonghieu->tenthuonghieu . ' giá rẻ';
            $url_canonical = $r->url();
            $sptheobrand = $query->where('soluong', '>', 0)
                ->where('trangthai', 1)
                ->where('idthuonghieu', $thuonghieu->idthuonghieu)
                ->paginate(12);
            return view('clients.home.sanphamByBrand', [
                'sptheobrand' => $sptheobrand, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'ram' => $ram, 'luutru' => $luutru, 'dohoa' => $dohoa, 'manhinh' => $manhinh, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheobrand->total(),
                'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical,
                'selectedCPUs' => $selectedCPUs,
                'selectedPrices' => $selectedPrices,
                'selectedRAMs' => $selectedRAMs,
                'selectedLTs' => $selectedLTs,
                'selectedDHs' => $selectedDHs,
                'selectedNCs' => $selectedNCs,
                'selectedMHs' => $selectedMHs
            ]);
        }

        //Tim san pham theo danh muc CPU
        $slugcpu = CPU::where('slug_CPU', $slugdanhmuc)->first();
        if ($slugcpu) {
            $meta_desc = $slugcpu->mota_CPU;
            $meta_keyword = 'laptop' . $slugcpu->tenCPU;
            $meta_title = 'Laptop ' . $slugcpu->tenCPU . '- Laptop ' . $slugcpu->tenCPU . ' giá rẻ';
            $url_canonical = $r->url();
            $sptheocpu = $query->where('soluong', '>', 0)
                ->where('trangthai', 1)
                ->where('idCPU', $slugcpu->idCPU)

                ->paginate(12);
            return view('clients.home.sanphamByCPU', [
                'sptheocpu' => $sptheocpu, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'ram' => $ram, 'luutru' => $luutru, 'dohoa' => $dohoa, 'manhinh' => $manhinh, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheocpu->total(), 'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical,
                'selectedBrands' => $selectedBrands,
                'selectedPrices' => $selectedPrices,
                'selectedRAMs' => $selectedRAMs,
                'selectedLTs' => $selectedLTs,
                'selectedDHs' => $selectedDHs,
                'selectedNCs' => $selectedNCs,
                'selectedMHs' => $selectedMHs
            ]);
        }

        //Tim san pham theo danh muc CPU
        $nhucau = Loaisp::where('slug_loai', $slugdanhmuc)->first();
        if ($nhucau) {
            $meta_desc = $nhucau->motaloai;
            $meta_keyword = 'laptop' . $nhucau->tenloai;
            $meta_title = $nhucau->tenloai . '- ' . $nhucau->tenloai . ' giá rẻ';
            $url_canonical = $r->url();
            $sptheonhucau = $query->where('soluong', '>', 0)

                ->where('idloaisanpham', $nhucau->idloaisanpham)

                ->paginate(12);
            return view('clients.home.sanphamByNC', [
                'sptheonhucau' => $sptheonhucau, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'ram' => $ram, 'luutru' => $luutru, 'dohoa' => $dohoa, 'manhinh' => $manhinh, 'slugdanhmuc' => $slugdanhmuc, 'totalSanPham' => $sptheonhucau->total(),
                'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical,
                'selectedBrands' => $selectedBrands,
                'selectedCPUs' => $selectedCPUs,
                'selectedPrices' => $selectedPrices,
                'selectedRAMs' => $selectedRAMs,
                'selectedLTs' => $selectedLTs,
                'selectedDHs' => $selectedDHs,
                'selectedMHs' => $selectedMHs

            ]);
        }
    }
    function chitiet($slugsanpham, Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();

        $sanpham = Sanpham::where('soluong', '>', 0)
            ->where('slug_sanpham', $slugsanpham)
            ->get();
        foreach ($sanpham as $val) {
            $meta_desc = $val->motasanpham;
            $meta_keyword = $val->motasanpham;
            $meta_title = $val->tensanpham . ' -HaoVan';
            $url_canonical = $r->url();
        }
        $thuonghieuIds = $sanpham->pluck('idthuonghieu')->toArray();
        $sanphamlienquan = Sanpham::whereIn('idthuonghieu', $thuonghieuIds)
            ->inRandomOrder()
            ->where('idsanpham', '!=', $sanpham->first()->idsanpham)
            ->where('soluong', '>', 0)
            ->take(3)
            ->get();
        return view('clients.home.chitietsanpham', [
            'sanpham' => $sanpham, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'sanphamlienquan' => $sanphamlienquan, 'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical
        ]);
    }
    function history(Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Lịch sử đơn hàng';
        $meta_keyword = '';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        if (!auth()->check()) {
            return redirect('/dangnhap');
        } else {
            $donhang = Donhang::where('idnguoidung', auth()->user()->idnguoidung)->orderBy('ngaydat', 'DESC')->paginate(10);
            return view('clients.home.history', [
                'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'donhang' => $donhang,  'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical
            ]);
        }
    }
    function chitiethistory($iddonhang, Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Chi tiết đơn hàng';
        $meta_keyword = '';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        if (!auth()->check()) {
            return redirect('/dangnhap');
        } else {
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
            return view('clients.home.viewhistory', [
                'chitietdonhang' => $chitiet, 'donhang' => $donhang, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'donhang' => $donhang, 'tinhnangma' => $tinhnangma, 'sotiengiam' => $sotiengiam, 'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical
            ]);
        }
    }
    function infouser(Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $meta_desc = 'Thông tin khách hàng';
        $meta_keyword = '';
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        if (!auth()->check()) {
            return redirect('/dangnhap');
        } else {
            $info = User::findOrFail(auth()->user()->idnguoidung);
            // dd($info->email);
            return view('clients.home.infouser', [
                'nguoidung' => $info, 'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp,  'meta_desc' => $meta_desc,
                'meta_keyword' => $meta_keyword,
                'meta_title' =>  $meta_title,
                'url_canonical' => $url_canonical
            ]);
        }
    }
    function updateuser(Request $request)
    {
        // dd($request->email);

        $c = User::findOrFail(auth()->user()->idnguoidung);
        if ($request->changePassword == "on") {
            $request->validate(
                [


                    'password2' => 'same:password',


                ],
                [


                    'password2.same' => 'Không trùng khớp',

                ]
            );
            $c->password = Hash::make($request->password);
        }
        $c->email = $request->email;
        $c->tennguoidung = $request->tennguoidung;
        $c->sdt = $request->sdt;
        $c->diachi = $request->diachi;

        $c->save();
        session()->flash("mess", "Cập nhật thành công");
        return redirect("/info");
    }
    function search(Request $r)
    {

        $thuonghieusp = Thuonghieu::all();
        $cpu = CPU::all();
        $loaisp = Loaisp::all();
        $kw = $r->keyword;
        // dd($kw);
        $kw = str_replace('-', '\-', $kw);
        // $characters = str_split($kw);
        $sanphamtimkiem = Sanpham::whereFullText('tensanpham', "\%" . $kw . "\%")
            ->orWhere('tensanpham', 'LIKE', '%' . $kw . '%')

            // whereFullText('tensanpham', "\%".$kw."\%")

            ->where('soluong', '>', 0)
            ->where('trangthai', 1)

            ->paginate(12);
        // $sanphamtimkiem = Sanpham::where('tensanpham','LIKE', "%".$kw."%")

        //     ->where('soluong', '>', 0)
        //     ->where('trangthai', 1)

        //     ->paginate(12);
        $meta_desc = 'Tìm kiếm ' . $kw;
        $meta_keyword = $kw;
        $meta_title = 'CÔNG TY LAPTOPHAOVAN chuyên bán laptop chuyên nghiệp';
        $url_canonical = $r->url();
        return view('clients.home.timkiem', [
            'thuonghieu' => $thuonghieusp, 'cpu' => $cpu, 'loaisp' => $loaisp, 'sanphamtimkiem' => $sanphamtimkiem, 'totalSanPham' => $sanphamtimkiem->total(), 'kw' => $kw,
            'meta_desc' => $meta_desc,
            'meta_keyword' => $meta_keyword,
            'meta_title' =>  $meta_title,
            'url_canonical' => $url_canonical
        ]);
    }
}
