<?php

namespace App\Http\Controllers;

use App\Models\Thuonghieu;
use Illuminate\Http\Request;
use Validator;
class ThuonghieuController extends Controller
{
    //
    public function index(){
        $thuonghieu=Thuonghieu::all();
        return view('admin.thuonghieu.index',['thuonghieu'=>$thuonghieu]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenthuonghieu' => 'required',
      
            ],
            [
                
                'tenthuonghieu.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $u=Thuonghieu::create([
                'tenthuonghieu'=>$r->tenthuonghieu,
                'slug_thuonghieu'=>$r->slug_thuonghieu,
                'motathuonghieu'=>$r->motathuonghieu,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = Thuonghieu::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenthuonghieu' => 'required',
        
            ],
            [
                

                'tenthuonghieu.required' => 'Chưa nhập tên',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Thuonghieu::findorfail($request->idthuonghieu);
        $c->tenthuonghieu = $request->tenthuonghieu;
        $c->slug_thuonghieu = $request->slug_thuonghieu;
        $c->motathuonghieu = $request->motathuonghieu;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(Thuonghieu::find($id)->products)==0){
            Thuonghieu::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('mess', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/brand');
    }
}