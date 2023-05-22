<?php

namespace App\Http\Controllers;

use App\Models\Chitietkhuyenmai;
use App\Models\Khuyenmai;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Validator;
use DB;

class KhuyenmaiController extends Controller
{
    public function index()
    {
        $khuyenmai = Khuyenmai::all();
        return view('admin.khuyenmai.index', ['khuyenmai' => $khuyenmai]);
    }
    public function storekm(Request $r)
    {
        // $data = $r->all();
        //dd($data);
        $validator = Validator::make(
            $r->all(),
            [
                'phantramkhuyenmai' => 'required',
                'idsanpham' => 'required',

            ],
            [

                'phantramkhuyenmai.required' => 'Chưa nhập tên',
                'idsanpham.required' => 'Không tồn tại sản phẩm',
            ]
        );
        if ($validator->passes()) {
            // $u = Chitietkhuyenmai::create($data);
            // dd($u);


            $u = Chitietkhuyenmai::create([
                'idkhuyenmai' => $r->idkhuyenmai,
                'phantramkhuyenmai' => $r->phantramkhuyenmai,
                'idsanpham' => $r->idsanpham,
                'trangthaictkm' => $r->trangthai,
            ]);

            $sanpham = Sanpham::find($r->idsanpham);
            if ($sanpham && $u->trangthaictkm == 1) {
                // Cập nhật giá khuyến mãi của sản phẩm
                $sanpham->giakhuyenmai = $sanpham->gia - ($sanpham->gia * ($u->phantramkhuyenmai / 100));
                $sanpham->save();
            } else {
                $sanpham->giakhuyenmai = $sanpham->gia;
                $sanpham->save();
            }
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tenkhuyenmai' => 'required',


            ],
            [


                'tenkhuyenmai.required' => 'Chưa nhập tên',

            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {

            $c = Khuyenmai::findorfail($request->idkhuyenmai);
            $c->tenkhuyenmai = $request->tenkhuyenmai;
            $c->ngaybatdau = $request->ngaybatdau;
            $c->ngayketthuc = $request->ngayketthuc;
           

            $c->save();
            //dd($c);
            return response()->json($c);
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function updatekm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'idkhuyenmai' => 'required',
                'idsanpham' => 'required',
            ],
            [


                'idkhuyenmai.required' => 'Chưa nhập tên',
                'idsanpham.required' => 'Không tồn tại sản phẩm',

            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
            Chitietkhuyenmai::where('idsanpham', $request->idsanpham)->update([
                'phantramkhuyenmai' => $request->phantramkhuyenmai,
                'trangthaictkm' => $request->trangthai
            ]);


            // // $c->phantramkhuyenmai = $request->phantramkhuyenmai;
            // // $c->trangthai = $request->trangthai;

            // // $c->save();
            $c = Chitietkhuyenmai::where('idsanpham', $request->idsanpham)->get();
            if ($c) {

                foreach ($c as $chitiet)
                    $sanpham = Sanpham::find($request->idsanpham);
                if ($sanpham && $chitiet->trangthaictkm == 1) {
                    $sanpham->giakhuyenmai = $sanpham->gia - ($sanpham->gia * ($chitiet->phantramkhuyenmai / 100));
                    $sanpham->save();
                } else {
                    $sanpham->giakhuyenmai = $sanpham->gia;
                    $sanpham->save();
                }
            }
            //dd($c);

            return response()->json($c);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenkhuyenmai' => 'required',

            ],
            [

                'tenkhuyenmai.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $u = Khuyenmai::create([
                'tenkhuyenmai' => $r->tenkhuyenmai,
                'ngaybatdau' => $r->ngaybatdau,
                'ngayketthuc' => $r->ngayketthuc,
                
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = Khuyenmai::findOrFail($id);
        return response()->json($data);
    }
    public function editkm($id)
    {
        // dd($id);
        $data = Chitietkhuyenmai::where('idsanpham', $id)->get();
        // $data=[$id];
        return response()->json($data);
    }

    public function chitiet($id)
    {
        // dd($id);
        $data = Chitietkhuyenmai::where('idkhuyenmai', $id)->get();
        //lay danh sach gia tri cot idsanpham sau do chuyen thanh mang
        $existingValues = Chitietkhuyenmai::pluck('idsanpham')->toArray();
        $arrSP = Sanpham::all();
        // dd($data);
        return view('admin.khuyenmai.chitietkm', ['data' => $data, 'id' => $id, 'existingValues' => $existingValues, 'arrsp' => $arrSP]);
    }
    public function destroykm($id)
    {
        $cc = Chitietkhuyenmai::where('idsanpham', $id)->get();
        $data = $cc[0]->idkhuyenmai;
        Chitietkhuyenmai::where('idsanpham', $id)->delete();;
        session()->flash('mess', 'đã xóa');
        $sanpham = Sanpham::find($id);
        if ($sanpham) {
            // Thực hiện cập nhật thông tin sản phẩm tại đây
            // Ví dụ: $sanpham->ten_thuoc_tinh = giá_trị_mới;
            // $sanpham->save();
            $sanpham->giakhuyenmai = $sanpham->gia;
            $sanpham->save();
        }
        return redirect("/admin/khuyenmai/chitiet/$data");
    }
    public function destroy($id)
    {
        $data = Khuyenmai::find($id);
        //dd($data->img);
        if (Count(Khuyenmai::find($id)->chitietkm) == 0) {
            Khuyenmai::destroy($id);
            session()->flash('mess', 'đã xóa');
        } else {
            session()->flash('mess', 'Vui lòng xóa khuyến mãi trên sản phẩm');
        }
        return redirect('/admin/khuyenmai');
        
    }
}
