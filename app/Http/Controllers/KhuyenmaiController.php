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
                'trangthai' => $r->trangthai,
            ]);
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
            $c->trangthai = $request->trangthai;

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
                'trangthai' => $request->trangthai
            ]);


            // $c->phantramkhuyenmai = $request->phantramkhuyenmai;
            // $c->trangthai = $request->trangthai;

            // $c->save();
            $c = Chitietkhuyenmai::where('idsanpham', $request->idsanpham)->get();
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
                'trangthai' => $r->trangthai,
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
        $arrSP=Sanpham::all();
        // dd($data);
        return view('admin.khuyenmai.chitietkm', ['data' => $data, 'id' => $id,'existingValues'=>$existingValues,'arrsp'=>$arrSP]);
    }
    public function destroy($id)
    {
        $cc=Chitietkhuyenmai::where('idsanpham', $id)->get();
        $data=$cc[0]->idkhuyenmai;
        Chitietkhuyenmai::where('idsanpham', $id)->delete();;
            session()->flash('mess', 'đã xóa');
        
        return redirect("/admin/khuyenmai/chitiet/$data");
    }
}
