<?php

namespace App\Http\Controllers;

use App\Models\Loaisp;
use Illuminate\Http\Request;
use Validator;
class LoaiSPController extends Controller
{
    //
    public function index(){
        $loaisp=Loaisp::all();
        return view('admin.Loaisp.index',['loaisp'=>$loaisp]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenloai' => 'required',
      


            ],
            [
                
                'tenloai.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $u=Loaisp::create([
                'tenloai'=>$r->tenloai,
                'slug_loai'=>$r->slug_loai,
                'motaloai'=>$r->motaloai,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = Loaisp::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenloai' => 'required',
                


            ],
            [
                
                
                'tenloai.required' => 'Chưa nhập tên',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Loaisp::findorfail($request->idloaisanpham);
        $c->tenloai = $request->tenloai;
        $c->slug_loai = $request->slug_loai;
        $c->motaloai = $request->motaloai;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(Loaisp::find($id)->products)==0){
            Loaisp::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('mess', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/category');
    }
}
