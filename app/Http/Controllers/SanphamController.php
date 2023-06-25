<?php

namespace App\Http\Controllers;

use App\Models\Chitietkhuyenmai;
use App\Models\CPU;
use App\Models\Dohoa;
use App\Models\Khuyenmai;
use App\Models\Loaisp;
use App\Models\Luutru;
use App\Models\Manhinh;
use App\Models\Ram;
use App\Models\Sanpham;
use App\Models\Thuonghieu;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;

class SanphamController extends Controller
{
    //
    public function index(Request $r)
    {
        // dd($sanpham);
        $thuonghieu = Thuonghieu::all();
        $loaisp = Loaisp::all();
        $cpu = CPU::all();
        $ram = Ram::all();
        $dohoa = Dohoa::all();
        $luutru = Luutru::all();
        $manhinh = Manhinh::all();
        $selectedBrands = [];
        $selectedCPUs = [];
        $selectedRAMs = [];
        $selectedLTs = [];
        $selectedDHs = [];
        $selectedNCs = [];
        $selectedPrices = [];
        $selectedMHs = [];
        $query = Sanpham::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tensanpham', "\%" . $r->keyword . "\%")
                    ->orWhere('tensanpham', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        if (isset($r->brand)) {
            $selectedBrands = $r->brand;
            // dd($r->brand);
            $query->whereHas('thuonghieu', function ($q) use ($r) {
                $q->whereIn('idthuonghieu', $r->brand);
            });
        }
        if (isset($r->cpu)) {
            $selectedCPUs = $r->cpu;
            // dd($r->brand);
            $query->whereHas('cpus', function ($q) use ($r) {
                $q->whereIn('idCPU', $r->cpu);
            });
        }
        if (isset($r->ram)) {
            $selectedRAMs = $r->ram;
            // dd($r->brand);
            $query->whereHas('rams', function ($q) use ($r) {
                $q->whereIn('idram', $r->ram);
            });
        }
        if (isset($r->luutru)) {
            $selectedLTs = $r->luutru;
            // dd($r->brand);
            $query->whereHas('luutrus', function ($q) use ($r) {
                $q->whereIn('idluutru', $r->luutru);
            });
        }
        if (isset($r->dohoa)) {
            $selectedDHs = $r->dohoa;
            // dd($r->brand);
            $query->whereHas('dohoas', function ($q) use ($r) {
                $q->whereIn('iddohoa', $r->dohoa);
            });
        }
        if (isset($r->nhucau)) {
            $selectedNCs = $r->nhucau;
            // dd($r->brand);
            $query->whereHas('loaisp', function ($q) use ($r) {
                $q->whereIn('idloaisanpham', $r->nhucau);
            });
        }
        if (isset($r->manhinh)) {
            $selectedMHs = $r->manhinh;
            // dd($r->brand);
            $query->whereHas('manhinhs', function ($q) use ($r) {
                $q->whereIn('idmanhinh', $r->manhinh);
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
        $sanpham = $query->orderBy('ngaytao', 'DESC')->paginate(10);

        return view('admin.sanpham.index', [
            'sanpham' => $sanpham, 'thuonghieu' => $thuonghieu, 'loaisp' => $loaisp, 'cpu' => $cpu, 'ram' => $ram, 'dohoa' => $dohoa, 'luutru' => $luutru,
            'manhinh' => $manhinh,
            'selectedBrands' => $selectedBrands,
            'selectedCPUs' => $selectedCPUs,
            'selectedRAMs' => $selectedRAMs,
            'selectedLTs' => $selectedLTs,
            'selectedDHs' => $selectedDHs,
            'selectedNCs' => $selectedNCs,
            'selectedMHs' => $selectedMHs,
            'selectedPrices' => $selectedPrices
        ]);
    }
    public function create()
    {
        $thuonghieu = Thuonghieu::all();
        $loaisp = Loaisp::all();
        $cpu = CPU::all();
        $ram = Ram::all();
        $dohoa = Dohoa::all();
        $luutru = Luutru::all();
        $manhinh = Manhinh::all();
        return view('admin.sanpham.create', [
            'thuonghieu' => $thuonghieu, 'loaisp' => $loaisp, 'cpu' => $cpu, 'ram' => $ram, 'dohoa' => $dohoa, 'luutru' => $luutru,'manhinh' => $manhinh]);
    }
    public function store(Request $r)
    {

        // $validator = Validator::make(
        //     $r->all(),
        //     [
        //         'tensanpham' => 'required',
        //         'soluong' => 'numeric',
        //         'noidung' => 'required',
        //     ],
        //     [

        //         'tensanpham.required' => 'Chưa nhập tên',
        //         'soluong.numeric' => 'So luong ko dc âm',
        //         'noidung.required' => 'Vui lòng nhập nội dung',
        //     ]
        // );
        // if ($validator->passes()) {

        //     $data = $r->all();
        //     // $ct = Chitietkhuyenmai::where('idsanpham', $data['idsanpham'])->first();
        //     if ($r->img != null) {
        //         $img = $data['idsanpham'] . '-' . $r->img->getClientOriginalName();
        //         $data['img'] = $img;
        //         $r->img->storeAs('public/img', $img);
        //     }
        //     // if (isset($ct)) {
        //     //     $data['giakhuyenmai'] = $data['gia'] - ($data['gia'] * ($ct->phantramkhuyenmai / 100));
        //     // }
        //     // $data['giakhuyenmai'] = $data['gia'];
        //     date_default_timezone_set('Asia/Ho_Chi_Minh');
        //     $data['ngaytao'] = date('Y-m-d H:i:s');
        //     // dd($data['ngaytao']);
        //     $u = Sanpham::create($data);
        //     return response()->json($u);
        //     //return response()->json($u,['success'=>'Added new records.']);

        // }

        // return response()->json(['error' => $validator->errors()]);
        $r->validate(
            [
                'idsanpham' => 'required|unique:sanpham|min:3|max:255',
                'tensanpham'=>'required|min:3|max:255',
                'slug_sanpham' => 'required|max:255',
                'idthuonghieu'=>'required',
                'idCPU'=>'required',
                'idram'=>'required',
                'iddohoa'=>'required',
                'idluutru'=>'required',
                'idmanhinh'=>'required',
                'idloaisanpham'=>'required',
                'img' => 'required|mimes:jpeg,png,svg',
                'motasanpham' => 'required|max:255',
                'noidung' => 'required',
                'gia'=>'numeric|min:10000',
                'soluong'=>'numeric|min:1',
            ],
            [
                'idsanpham.required' => 'Vui lòng nhập mã',
                'idsanpham.min'=>'Mã tối thiểu 3 ký tự',
                'idsanpham.max'=>'Mã đã đạt tối đa ký tự',
                'idsanpham.unique'=>'Mã đã tồn tại',
                'tensanpham.required'=>'Vui lòng nhập tên sản phẩm',
                'tensanpham.min'=>'Tên tối thiểu 3 ký tự',
                'tensanpham.max'=>'Tên quá dài',
                'slug_sanpham.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_sanpham.max' => 'Đường dẫn SEO quá dài',
                'idthuonghieu.required'=>'Vui lòng chọn thương hiệu',
                'idCPU.required'=>'Vui lòng chọn CPU',
                'idram.required'=>'Vui lòng chọn RAM',
                'iddohoa.required'=>'Vui lòng chọn Card đồ họa',
                'idluutru.required'=>'Vui lòng chọn Ổ cứng',
                'idmanhinh.required'=>'Vui lòng chọn kích thước',
                'idloaisanpham.required'=>'Vui lòng chọn nhu cầu sử dụng',
                'img.required'=>'Vui lòng chọn hình ảnh',
                'img.mimes'=>'Định dạng hình không hợp lệ',
                'motasanpham.required' => 'Vui lòng nhập mô tả',
                'motasanpham.max' => 'Mô tả quá dài',
                'noidung.required' => 'Vui lòng nhập nội dung',
                'gia.min'=>'Giá tối thiểu là 10000đ',
                'soluong.min' => 'Số lượng tối thiểu là 1',


            ]
        );
        $data = $r->all();
    
        // $ct = Chitietkhuyenmai::where('idsanpham', $data['idsanpham'])->first();
        if ($r->img != null) {
            $img = $data['idsanpham'] . '-' . $r->img->getClientOriginalName();
            $data['img'] = $img;
            $r->img->storeAs('public/img', $img);
        }
        // if (isset($ct)) {
        //     $data['giakhuyenmai'] = $data['gia'] - ($data['gia'] * ($ct->phantramkhuyenmai / 100));
        // }
        // $data['giakhuyenmai'] = $data['gia'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data['ngaytao'] = date('Y-m-d H:i:s');
        // dd($data['ngaytao']);
        $u = Sanpham::create($data);
        session()->flash('mess','Thêm thành công');
        return redirect('/admin/product');
    }
    public function edit($id)
    {
        $thuonghieu = Thuonghieu::all();
        $loaisp = Loaisp::all();
        $cpu = CPU::all();
        $ram = Ram::all();
        $dohoa = Dohoa::all();
        $luutru = Luutru::all();
        $manhinh = Manhinh::all();
        $data = Sanpham::findOrFail($id);
        // return response()->json($data);
        return view('admin.sanpham.edit',['sanpham'=>$data,'thuonghieu' => $thuonghieu, 'loaisp' => $loaisp, 'cpu' => $cpu, 'ram' => $ram, 'dohoa' => $dohoa, 'luutru' => $luutru,'manhinh' => $manhinh]);
    }
    public function update(Request $request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [

        //         'tensanpham' => 'required',
        //         'soluong' => 'numeric'
        //     ],
        //     [


        //         'tensanpham.required' => 'Chưa nhập tên',
        //         'soluong.numeric' => 'So luong ko dc âm',
        //     ]
        // );
        // // return print_r($request->all() ); exit;
        // // response()->json($request->all());
        // if ($validator->passes()) {
        //     $c = Sanpham::findorfail($request->idsanpham);
        //     $ct = Chitietkhuyenmai::where('idsanpham', $c['idsanpham'])->first();
        //     $temp = $c->img;
        //     if ($request->img != null) {
        //         Storage::disk('local')->delete("public/img/$temp");
        //         $img = $c['idsanpham'] . '-' . $request->img->getClientOriginalName();
        //         $c['img'] = $img;
        //         $request->img->storeAs('public/img', $img);
        //     }

        //     if (isset($ct) && $ct->trangthaictkm == 1) {
        //         $khuyenmai = $request->gia - ($request->gia * ($ct->phantramkhuyenmai / 100));

        //         $c->giakhuyenmai = $khuyenmai;
        //         $c->tensanpham = $request->tensanpham;
        //         $c->gia = $request->gia;
        //         $c->soluong = $request->soluong;
        //         $c->slug_sanpham = $request->slug_sanpham;
        //         $c->noidung = $request->noidung;
        //         $c->idthuonghieu = $request->idthuonghieu;
        //         $c->idram = $request->idram;
        //         $c->idmanhinh = $request->idmanhinh;
        //         $c->idluutru = $request->idluutru;
        //         $c->idloaisanpham = $request->idloaisanpham;
        //         $c->iddohoa = $request->iddohoa;
        //         $c->idCPU = $request->idCPU;
        //         $c->motasanpham = $request->motasanpham;
        //         $c->hot = $request->hot;
        //         $c->trangthai = $request->trangthai;


        //         $c->save();
        //     } else {

        //         $khuyenmai = $request->gia;

        //         $c->giakhuyenmai = $khuyenmai;
        //         $c->tensanpham = $request->tensanpham;
        //         $c->gia = $request->gia;
        //         $c->soluong = $request->soluong;
        //         $c->slug_sanpham = $request->slug_sanpham;
        //         $c->noidung = $request->noidung;
        //         $c->idthuonghieu = $request->idthuonghieu;
        //         $c->idram = $request->idram;
        //         $c->idmanhinh = $request->idmanhinh;
        //         $c->idluutru = $request->idluutru;
        //         $c->idloaisanpham = $request->idloaisanpham;
        //         $c->iddohoa = $request->iddohoa;
        //         $c->idCPU = $request->idCPU;
        //         $c->motasanpham = $request->motasanpham;
        //         $c->hot = $request->hot;
        //         $c->trangthai = $request->trangthai;
        //         $c->save();
        //     }

        //     //dd($c);
        //     return response()->json($c);
        // }

        // return response()->json(['error' => $validator->errors()]);
        $request->validate(
            [
                'tensanpham'=>'required|min:3|max:255',
                'slug_sanpham' => 'required|max:255',
                'img' => 'mimes:jpeg,png,svg',
                'motasanpham' => 'required|max:255',
                'noidung' => 'required',
                'gia'=>'numeric|min:10000',
                'soluong'=>'numeric|min:1',
            ],
            [
                'tensanpham.required'=>'Vui lòng nhập tên sản phẩm',
                'tensanpham.min'=>'Tên tối thiểu 3 ký tự',
                'tensanpham.max'=>'Tên quá dài',
                'slug_sanpham.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_sanpham.max' => 'Đường dẫn SEO quá dài',
                'img.mimes'=>'Định dạng hình không hợp lệ',
                'motasanpham.required' => 'Vui lòng nhập mô tả',
                'motasanpham.max' => 'Mô tả quá dài',
                'noidung.required' => 'Vui lòng nhập nội dung',
                'gia.min'=>'Giá tối thiểu là 10000đ',
                'soluong.min' => 'Số lượng tối thiểu là 1',


            ]
        );
        $c = Sanpham::findorfail($request->idsanpham);
        // dd($c);
        $ct = Chitietkhuyenmai::where('idsanpham', $c['idsanpham'])->first();
        $temp = $c->img;
        if ($request->img != null) {
            Storage::disk('local')->delete("public/img/$temp");
            $img = $c['idsanpham'] . '-' . $request->img->getClientOriginalName();
            $c['img'] = $img;
            $request->img->storeAs('public/img', $img);
        }

        if (isset($ct) && $ct->trangthaictkm == 1) {
            $khuyenmai = $request->gia - ($request->gia * ($ct->phantramkhuyenmai / 100));

            $c->giakhuyenmai = $khuyenmai;
            $c->tensanpham = $request->tensanpham;
            $c->gia = $request->gia;
            $c->soluong = $request->soluong;
            $c->slug_sanpham = $request->slug_sanpham;
            $c->noidung = $request->noidung;
            $c->idthuonghieu = $request->idthuonghieu;
            $c->idram = $request->idram;
            $c->idmanhinh = $request->idmanhinh;
            $c->idluutru = $request->idluutru;
            $c->idloaisanpham = $request->idloaisanpham;
            $c->iddohoa = $request->iddohoa;
            $c->idCPU = $request->idCPU;
            $c->motasanpham = $request->motasanpham;
            $c->hot = $request->hot;
            $c->trangthai = $request->trangthai;


            $c->save();
        } else {

            $khuyenmai = $request->gia;

            $c->giakhuyenmai = $khuyenmai;
            $c->tensanpham = $request->tensanpham;
            $c->gia = $request->gia;
            $c->soluong = $request->soluong;
            $c->slug_sanpham = $request->slug_sanpham;
            $c->noidung = $request->noidung;
            $c->idthuonghieu = $request->idthuonghieu;
            $c->idram = $request->idram;
            $c->idmanhinh = $request->idmanhinh;
            $c->idluutru = $request->idluutru;
            $c->idloaisanpham = $request->idloaisanpham;
            $c->iddohoa = $request->iddohoa;
            $c->idCPU = $request->idCPU;
            $c->motasanpham = $request->motasanpham;
            $c->hot = $request->hot;
            $c->trangthai = $request->trangthai;
            $c->save();
        }
        session()->flash('mess', 'Cập nhật thành công');
        return redirect('/admin/product');
    }
    public function destroy($id)
    {
        $data = Sanpham::find($id);
        //dd($data->img);
        if (Count(Sanpham::find($id)->chitietkm) == 0) {
            Storage::disk('local')->delete("public/img/$data->img");
            Sanpham::destroy($id);
            session()->flash('mess', 'đã xóa');
        } else {
            session()->flash('mess', 'Vui lòng xóa khuyến mãi trên sản phẩm trước');
        }
        return redirect('/admin/product');
    }
}
