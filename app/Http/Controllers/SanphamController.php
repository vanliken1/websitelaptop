<?php

namespace App\Http\Controllers;

use App\Models\CPU;
use App\Models\Dohoa;
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
    public function index(){
        $sanpham = Sanpham::all();
        $thuonghieu=Thuonghieu::all();
        $loaisp=Loaisp::all();
        $cpu=CPU::all();
        $ram=Ram::all();
        $dohoa=Dohoa::all();
        $luutru=Luutru::all();
        $manhinh=Manhinh::all();
        return view('admin.sanpham.index',['sanpham'=>$sanpham,'thuonghieu'=>$thuonghieu,'loaisp'=>$loaisp,'cpu'=>$cpu,'ram'=>$ram,'dohoa'=>$dohoa,'luutru'=>$luutru,'manhinh'=>$manhinh]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tensanpham' => 'required',
                'soluong'=>'numeric'
            ],
            [
                
                'tensanpham.required' => 'Chưa nhập tên',
                'soluong.numeric'=>'So luong ko dc âm',
            ]
        );
        if ($validator->passes()) {
            $data=$r->all();
            if($r->img != null){
            $img = $data['idsanpham'] . '-' . $r->img->getClientOriginalName();
            $data['img'] = $img;
            $r->img->storeAs('public/img', $img);
            }
            
            $u= Sanpham::create($data);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = Sanpham::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tensanpham' => 'required',
                'soluong'=>'numeric'
            ],
            [
                

                'tensanpham.required' => 'Chưa nhập tên',
                'soluong.numeric'=>'So luong ko dc âm',
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Sanpham::findorfail($request->idsanpham);
        $temp=$c->img;
        if ($request->img != null) {
            Storage::disk('local')->delete("public/img/$temp");
            $img = $c['idsanpham'] . '-' . $request->img->getClientOriginalName();
            $c['img'] = $img;
            $request->img->storeAs('public/img', $img);
        }
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
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        $data=Sanpham::find($id);
        //dd($data->img);
        
        Storage::disk('local')->delete("public/img/$data->img");
        Sanpham::destroy($id);
        session()->flash('mess', 'đã xóa');
        
        return redirect('/admin/product');
    }
}
